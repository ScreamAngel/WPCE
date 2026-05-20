<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $file = $_FILES['profile_pic'];
    // Oturumda e-posta saklandığı için değişken adını karışıklık olmasın diye $email yapalım
    $email = $_SESSION['user'] ?? $_SESSION['admin']; 

    if (!$email) {
        die("Oturum bulunamadı.");
    }

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

    if (in_array($fileExt, $allowed)) {
        // Dosya ismini benzersiz yapalım
        $newFileName = "profile_" . time() . "_" . uniqid() . "." . $fileExt;
        $fileDestination = 'uploads/' . $newFileName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // KRİTİK DEĞİŞİKLİK: WHERE kısmını 'email' yaptık
            $sql = "UPDATE users SET profile_image = '$newFileName' WHERE email = '$email'";
            
            if (mysqli_query($conn, $sql)) {
                // Eğer veritabanı güncellendiyse
                if (mysqli_affected_rows($conn) > 0) {
                    header("Location: profila.php?update=success");
                } else {
                    // Dosya yüklendi ama DB güncellenmedi (muhtemelen email eşleşmedi)
                    echo "Hata: Veritabanında bu e-postaya ait bir kayıt güncellenemedi. E-posta: " . $email;
                }
            } else {
                echo "Sorgu Hatası: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Geçersiz dosya türü!";
    }
}
?>