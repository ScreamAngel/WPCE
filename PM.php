<?php
include("connection.php");
session_start();

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
   nav {
  display: flex;
  justify-content: space-between;
  height: 100%;
  align-items: center;
  margin-right: 25px;
}

.sekme-icerik {
  display: none;
  position: absolute;
  background-color: white;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  width: 130px;
  z-index: 1;
  transition: 0.3s;
  border-radius: 10px;
}
</style>
</head>
<body>
    <header>
        <nav>
                    <div id="logo-container" style="cursor:pointer;">
       <img id="site-logo" src="oyun-avcısı.jpg" width="30%" height="30%" title="Oyun-Avcısı.com" alt="Oyun-Avcısı.com">
</div>
      
            <div class="menu">
            <ul>
                <li><div class="sekme">
                <a href="kullaniciM.php"><button class="sekme-tusu">Anasayfa</button></a>
                </div>
                </li>



                <li>
                <div class="sekme">
                <button class="sekme-tusu">
                <i class="fa-solid fa-circle-user"></i>&nbsp;Misafir
                </button>
                <div class="sekme-icerik">
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
        <a href="PL1M.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS Rog Strix G16 G615JMR-S5142W<br>Intel Core i7-14650HX / 16 GB RAM<br>512 GB SSD / NVIDIA GeForce RTX 5060 / 16"<br>W11 Gaming Laptop<br><h2>92.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL2M.php">
        <div class="resim-karti">
          <img src="P2.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS ROG Zephyrus G16 GU605CM-QR063<br>Intel Core Ultra 7 255H / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 16"<br>FreeDOS Gaming Laptop<br><h2>125.399 TL</h2></h3>

          </div>
          </div>
          </a>

        <a href="PL3M.php">
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

        <a href="PL4M.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G16 G615JMR-S5048A006<br>Intel Core i7-14650HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5060 / 16"<br>FreeDOS Gaming Laptop<br><h2>111.636 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="PL5M.php">
        <div class="resim-karti">
          <img src="P1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G16 G615JMR-S5048A015<br>Intel Core i7-14650HX / 16GB RAM<br>512GB SSD / NVIDIA Geforce RTX 5060 / 16"<br>W11P Gaming Laptop<br><h2>97.364 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL6M.php">
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

        <a href="PL7M.php">
        <div class="resim-karti">
          <img src="P3.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS ROG Strix G18 G814PP-S9045<br> AMD Ryzen 9 8940HX / 16 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5070 / 18"<br>FreeDOS<br><h2>114.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="PL8M.php">
        <div class="resim-karti">
          <img src="P4.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>MSI Katana 17 HX B14WFK-216XTR<br>Intel Core i7-14650HX / 32 GB RAM<br>1 TB SSD / NVIDIA Geforce RTX 5070 / 17,3"<br>FreeDOS Gaming Laptop<br><h2>84.982 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="PL9M.php">
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
        <center><a href="GLM.php"><button class="don">Geri Dön</button></a></center>
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
