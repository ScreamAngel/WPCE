<?php
// PHP'nin arka plandaki hataları HTML olarak basıp JSON'u bozmasını engelliyoruz
ini_set('display_errors', 0);
// Sayfanın JSON formatında çıktı vereceğini belirtiyoruz
header('Content-Type: application/json');

// --- 1. Veritabanı Bağlantısı ---
// Senin mevcut bağlantı dosyanı çağırıyoruz
require_once 'connection.php'; 

// --- TÜRKÇE KARAKTER DOSTU KÜÇÜK HARF FONKSİYONU ---
// mbstring eklentisi kapalı olsa bile %100 çalışır!
function kucukHarfYap($metin) {
    $buyuk = array('I', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç');
    $kucuk = array('ı', 'i', 'ğ', 'ü', 'ş', 'ö', 'ç');
    $metin = str_replace($buyuk, $kucuk, $metin);
    return strtolower($metin);
}

// --- 2. Mesajı İşleme ---
if (isset($_POST['message'])) {
    $userMessage = trim($_POST['message']);




// --- 1. ÖZEL KOMUT KONTROLLERİ (Geliştirilmiş) ---
    
    // strpos !== false kullanımı: Kelime cümlenin İÇİNDE geçiyorsa bile yakalar!
    // Yani kullanıcı "Sponsorlar kim?", "sponsor", " bana sponsorları say" yazsa bile çalışır.

    if (preg_match('/sponsor/iu', $userMessage)) {
        
        // Sadece sponsorlar tablosunu sorgula
        $sql = "SELECT sponsor_adi FROM sponsorlar";
        $query = mysqli_query($conn, $sql);
        
// EĞER VERİTABANINDA SPONSORLAR TABLOSU YOKSA BİZE BİLDİRECEK
        if (!$query) {
            echo json_encode(['reply' => 'Sponsor tablosu hatası: ' . mysqli_error($conn) . ' (phpMyAdminden tablo adını kontrol et)']);
            exit;
        }
        
        if (mysqli_num_rows($query) > 0) {
            $cevap = "İşte değerli sponsorlarımız:\n\n";
            while ($row = mysqli_fetch_assoc($query)) {
                $cevap .= "- " . $row['sponsor_adi'] . "\n";
            }
        } else {
            $cevap = "Şu an sistemde kayıtlı bir sponsor bulunmuyor.";
        }
        
        echo json_encode(['reply' => $cevap]);
        exit;
    }



    /*==================================================================================================================================*/

        if (preg_match('/link/iu', $userMessage) || preg_match('/website/iu', $userMessage)) {
        
        // Sadece sponsorlar tablosunu sorgula
        $sql = "SELECT website FROM sponsorlar";
        $query = mysqli_query($conn, $sql);
        
// EĞER VERİTABANINDA SPONSORLAR TABLOSU YOKSA BİZE BİLDİRECEK
        if (!$query) {
            echo json_encode(['reply' => 'Sponsor tablosu hatası: ' . mysqli_error($conn) . ' (phpMyAdminden tablo adını kontrol et)']);
            exit;
        }
        
        if (mysqli_num_rows($query) > 0) {
            $cevap = "İşte değerli sponsorlarımızın web siteleri:\n\n";
            while ($row = mysqli_fetch_assoc($query)) {
                $cevap .= "- " . $row['website'] . "\n";
            }
        } else {
            $cevap = "Şu an sistemde kayıtlı bir sponsor bulunmuyor.";
        }
        
        echo json_encode(['reply' => $cevap]);
        exit;
    }



    /*=======================================================================================================================================*/


    // Güvenlik için mesajı temizliyoruz (SQL Injection koruması)
    $temizMesaj = mysqli_real_escape_string($conn, $userMessage);
    $aranan = "%" . $temizMesaj . "%";

    // --- ÖNEMLİ NOT ---
    // 'hatalar' tablo adını ve 'hata_kodu', 'hata_adi', 'cozum' 
    // sütun adlarını phpMyAdmin'deki kendi isimlerine göre değiştirmelisin!
    
    // MySQLi ile Güvenli Sorgu Hazırlama (SQL Injection Korumalı)
    $sql = "SELECT cozum FROM error_codes WHERE error_code LIKE '$aranan' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    
// EĞER VERİTABANINDA BİR SORUN VARSA (Tablo yoksa, sütun adı yanlışsa vb.)
    if (!$query) {
        $hataMesaji = mysqli_error($conn);
        // Botumuz bize veritabanı hatasını mesaj olarak atacak!
        echo json_encode(['reply' => 'Veritabanı hatası buldum: ' . $hataMesaji . ' (Lütfen phpMyAdmin\'den tablo ve sütun adlarını kontrol et)']);
        exit;
    }

    $sonuc = mysqli_fetch_assoc($query);

    // --- Cevap Üretme ---
    if ($sonuc) {
        $cevap = "Bu hatayı sistemimde buldum. Çözümü: \n\n" . $sonuc['cozum'];
    } else {
        $cevap = "Şu anki veritabanımda bu konuyla ilgili bir sonuç bulamadım. Çok yakında yapay zeka eklenecek!";
    }

    echo json_encode(['reply' => $cevap]);

} else {
    echo json_encode(['reply' => 'Lütfen bana bir soru sorun.']);
}



?>

