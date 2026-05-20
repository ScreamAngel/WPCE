<?php
// Tıpkı mesaj gönderirken yaptığımız gibi, en tepeye hiçbir şarta bağlamadan oturumu koyuyoruz.
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');

require_once 'connection.php';

// Kullanıcı giriş yapmamışsa
if (!isset($_SESSION['user'])) {
    echo json_encode(['hata' => 'Oturum bulunamadi. Lütfen sayfayı yenileyip tekrar giriş yapın.']);
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);

$sql = "SELECT gonderen, mesaj_metni FROM mesajlar 
        WHERE (gonderen = '$user' AND alici = 'admin') 
        OR (gonderen = 'admin' AND alici = '$user') 
        ORDER BY tarih ASC";
        
$query = mysqli_query($conn, $sql);

$mesajlar = [];

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $mesajlar[] = [
            'kimden' => ($row['gonderen'] === 'admin') ? 'admin' : 'user',
            'metin' => $row['mesaj_metni']
        ];
    }
}

// Eğer mesaj yoksa boş liste ([]) dönecek, JavaScript hata vermeyecek.
echo json_encode($mesajlar);
?>