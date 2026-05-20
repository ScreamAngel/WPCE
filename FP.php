<?php
include("connection.php");
session_start();

$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($user_session || $admin_session)) {
    header('Location: giris.php'); 
    exit;
}

// Önce oturumdaki veriyi bir değişkene atayalım
$email = $_SESSION['user'] ?? $_SESSION['admin'] ?? null;

$query = mysqli_query($conn, "SELECT profile_image FROM users WHERE email = '$email'");
$user_data = mysqli_fetch_assoc($query);
$user_photo = (!empty($user_data['profile_image'])) ? $user_data['profile_image'] : "default-avatar.png";

$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>İhtiyaç Seçimi</title>
        <style>
        /* Ticker Konteynırı */
.ticker-wrapper {
    margin-left:-10px;
    width: 101%;
    background-color: rgba(0, 0, 0, 0.9); /* Arka plan siyah */
    border-top: 2px solid #ff0000;
    border-bottom: 2px solid #ff0000;
    overflow: hidden; /* Dışarı taşan yazıları gizle */
    position: fixed;
    bottom: 0;
    white-space: nowrap;
    padding: 10px 0;
    z-index: 999;
}

/* Kayan Yazı Stili */
.ticker-text {
    display: inline-block;
    padding-left: 100%; /* Başlangıç pozisyonu */
    animation: ticker-animation 25s linear infinite; /* 25 saniyede bir döngü */
}

.ticker-text span {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    font-weight: bold;
    color: #ff0000; /* İstediğin kırmızı renk */
    padding: 0 50px;
    text-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
}

