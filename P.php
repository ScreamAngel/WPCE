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
        <a href="PL1.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS Rog Strix G16 G615JMR-S5142W<br>Intel Core i7-14650HX / 16 GB RAM<br>512 GB SSD / NVIDIA GeForce RTX 5060 / 16"<br>W11 Gaming Laptop<br><h2>92.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL2.php">
        <div class="resim-karti">
          <img src="P2.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS ROG Zephyrus G16 GU605CM-QR063<br>Intel Core Ultra 7 255H / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 16"<br>FreeDOS Gaming Laptop<br><h2>125.399 TL</h2></h3>

          </div>
          </div>
          </a>

        <a href="PL3.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G16 G615JMR-S5048A016<br>Intel Core i7-14650HX / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 16"<br>W11 Gaming Laptop<br><h2>102.122 TL</h2></h3>
            
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

        <a href="PL4.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G16 G615JMR-S5048A006<br>Intel Core i7-14650HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 16"<br>FreeDOS Gaming Laptop<br><h2>111.636 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="PL5.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G16 G615JMR-S5048A015<br>Intel Core i7-14650HX / 16GB RAM<br>512GB SSD / NVIDIA Geforce RTX 5060 / 16"<br>W11P Gaming Laptop<br><h2>97.364 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL6.php">
        <div class="resim-karti">
          <img src="P3.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G18 G814PP-S9002<br>AMD Ryzen 9 8940HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5070 / 18"<br>FreeDOS Gaming Laptop<br><h2>126.899 TL</h2></h3>

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

        <a href="PL7.php">
        <div class="resim-karti">
          <img src="P3.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G18 G814PP-S9045<br> AMD Ryzen 9 8940HX / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5070 / 18"<br>FreeDOS<br><h2>114.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL8.php">
        <div class="resim-karti">
          <img src="P4.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>MSI Katana 17 HX B14WFK-216XTR<br>Intel Core i7-14650HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5070 / 17,3"<br>FreeDOS Gaming Laptop<br><h2>84.982 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="PL9.php">
        <div class="resim-karti">
          <img src="P4.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>MSI Katana 17 HX B14WFK-252XTR<br>Intel Core i7-14650HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 17,3"<br>FreeDOS Gaming Laptop<br><h2>84.982 TL</h2></h3>
            
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
