<?php
include("connection.php");
session_start();

$msg = '';
$step = 1; // Sayfanın hangi aşamada olduğunu takip eder (1: E-posta sor, 2: Gizli cevabı sor)
$user_email = '';
$gizli_soru_anahtar = '';

// Veritabanındaki kısa kodları, ekranda okunacak uzun sorulara çeviren sözlüğümüz
$sorular_sozlugu = [
    'ilk_oyun' => 'Tamamen bitirdiğiniz ilk video oyunu nedir?',
    'favori_silah' => 'Oyunlarda en sık tercih ettiğiniz silah türü nedir?',
    'ilk_evcil_hayvan' => 'İlk evcil hayvanınızın adı nedir?',
    'ilkokul_ogretmeni' => 'İlkokul öğretmeninizin adı nedir?'
];

// 1. AŞAMA: E-posta kontrolü
if(isset($_POST['check_email'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
    if(mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);
        $user_email = $user['email'];
        $gizli_soru_anahtar = $user['gizli_soru'];
        $step = 2; // E-posta bulunduysa 2. aşamaya (Soru ekranına) geç
    } else {
        $msg = "Sistemimizde bu e-posta adresine ait bir ajan (kullanıcı) bulunamadı.";
    }
}

// 2. AŞAMA: Cevap kontrolü ve Şifre sıfırlama
if(isset($_POST['reset_password'])){
    $email = mysqli_real_escape_string($conn, $_POST['hidden_email']);
    
    // Kullanıcının girdiği cevabı kayıt ekranındaki gibi temizleyip hashliyoruz
    $ham_cevap = strtolower(trim($_POST['gizli_cevap']));
    $hashed_cevap = hash('sha256', $ham_cevap);
    
    $new_password = $_POST['new_password'];
    $hashed_password = hash('sha256', $new_password);

    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
    if(mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);
        
        // Veritabanındaki cevap ile kullanıcının girdiği cevap eşleşiyor mu?
        if($user['gizli_cevap'] === $hashed_cevap){
            
            // Şifreyi güncelle
            $update = "UPDATE `users` SET password = '$hashed_password' WHERE email = '$email'";
            if(mysqli_query($conn, $update)){
                $success = true;
            } else {
                $msg = "Şifre güncellenirken kritik bir sistem hatası oluştu.";
            }
            
        } else {
            $msg = "Güvenlik protokolü ihlali: Gizli cevabınız yanlış!";
            $step = 2; // Yanlış girerse tekrar aynı soruda kalsın
            $user_email = $user['email'];
            $gizli_soru_anahtar = $user['gizli_soru'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>Şifremi Unuttum | WPCE</title>
</head>
<body>
    <div class="form">
        
        <?php if($step == 1): ?>
        <form action="" method="post">
            <h2>Şifre Sıfırlama</h2>
            <p style="color: #ccc; font-size: 14px; text-align: center; margin-bottom: 20px;">
                Hesabınızı bulmamız için lütfen kayıtlı e-posta adresinizi girin.
            </p>
            
            <div class="form-group">
                <input type="email" name="email" placeholder="Mailinizi Giriniz" class="form-control" required>
            </div>
            
            <?php if(!empty($msg)): ?>
                <p class="msg" style="color: #ff4d4d; font-weight: bold;"><?php echo $msg; ?></p>
            <?php endif; ?>
            
            <button class="btn font-weight-bold" name="check_email">İleri</button>
            <p>Şifrenizi hatırladınız mı? <a href="giris.php">Giriş Yapın</a></p>
        </form>
        <?php endif; ?>


        <?php if($step == 2): ?>
        <form action="" method="post">
            <h2>Kimlik Doğrulama</h2>
            <p style="color: #1793d1; font-weight: bold; text-align: center; margin-bottom: 10px;">
                E-posta: <?php echo $user_email; ?>
            </p>
            
            <input type="hidden" name="hidden_email" value="<?php echo $user_email; ?>">
            
            <div class="form-group" style="background: rgba(0,0,0,0.5); padding: 10px; border-radius: 5px;">
                <label style="color: #fff; font-size: 14px;">Güvenlik Sorunuz:</label><br>
                <strong style="color: #ffcc00;">
                    <?php echo isset($sorular_sozlugu[$gizli_soru_anahtar]) ? $sorular_sozlugu[$gizli_soru_anahtar] : 'Bilinmeyen Soru'; ?>
                </strong>
            </div><br>

            <div class="form-group">
                <input type="text" name="gizli_cevap" placeholder="Cevabınızı Giriniz" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group" style="margin-top: 25px;">
                <input type="password" name="new_password" placeholder="Yeni Şifrenizi Belirleyin" class="form-control" required minlength="6">
            </div>
            
            <?php if(!empty($msg)): ?>
                <p class="msg" style="color: #ff4d4d; font-weight: bold;"><?php echo $msg; ?></p>
            <?php endif; ?>
            
            <button class="btn font-weight-bold" name="reset_password">Şifreyi Güncelle</button>
            <p><a href="giris.php">Giriş Ekranına Dön</a></p>
        </form>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(isset($success) && $success === true): ?>
    <script>
        Swal.fire({
            title: 'ERİŞİM SAĞLANDI',
            text: 'Şifreniz veri tabanında başarıyla güncellendi.',
            icon: 'success',
            background: '#0a0a0a', 
            color: '#ffffff',
            confirmButtonColor: '#1793d1', 
            confirmButtonText: 'Giriş Yap',
            backdrop: `rgba(0,0,0,0.8)` 
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'giris.php';
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>