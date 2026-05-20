<?php
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'connection.php';

if (!isset($_SESSION['admin']) || !isset($_POST['kullanici'])) {
    exit;
}

$hedef_kullanici = mysqli_real_escape_string($conn, trim($_POST['kullanici']));

// Seçilen kullanıcıyla admin arasındaki tüm geçmişi tarihe göre çekiyoruz
$sql = "SELECT gonderen, mesaj_metni FROM mesajlar 
        WHERE (gonderen = '$hedef_kullanici' AND alici = 'admin') 
        OR (gonderen = 'admin' AND alici = '$hedef_kullanici') 
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
echo json_encode($mesajlar);
?>