<?php
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Session başlat ve veritabanını bağla
session_start();
require_once 'connection.php';

// Oturum açmış kullanıcı yoksa misafir olarak kaydet
$user_email = $_SESSION['user'] ?? 'misafir';

if (!isset($_POST['message']) || empty(trim($_POST['message']))) {
    echo json_encode(['reply' => 'Lütfen geçerli bir mesaj gönderin.']);
    exit;
}

$userMessage = trim($_POST['message']);

// =========================================================================
// 1. AŞAMA: HAFIZAYI ÇEK (Veritabanından son 6 mesajı alıyoruz)
// =========================================================================
$history_query = mysqli_query($conn, "SELECT role, message FROM chat_history WHERE user_email = '$user_email' ORDER BY id DESC LIMIT 6");
$past_messages = [];

if ($history_query) {
    while($row = mysqli_fetch_assoc($history_query)) {
        $past_messages[] = [
            "role" => $row['role'], 
            "parts" => [["text" => $row['message']]]
        ];
    }
}
// SQL DESC (sondan başa) sıraladığı için diziyi tersine çevirip kronolojik yapıyoruz
$past_messages = array_reverse($past_messages);

// Kullanıcının yeni mesajını da sohbet geçmişinin sonuna ekliyoruz
$past_messages[] = [
    "role" => "user", 
    "parts" => [["text" => $userMessage]]
];

// =========================================================================
// 2. AŞAMA: GEMINI API'YE GEÇMİŞLE BİRLİKTE SOR
// =========================================================================
function askGeminiWithHistory($messages) {
    $apiKey = "Buraya kendi API Key'inizi giriniz"; 
    $url = "Burada kullanmak istediğiniz yapay zeka botunun URL'sini giriniz" . $apiKey;

    // Artık sadece tek mesaj değil, tüm sohbet dizisini gönderiyoruz
    $data = [
        "contents" => $messages
    ];

    $ch = curl_init($url); // cURL (Kurye) çağırma ve gönderme
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Gelen cevap hemen ekrana gelmez
    curl_setopt($ch, CURLOPT_POST, true); // POST işlemi ile veri götürüyoruz
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));// JSON formatına dönüştürüp gönder
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // JSON formatında veri geldiğini belirtiriz
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL sertifikası kontrolünü kapatır

    $response = curl_exec($ch); // cURL işlemini çalıştırır
    curl_close($ch); // cURL işlemini kapatır
    
    $result = json_decode($response, true); // JSON formatında gelen cevabı PHP dizisine dönüştürür

    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) { // Cevap başarılı bir şekilde gelmiş mi kontrol eder
        return $result['candidates'][0]['content']['parts'][0]['text']; // Cevabı döndürür
    } else { 
        return "Bot şu an yanıt veremiyor. Hafıza aşırı dolmuş olabilir.";
    }
}

$botReply = askGeminiWithHistory($past_messages);

// =========================================================================
// 3. AŞAMA: KONUŞMAYI VERİTABANINA KAYDET (Gelecek sorular için)
// =========================================================================
$stmt = $conn->prepare("INSERT INTO chat_history (user_email, role, message) VALUES (?, ?, ?)");

// Kullanıcının sorusunu kaydet
$role_user = 'user';
$stmt->bind_param("sss", $user_email, $role_user, $userMessage);
$stmt->execute();

// Botun verdiği cevabı kaydet
$role_bot = 'model';
$stmt->bind_param("sss", $user_email, $role_bot, $botReply);
$stmt->execute();

// =========================================================================
// 4. AŞAMA: CEVABI KULLANICIYA GÖNDER
// =========================================================================
echo json_encode(['reply' => $botReply]);
?>
