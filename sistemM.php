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
    <title>Sistemler</title>
    <style>
        /* Ticker Konteynırı */
.ticker-wrapper {
    width: 100%;
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
    <h2 class="pop">Sistem Öneri</h2>
    <br><br><br><br>
    
      <div class="grid-container">
        <a href="GLM.php">
        <div class="resim-karti">
          <img src="Laptop.png" alt="Gaming laptop">
          <div class="hover-bilgi">
            <h3>Gaming Laptop</h3>
          </div>
        </div>
        </a>

        <a href="GPCM.php">
        <div class="resim-karti">
          <img src="PC.png" alt="Gaming PC">
          <div class="hover-bilgi">
            <h3>Gaming PC</h3>
          </div>
          </div>
          </a>

          <a href="ILM.php">
          <div class="resim-karti">
            <img src="Casper.png" alt="İş laptop">
            <div class="hover-bilgi">
              <h3>İş laptop</h3>
            </div>
        </div>
        </a>

        </div>
        <br>
        <br>

        <center><a href="ihtiyacM.php"><button class="don">Geri Dön</button></a></center>


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
