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
        <a href="IL1M.php">
        <div class="resim-karti">
          <img src="IL1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>CASPER Nirvana S100.1342-BE00P-G-F<br>Intel Core i5-13420H / 16 GB RAM<br>500 GB SSD / Intel UHD Graphics / 16" Laptop<br><h2>33.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="IL2M.php">
        <div class="resim-karti">
          <img src="IL1.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>CASPER Nirvana S100.255H-CQ00A-G-F<br>Intel Core Ultra 7 255H / 24 GB RAM<br>1 TB SSD / Onboard Graphics / 16" Laptop<br><h2>49.999 TL</h2></h3>

          </div>
          </div>
          </a>

        <a href="IL3M.php">
        <div class="resim-karti">
          <img src="IL2.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS Vivobook 15 X1504VA-BQ3970W<br>Intel Core 5 120U / 8 GB RAM<br>512 GB SSD / Intel UHD Graphics / 15,6" Laptop<br><h2>27.499 TL</h2></h3>
            
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

        <a href="IL4M.php">
        <div class="resim-karti">
          <img src="IL3.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ASUS Vivobook 15 X1504VA-BQ5425W<br>Intel Core i3-1315U / 8 GB RAM<br>512 GB SSD / Intel UHD Graphics / 15,6" Laptop<br><h2>19.999 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="IL5M.php">
        <div class="resim-karti">
          <img src="IL3.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>ASUS Vivobook 16 X1607QA-MB085W<br>Snapdragon X1 / 16GB RAM<br>512GB SSD / 16" Laptop<br><h2>32.849 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="IL6M.php">
        <div class="resim-karti">
          <img src="IL4.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>ACER Aspire Go AG15-41 NX.J7FEY.002<br>Amd Ryzen 7 7735HS / 16 GB RAM<br>512 GB SSD / 15.6" Laptop<br><h2>28.899 TL</h2></h3>

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

        <a href="IL7M.php">
        <div class="resim-karti">
          <img src="IL5.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>HP Omnibook X Flip 2-in-1<br> Intel Core Ultra 5 226V / 16 GB RAM<br>512 GB SSD / 14" Laptop<br><h2>46.999 TL</h2></h3>
            
          </div>
        </div>
        </a>

        <a href="IL8M.php">
        <div class="resim-karti">
          <img src="IL6.jpeg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>HP AI<br>Intel Core Ultra 5-225U / 16 GB RAM<br>512 GB SSD / 15.6" Laptop<br><h2>36.999 TL</h2></h3>

          </div>
          </div>
          </a>
        
        <a href="IL9M.php">
        <div class="resim-karti">
          <img src="IL1.jpeg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>CASPER Nirvana S100.1342-BE00P-G-F<br>Intel Core i5-13420H / 16 GB RAM<br>500 GB SSD / Intel UHD Graphics / 16" Laptop<br><h2>33.999 TL</h2></h3>
            
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
        <center><a href="sistemM.php"><button class="don">Geri Dön</button></a></center>
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
