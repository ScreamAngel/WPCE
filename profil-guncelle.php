<?php
include("connection.php");
session_start();

// Güvenlik: Giriş yapmamış biri bu sayfaya doğrudan erişmeye çalışırsa giriş ekranına at
$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;
if (!($user_session || $admin_session)) {
    header('Location: giris.php');
    exit;
}

$email = $_SESSION['user'] ?? $_SESSION['admin'] ?? null;
$msg = '';

// Kullanıcının mevcut durumunu kontrol et (Zaten sorusu varsa bu sayfada işi yok, anasayfaya yolla)
$check_query = mysqli_query($conn, "SELECT gizli_soru FROM users WHERE email = '$email'");
$user_check = mysqli_fetch_assoc($check_query);
if (!empty($user_check['gizli_soru'])) {
    header('Location: kullanici.php');
    exit;
}

if(isset($_POST['submit'])){
    $gizli_soru = mysqli_real_escape_string($conn, $_POST['gizli_soru']);
    
    // Cevabı küçük harfe çevirip boşlukları temizleyerek hashliyoruz
    $ham_cevap = strtolower(trim($_POST['gizli_cevap']));
    $hashed_cevap = hash('sha256', $ham_cevap);

    if(empty($gizli_soru) || empty($ham_cevap)){
        $msg = "Lütfen güvenlik sorusunu ve cevabını eksiksiz doldurun.";
    } else {
        // Veritabanını güncelle
        $update_query = "UPDATE `users` SET `gizli_soru` = '$gizli_soru', `gizli_cevap` = '$hashed_cevap' WHERE email = '$email'";
        
        if(mysqli_query($conn, $update_query)){
            $success = true;
        } else {
            $msg = "Sistem güncellemesi sırasında bir hata oluştu.";
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
    <title>Güvenlik Güncellemesi | WPCE</title>
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h2 style="color: #ffcc00;"><i class="fa-solid fa-shield-halved"></i> Protokol Güncellemesi</h2>
            <p style="color: #ccc; font-size: 14px; text-align: center; margin-bottom: 25px;">
                Sistem güvenliğiniz için hesabınıza bir adet <strong>Gizli Soru</strong> tanımlamanız gerekmektedir. Bu adım tamamlanmadan panele erişim sağlanamaz.
            </p>
            
            <div class="form-group">
                <select name="gizli_soru" class="form-control" required>
                    <option value="" disabled selected>Bir Güvenlik Sorusu Seçin</option>
                    <option value="ilk_oyun">Tamamen bitirdiğiniz ilk video oyunu nedir?</option>
                    <option value="favori_silah">Oyunlarda en sık tercih ettiğiniz silah türü nedir?</option>
                    <option value="ilk_evcil_hayvan">İlk evcil hayvanınızın adı nedir?</option>
                    <option value="ilkokul_ogretmeni">İlkokul öğretmeninizin adı nedir?</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="text" name="gizli_cevap" placeholder="Sorunun Cevabını Yazınız" class="form-control" required autocomplete="off">
            </div>
            
            <?php if(!empty($msg)): ?>
                <p class="msg" style="color: #ff4d4d; font-weight: bold;"><?php echo $msg; ?></p>
            <?php endif; ?>
            
            <button class="btn font-weight-bold" name="submit" style="background-color: #ffcc00; color: #000;">Protokolü Onayla</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(isset($success) && $success === true): ?>
    <script>
        Swal.fire({
            title: 'GÜVENLİK PROTOKOLÜ AKTİF',
            text: 'Gizli sorunuz veritabanına başarıyla işlendi. Giriş izni verildi.',
            icon: 'success',
            background: '#0a0a0a', 
            color: '#ffffff',
            confirmButtonColor: '#1793d1', 
            confirmButtonText: 'Sisteme Devam Et',
            backdrop: `rgba(0,0,0,0.8)`
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'kullanici.php';
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>