/* Animasyon Tanımı */
@keyframes ticker-animation {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

/* Mouse ile üzerine gelince durması için */
.ticker-wrapper:hover .ticker-text {
    animation-play-state: paused;
}
</style>
</head>
<body>
    <header>
        <nav>
                    <div id="logo-container" style="cursor:pointer;">
       <a href="kullanici.php"><img id="site-logo" src="oyun-avcısı.jpg" width="30%" height="30%" title="Oyun-Avcısı.com" alt="Oyun-Avcısı.com"></a>
</div>
            <div class="menu">
            <ul>
                <li><div class="sekme">
                <a href="kullanici.php"><button class="sekme-tusu">Anasayfa</button></a>
                </div>
                </li>


                <li><div class="sekme">
                <a href="servislerimiz.php"><button class="sekme-tusu">Mağazalarımız</button></a>
                </div>
                </li>

                <li>
                <div class="sekme">
                <button class="sekme-tusu" style="padding: 5px 10px; display: flex; align-items: center; justify-content: center;">
                <img src="uploads/<?php echo $user_photo; ?>?t=<?php echo time(); ?>"
                 alt="Profil" 
                  style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; /* İşte sihirli dokunuş bu! */ object-position: center; /* Resmi ortalar */ border: 2px solid #89b4fa;">
                  &nbsp<?php echo $_SESSION['user']; ?>
                </button>
                <div class="sekme-icerik">
                        <a href="profil.php">Profil</a>
                        <a href="cikis.php">Çıkış Yap</a>
                </div>
                </div>
                </li>
            </div>
        </nav>
    </header><br><br>
    <h2 class="pop">İhtiyacınız Olanı Seçin</h2>
    <br><br><br><br>
    
      <div class="grid-container">
        <a href="FPL1.php">
        <div class="resim-karti">
          <img src="FP1S.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS TUF F16 FX607VJB-RL123W<br>Intel Core i5 210H / 16 GB RAM<br>512 GB SSD / NVIDIA GeForce RTX 3050 Gaming Laptop<br><h2>TÜKENDİ</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="FPL2.php">
        <div class="resim-karti">
          <img src="FP1.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS TUF F16 FX607VJ-RL805W<br>Intel Core 5 210H / 8 GB RAM<br>512 GB SSD / NVIDIA Geforce RTX 3050 / 16"<br>W11 Gaming Laptop<br><h2>39.499 TL</h2></h3>

          </div>
          </div>
          </a>

        <a href="FPL3.php">
        <div class="resim-karti">
          <img src="FP2.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS TUF A15 FA506NCR-HN007W003<br>Ryzen7 7435HS / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 3050 / 15,6"<br>W11 Gaming Laptop<br><h2>50.097 TL</h2></h3>
            
          </div>
        </div>
        </a>

                <a href="https://www.youtube.com/watch?v=u3wS-Q2KBpk">
            <div class="resim-karti">
                <img src="RE2.jpg" alt="Reklam: Resident Evil 2 Remake">
                <div class="hover-bilgi">
                    <h3>Reklam: Resident Evil 2 Remake</h3>
</div>
</div>
</a>
</div>

        <div class="grid-container">

        <a href="FPL4.php">
        <div class="resim-karti">
          <img src="FP3.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS TUF F16 FX608JH-RV010<br>Intel Core i5-13450HX / 16 GB RAM<br>512 GB SSD / NVIDIA Geforce RTX 5050 / 16"<br>FreeDOS Gaming Laptop<br><h2>56.859 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="FPL5.php">
        <div class="resim-karti">
          <img src="FP1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS TUF F16 FX607VU-RL073W<br>Core 5-210H / 16GB RAM<br>512GB SSD / NVIDIA Geforce RTX 4050 / 16"<br>W11 Gaming Laptop<br><h2>51.356 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="FPL6.php">
        <div class="resim-karti">
          <img src="FP6S.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ACER PHN16-72<br>Core i7-14650HX / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX4060 / 16"<br>W11 Gaming Laptop<br><h2>TÜKENDİ</h2></h3>

          </div>
          </div>
          </a>


        <a href="https://www.youtube.com/watch?v=E69tKrfEQag">
        <div class="resim-karti">
        <img src="RE4.jpg" alt="Reklam: Resident Evil 4 Remake">
        <div class="hover-bilgi">
        <h3>Reklam: Resident Evil 4 Remake</h3>
        </div>
        </div>
        </a>
</div>


        <div class="grid-container">

        <a href="FPL7.php">
        <div class="resim-karti">
          <img src="FP5.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>MSI Cyborg 15 A13VF-893XTR<br> Intel Core i7 13620H / 16 GB RAM<br>512 GB SSD / NVIDIA Geforce RTX4060 / 15,6"<br>FreeDOS<br><h2>68.012 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="FPL8.php">
        <div class="resim-karti">
          <img src="FP1.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS TUF F16 FX607VU-RL017<br>Intel Core i5 210H / 16 GB RAM<br>512 GB SSD / NVIDIA Geforce RTX4050 / 16"<br>FreeDOS Gaming Laptop<br><h2>48.299 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="FPL9.php">
        <div class="resim-karti">
          <img src="FP1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS TUF A16 FA607NUG-RL125<br>AMD Ryzen 7 7445HS / 16 GB RAM<br>512 GB SSD / NVIDIA Geforce RTX4050 / 16"<br>FreeDOS Gaming Laptop<br><h2>48.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="https://www.youtube.com/watch?v=fXVy4mALHLY">
            <div class="resim-karti">
                <img src="RE9.jpg" alt="Reklam: Resident Evil Rquiem">
                <div class="hover-bilgi">
                    <h3>Reklam: Resident Evil Requiem</h3>
</div>
</div>
</a>
        
        </div>
        <br>
        <br>
        <center><a href="GL.php"><button class="don">Geri Dön</button></a></center>
        <br>
        <br>
        <br>
        <br>

<br>
<div class="ticker-wrapper">
    <div class="ticker-text">
        <span>🔴 SON DAKİKA: NVIDIA 591.xx Sürücüsü Yayınlandı!</span>
        <span>|</span>
        <span>🚀 Arch Linux Kernel 6.x Güncellemesi Erişime Açıldı.</span>
        <span>|</span>
        <span>⚠️ KRİTİK: Yeni Windows Güncellemesi BSOD Hatalarına Yol Açıyor!</span>
        <span>|</span>
        <span>🔴 SON DAKİKA: RAM Krizinden Kaynaklı PC Fiyatlarında Büyük Artış Görüldü.</span>
        <span>|</span>
        <span>🧠 BİLGİ: Windows 10 LTSC Sürümü 2030'a Kadar Destek Almaya Devam Edecek</span>
        <span>|</span>
        <span>🧠 BİLGİ: Windows Sisteminizde CMD'yi Yönetici Açıp "sfc /scannow" Komutunu Denediniz Mi?</span>
        <span>|</span>
        <span>🐧 LİNUX: Linux'te Sıkıntısız Oyun Oynamak İsterseniz Arch Linux Kullanabilirsiniz</span>
    </div>
</div>

<script>
  
    console.log(`%c
       /\\
      /  \\
     /\\   \\
    /      \\
   /   ,,   \\
  /   |  |   \\
 /   /    \\   \\
/___/      \\___\\
I use Arch btw.`, "color: #1793d1; font-weight: bold;");

</script>
    
</body>
</html>
