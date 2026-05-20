<?php
include("connection.php");
session_start();

// Butona basılıp basılmadığını kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['harici_link_ac'])) {
    
    // Gidilecek olan sorunlu/doğrulamalı link
    $url = "https://www.gaming.gen.tr/urun/800778/asus-rog-g700-gm700tz-r9700x0430-amd-ryzen-7-9700x-16gb-ddr5-1tb-ssd-prime-rx-9070-xt-oc-16gb-850w-80-gold-freedos-gaming-masaustu-bilgisayar/";

    // İşletim sistemini tespit edip uygun komutu çalıştırıyoruz
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Windows sistemler için varsayılan tarayıcıyı tetikler
        exec('start "" "' . $url . '"');
    } else {
        // Linux sistemler için (Örn: Arch Linux) varsayılan tarayıcıyı tetikler
        // İşlemin PHP'yi bekletmemesi için arka planda (&) çalıştırıyoruz
        exec('xdg-open "' . $url . '" > /dev/null 2>&1 &');
    }
    
    // İşlem bittikten sonra sayfanın yeniden yüklenmesi veya formun tekrar gönderilmesini önlemek için
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
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
    <title>Gaming PC</title>
    <style>
    select, button {
      background: #1a1a1a;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      margin: 10px;
      font-size: 15px;
      cursor: pointer;
    }

    #fps-container {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 20px;
      justify-content: center;
    }

    .fps-card {
      background: #111;
      border-radius: 12px;
      width: 200px;
      padding: 15px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: 0.3s;
      box-shadow: 0 0 10px rgba(0, 255, 153, 0.1);
    }

    .fps-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 15px rgba(0, 255, 153, 0.3);
    }

    .fps-card img {
      width: 80px;
      height: 80px;
      border-radius: 10px;
      margin-bottom: 10px;
      object-fit: cover;
    }

    .fps-card h3 {
      margin: 0;
      font-size: 18px;
    }

    .fps-value {
      font-size: 22px;
      color: #00ff88;
      margin-top: 8px;
      font-weight: bold;
    }

    .fps-bar {
      width: 100%;
      height: 8px;
      background: #222;
      border-radius: 4px;
      overflow: hidden;
      margin-top: 8px;
    }

    .fps-fill {
      height: 8px;
      background: linear-gradient(900deg, #00ff99, #00ccff);
      width: 0%;
      transition: width 1s ease;
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
    </header>
    <br><br>
    <section>
        <div class="cards">
            <div class="card">
    <img src="Tavsiye Sistem.jpg">
</div>
</div>
<div class="cards">
        <div class="card">
        <p><font color="red">Özellikler:<br>
        Marka-Model: <font color="#FFFFFF">ASUS ROG G700 GM700TZ-R9700X0430</font><br>
        İşlemci: <font color="#FFFFFF">AMD Ryzen 7 9700X</font><br>
        GHZ-Temel/Turbo: <font color="#FFFFFF">3.8GHZ/5.5GHZ</font><br>
        Ekran Kartı: <font color="#FFFFFF">Radeon RX 9070 XT 16GB GDDR6</font><br>
        Ram: <font color="#FFFFFF">16GB 5600MHZ DDR5</font><br>
        Depolama: <font color="#FFFFFF">1TB M2 SSD</font><br>
        İşletim Sistemi: <font color="#FFFFFF">FreeDOS</font></p>
        <br>
        <form method="POST">
    <button type="submit" class="magaza" name="harici_link_ac">Mağaza Sayfasını Gör</button><br>
    </form>
    <h1>🎮 FPS Tahmin Gösterimi (Oyunlar Ultra Ayarlarda, RTX, DLSS veya FSR ve FG kapalı. Sadece Resident Evil Requiem'de PT açık)</h1>

   <div>
    <select id="resolution">
      <option value="1080p">1080p</option>
      <option value="1440p">2K</option>
      <option value="4K">4K</option>
    </select>

    <button onclick="loadFPS()">FPS Göster</button>
  </div>

  <div id="fps-container"></div>


    </section>
   
    <br>
     <center><a href="GPCM.php"><button class="don">Geri Dön</button></a><center>


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


    // --- FPS Verileri (Ryzen 7 9700X + Radeon RX 9070 XT) ---
    const fpsData = [
      // Resident Evil Requiem
      { game: "Resident Evil Requiem", resolution: "1080p", fps: 180 },
      { game: "Resident Evil Requiem", resolution: "1440p", fps: 120 },
      { game: "Resident Evil Requiem", resolution: "4K", fps: 70 },

      // Red Dead Redemption 2
      { game: "Red Dead Redemption 2", resolution: "1080p", fps: 210 },
      { game: "Red Dead Redemption 2", resolution: "1440p", fps: 155 },
      { game: "Red Dead Redemption 2", resolution: "4K", fps: 90 },

      // Cyberpunk 2077
      { game: "Cyberpunk 2077", resolution: "1080p", fps: 230 },
      { game: "Cyberpunk 2077", resolution: "1440p", fps: 165 },
      { game: "Cyberpunk 2077", resolution: "4K", fps: 95 }
    ];

    // --- Oyun Görselleri ---
    const gameImages = {
      "Resident Evil Requiem": "img/Resident_Evil_Requiem_Cover_Art.jpg",
      "Red Dead Redemption 2": "https://upload.wikimedia.org/wikipedia/en/4/44/Red_Dead_Redemption_II.jpg",
      "Cyberpunk 2077": "https://upload.wikimedia.org/wikipedia/en/9/9f/Cyberpunk_2077_box_art.jpg"
    };

    // --- FPS Gösterimi ---
    function loadFPS() {
      const resolution = document.getElementById("resolution").value;
      const container = document.getElementById("fps-container");
      container.innerHTML = "";

      const results = fpsData.filter(item => item.resolution === resolution);

      results.forEach(r => {
        const card = document.createElement("div");
        card.classList.add("fps-card");
        card.innerHTML = `
          <img src="${gameImages[r.game]}" alt="${r.game}">
          <h3>${r.game}</h3>
          <div class="fps-value">${r.fps} FPS</div>
          <div class="fps-bar"><div class="fps-fill"></div></div>
        `;
        container.appendChild(card);

        // Animasyon efekti (bar dolması)
        setTimeout(() => {
          const fill = card.querySelector(".fps-fill");
          const width = Math.min((r.fps / 165) * 100, 100); // Bar oranı dinamik
          fill.style.width = width + "%";
          if (r.fps >= 165) {
  fill.style.background = "linear-gradient(90deg, #00ff99, #00ffff, #00ff99)";
  fill.style.boxShadow = "0 0 10px #00ffcc";
}
        }, 100);
      });
    }

  </script>
  </body>
  </html>