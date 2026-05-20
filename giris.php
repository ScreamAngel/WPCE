<?php
include("connection.php");
session_start();

$msg='';
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select1 = "SELECT * FROM `users` WHERE email = '$email'";
    $select_user = mysqli_query($conn, $select1);

    if(mysqli_num_rows($select_user) > 0){
        $row1 = mysqli_fetch_assoc($select_user);

        // password_verify yerine bunu kullanırsan SHA-256 ile çalışır
if (hash('sha256', $password) === $row1['password']) { 
    // Giriş başarılı

        if(strtolower($row1['user_type']) == 'user'){
            $_SESSION['user'] = $row1['email'];
            $_SESSION['id'] = $row1['id'];
            header('location:kullanici.php');
            exit();
        }
        else if(strtolower($row1['user_type']) == 'admin'){
          $_SESSION['admin'] = $row1['email'];
          $_SESSION['id'] = $row1['id'];
          header('location:admin.php');
          exit();
        
        }
    }else{
          $msg = "email veya şifre hatalı!";
        }
    }
        else{
            $msg = "email veya şifre hatalı!";
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
    <title>Giriş Yap</title>
</head>
<body>
    <div class=form>
        <form action="" method="post">
        <h2>Giriş Yap</h2>
        <div class="form-group">
            <input type="email" name="email" placeholder="Mailinizi Giriniz" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Şifrenizi Giriniz" class="form-control" required>
        </div>

        <?php if(!empty($msg)): ?>
            <p class="msg"><?php echo $msg; ?></p>
        <?php endif; ?>
        
        <button class="btn font-weight-bold" name="submit">Giriş Yap</button>
        <p>Bir hesabınız yok mu? <a href="kayit.php">Kayıt Olun</a><br>
        <p>Şifrenizi mi unuttunuz? <a href="sifre-sifirla.php">Şifre Sıfırla</a>
        <br>
        <p>Hesap olmadan devam edin: <a href="kullaniciM.php">Giriş Yap</a></p>
        <br>
        <audio id="oynatici" src="RE4.ogg" controls loop class="audio">
                 </audio>
                 <br>
        <label for="muzikSecimi">Arkaplan Müziği: </label>
        <select id="muzikSecimi" onchange="muzikDegistir()">
            <option value="RE4.ogg">Save Room Theme</option>
            <option value="RE4C.ogg">Chainsaw Theme</option>
            <option value="RE4W.ogg">Witness The Power</option>
            <option value="Call your name.ogg">Call Your Name</option>
            <option value="matrix.ogg">Matrix</option>
            <option value="asd.ogg">İsmi Yok</option>
        </select>
        

    </form>
    </div>

    <script>
        function muzikDegistir(){

        const oynatici = document.getElementById("oynatici");
        const secim = document.getElementById("muzikSecimi");

        // Oynatıcının özelliğni kullanarak müziğin kaynağını, menüden seçilen müziğin dosya yolu ile değiştiriyoruz
        oynatici.src = secim.value;

        // Değişikliğin algılanması için oynatıcıyı yeniden yüklüyoruz
        oynatici.load();

        // Yeni seçilen müziği otomatik olarak başlatıyoruz
        oynatici.play();
        }
        </script>
</body>
</html>