<?php
// 1. Önce hiçbir hata vermeden oturumu garantileyecek zırhlı kod
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Hataları ekrana bassın ki kör uçuşu yapmayalım
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// 3. Veritabanına bağlanmadan ÖNCE yetkiyi kontrol ediyoruz (daha güvenli)
if (!isset($_SESSION['admin'])) {
    // Eğer yetki yoksa, oturumun içinde şu an NE OLDUĞUNU da bize göndersin
    echo json_encode([
        'hata' => 'Yetkisiz erişim.',
        'senin_oturum_bilgilerin' => $_SESSION 
    ]);
    exit;
}

// 4. Yetki varsa veritabanını içeri alıyoruz
require_once 'connection.php';

$sql = "SELECT DISTINCT gonderen FROM mesajlar WHERE alici = 'admin'";
$query = mysqli_query($conn, $sql);

$kullanicilar = [];
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $kullanicilar[] = $row['gonderen'];
    }
}
echo json_encode($kullanicilar);
?>