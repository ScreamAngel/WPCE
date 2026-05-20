<?php
// Oturum bilgilerine (gönderen kişiye) ulaşmak için session_start şart
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');

require_once 'connection.php';

// Güvenlik: Kullanıcı giriş yapmamışsa mesaj atamasın
if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen önce giriş yapın.']);
    exit;
}

if (isset($_POST['message'])) {
    $mesaj = trim($_POST['message']);
    
    if (empty($mesaj)) {
        echo json_encode(['status' => 'error', 'message' => 'Boş mesaj gönderilemez.']);
        exit;
    }

    // Gönderen kişi oturum açmış olan kullanıcı, alıcı ise her zaman 'admin'
    $gonderen = mysqli_real_escape_string($conn, $_SESSION['user']);
    $alici = 'admin';
    $temizMesaj = mysqli_real_escape_string($conn, $mesaj);

    // Mesajı veritabanına kaydediyoruz (tarih ve okundu_mu SQL tarafından otomatik halledilecek)
    $sql = "INSERT INTO mesajlar (gonderen, alici, mesaj_metni) VALUES ('$gonderen', '$alici', '$temizMesaj')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // İşlem başarılıysa JS'ye sadece "onay" dönüyoruz
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Veritabanı hatası: ' . mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']);
}
?>