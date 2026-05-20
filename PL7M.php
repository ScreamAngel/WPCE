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
    <img src="P3M.jpeg">
</div>
</div>
<div class="cards">
        <div class="card">
        <p><font color="red">Özellikler:<br>
        Marka-Model: <font color="#FFFFFF">ASUS ROG Strix G18 G814PP-S9045</font><br>
        İşlemci: <font color="#FFFFFF">AMD Ryzen 9 8940HX</font><br>
        GHZ-Temel/Turbo: <font color="#FFFFFF">2.4GHZ/5.3GHZ</font><br>
        Ekran Kartı: <font color="#FFFFFF">NVIDIA Geforce RTX 5070 Laptop GPU</font><br>
        Ram: <font color="#FFFFFF">16GB 8000MHZ DDR5</font><br>
        Depolama: <font color="#FFFFFF">1 TB M2 SSD</font><br>
        İşletim Sistemi: <font color="#FFFFFF">FreeDOS</font></p>
        <br>
    <a href="https://www.mediamarkt.com.tr/tr/product/_asus-rog-strix-g18-g814pp-s9045-gaming-rtx-5070-115w-25k-ips-amd-ryzen-9-8940hx-16-gb-ram-1-tb-ssd-18-inc-freedos-gaming-laptop-gri-165528308.html"><button class="magaza">Mağaza Sayfasını Gör</button></a><br>
    <h1>🎮 FPS Tahmin Gösterimi (Oyunlar Ultra Ayarlarda, RTX, DLSS veya FSR, PT ve FG kapalı.)</h1>

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
     <center><a href="PM.php"><button class="don">Geri Dön</button></a><center>


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


    // --- FPS Verileri (İntel Core 5 - 210H + RTX 3050 Laptop GPU) ---
    const fpsData = [
      // Resident Evil Requiem
      { game: "Resident Evil Requiem", resolution: "1080p", fps: 135 },
      { game: "Resident Evil Requiem", resolution: "1440p", fps: 98 },
      { game: "Resident Evil Requiem", resolution: "4K", fps: 56 },

      // Red Dead Redemption 2
      { game: "Red Dead Redemption 2", resolution: "1080p", fps: 122 },
      { game: "Red Dead Redemption 2", resolution: "1440p", fps: 92 },
      { game: "Red Dead Redemption 2", resolution: "4K", fps: 50 },

      // Cyberpunk 2077
      { game: "Cyberpunk 2077", resolution: "1080p", fps: 108 },
      { game: "Cyberpunk 2077", resolution: "1440p", fps: 74 },
      { game: "Cyberpunk 2077", resolution: "4K", fps: 38 }
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