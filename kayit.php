<?php
include("connection.php");
session_start();
//Tanımlama
$msg='';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $soyad = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];
    $tel_no = $_POST['tel_no'];

    
    

    if ($password !== $cpassword) {
        $msg = "Şifreler eşleşmiyor!";
    }

    elseif(strlen($password) <= 5){
        $msg = "Şifre çok kısa! Güvenliğiniz için en az 6 karakter olmalıdır.";
    }

    elseif(strlen($tel_no) !== 11){
        $msg = "Telefon numarası 11 haneli olmalıdır!";
    } 

    elseif(!is_numeric($tel_no)){
        $msg = "Telefon numarası sadece rakamlardan oluşmalıdır!";
    }

    else {

        // SQL Injection koruması için verileri temizle
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $soyad = mysqli_real_escape_string($conn, $_POST['surname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password']; // Temizlemeye gerek yok, hashlenecek
        $tel_no = mysqli_real_escape_string($conn, $_POST['tel_no']);

        // --- YENİ EKLENEN GİZLİ SORU BÖLÜMÜ ---
        $gizli_soru = mysqli_real_escape_string($conn, $_POST['gizli_soru']);
        
        // Kullanıcı büyük/küçük harf unutur diye her şeyi küçük harfe çevirip boşlukları siliyoruz
        $ham_cevap = strtolower(trim($_POST['gizli_cevap']));
        $hashed_cevap = hash('sha256', $ham_cevap);
        // -------------------------------------

       // kayit.php içinde password_hash yerine bunu kullanmalısın (mevcut sistemine uyması için):
        $hashed_password = hash('sha256', $password);

        $check_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
        $check_tel = mysqli_query($conn, "SELECT * FROM `users` WHERE tel_no = '$tel_no'");
        
        if(mysqli_num_rows($check_email) > 0){
            $msg = "Bu e-posta adresi zaten kullanımda, lütfen farklı bir mail deneyin.";
        }

        elseif(mysqli_num_rows($check_tel) > 0){
            $msg = "Bu telefon numarası zaten kullanımda, lütfen farklı bir telefon numarası deneyin.";
        }
        
    else{
        $insert1 = "INSERT INTO `users`(`name`, `surname`, `email`, `password`, `user_type`, `tel_no`, `failed_attempts`, `profile_image`, `gizli_soru`, `gizli_cevap`) VALUES ('$name', '$soyad', '$email','$hashed_password','$user_type', '$tel_no', '0', 'default-avatar.png', '$gizli_soru', '$hashed_cevap')";

        if(mysqli_query($conn, $insert1)){
            /*header('location:giris.php');     Burayı sildim çünkü JS'de kodlanmış durumda
            exit;*/
            $success = true;
        }
        else{
            $msg = "Kayıt sırasında bir hata oluştu.";
        }
        
    }
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>Kayıt Ol</title>
</head>
<body>
    <div class=form>
        <form action="" method="post">
        <h2>Kayıt Ol</h2>
        <div class="form-group">
            <input type="text" name="name" placeholder="Adınızı Giriniz" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="text" name="surname" placeholder="Soyadınızı Giriniz" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Mailinizi Giriniz" class="form-control" required>
        </div>
        <div class="form-group">
            <select name="user_type" id="" class="form-control">
                <option value="user">Kullanıcı</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="tel_no" placeholder="Telefon Numaranızı Giriniz" class="form-control" maxlength="11" required>
        </div>
<!-- Bura yeni geldi -->
        <div class="form-group">
            <select name="gizli_soru" class="form-control" required>
                <option value="" disabled selected>Şifre Sıfırlama İçin Gizli Soru Seçin</option>
                <option value="ilk_oyun">Tamamen bitirdiğiniz ilk video oyunu nedir?</option>
                <option value="favori_silah">Oyunlarda en sık tercih ettiğiniz silah türü nedir?</option>
                <option value="ilk_evcil_hayvan">İlk evcil hayvanınızın adı nedir?</option>
                <option value="ilkokul_ogretmeni">İlkokul öğretmeninizin adı nedir?</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="gizli_cevap" placeholder="Gizli Sorunun Cevabı" class="form-control" required>
        </div>
        <!-- ============================================================================================================== -->

        <div class="form-group">
            <input type="password" name="password" placeholder="Şifrenizi Giriniz" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="password" name="cpassword" placeholder="Şifrenizi Doğrulayınız" class="form-control" required>
        </div>
        
        <?php if(!empty($msg)): ?>
            <p class="msg"><?php echo $msg; ?></p>
        <?php endif; ?>
        
        <button class="btn font-weight-bold" name="submit">Kayıt Ol</button>
        <p>Zaten hesabınız var mı? <a href="giris.php">Giriş Yapın</a>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--Tik animasyonu-->

<?php if(isset($success) && $success === true): ?>
<script>
    Swal.fire({
        title: 'SİSTEME GİRİŞ YETKİSİ VERİLDİ',
        text: 'Kullanıcı kaydı veritabanına başarıyla işlendi.',
        icon: 'success',
        background: '#0a0a0a', // Terminal Siyahı
        color: '#ffffff',
        confirmButtonColor: '#1793d1', // Arch Linux Mavisi
        confirmButtonText: 'Giriş Ekranına Git',
        backdrop: `rgba(0,0,0,0.8)` // Arka planı karart
    }).then((result) => {
        if (result.isConfirmed) {
            // Kullanıcı "Tamam" dediğinde giriş sayfasına yönlendir
            window.location.href = 'giris.php';
        }
    });
</script>
<?php endif; ?>
</body>
</html>