<?php
// PHP'nin arka plandaki hataları HTML olarak basıp JSON'u bozmasını engelliyoruz
ini_set('display_errors', 0);
// Sayfanın JSON formatında çıktı vereceğini belirtiyoruz
header('Content-Type: application/json');

// --- 1. Veritabanı Bağlantısı ---
// Senin mevcut bağlantı dosyanı çağırıyoruz
require_once 'connection.php'; 


// PHP hatalarını gizleyip sadece JSON dönmesini garantiye alıyoruz
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Kullanıcıdan gelen mesajı kontrol et
if (!isset($_POST['message']) || empty(trim($_POST['message']))) {
    echo json_encode(['reply' => 'Lütfen geçerli bir mesaj gönderin.']);
    exit;
}

$userMessage = trim($_POST['message']);

// Gemini API ile İletişim Kuran Fonksiyon
function askGemini($prompt) {
    // Kendi API anahtarını buraya yapıştır!
    $apiKey = "AIzaSyC-UCFFKulyWyIbMX9IM4lM9m6QQGhx5r8"; 
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

    // API'nin beklediği veri yapısı
    $data = [
        "contents" => [
            ["parts" => [["text" => $prompt]]]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    // Arch Linux veya localhost ortamlarında SSL sertifika hatalarını es geçmek için
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch);
    
    // Eğer cURL tarafında (sunucu/bağlantı) bir hata varsa yakala
    if(curl_errno($ch)) {
        return "Sunucu Bağlantı Hatası: " . curl_error($ch);
    }
    
    curl_close($ch);
    
    $result = json_decode($response, true);

    // API'den gelen JSON yanıtının içinden sadece metni ayıkla
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        // Eğer API limitine takılırsan veya yanlış API Key girersen burası çalışır
        $errorMsg = $result['error']['message'] ?? 'Bilinmeyen bir API hatası oluştu.';
        return "Bot şu an yanıt veremiyor. Hata detayı: " . $errorMsg;
    }
}

// ---------------------------------------------------------
// 1. AŞAMA: Mesajı API'ye gönder ve cevabı al
$botReply = askGemini($userMessage);

// ---------------------------------------------------------
// (İleride MySQL kayıt kodlarını tam buraya, 2. aşama olarak ekleyeceğiz)
// ---------------------------------------------------------

// 3. AŞAMA: Cevabı frontend (Kullanıcı.php) tarafına yolla
echo json_encode(['reply' => $botReply]);
?>

