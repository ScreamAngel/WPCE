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
    </header>
    <br><br>
    <section>
        <div class="cards">
            <div class="card">
    <img src="IL6M.jpeg">
</div>
</div>
<div class="cards">
        <div class="card">
        <p><font color="red">Özellikler:<br>
        Marka-Model: <font color="#FFFFFF">HP AI</font><br>
        İşlemci: <font color="#FFFFFF">Intel Core Ultra 5-225U</font><br>
        GHZ-Temel/Turbo: <font color="#FFFFFF">3.6GHZ/4.8GHZ</font><br>
        Ekran Kartı: <font color="#FFFFFF">Intel® Arc™ Graphics</font><br>
        Ram: <font color="#FFFFFF">16GB 5200MHZ DDR5</font><br>
        Depolama: <font color="#FFFFFF">512GB M2 SSD</font><br>
        İşletim Sistemi: <font color="#FFFFFF">Windows 11</font></p>
        <br>
    <a href="https://www.mediamarkt.com.tr/tr/product/_hp-aiintel-core-ultra-5-225u-islemci16-gb-ram512-gb-ssd156w11laptop-bq1w8ea-1252241.html"><button class="magaza">Mağaza Sayfasını Gör</button></a><br>

   
    <br>
     <center><a href="IL.php"><button class="don">Geri Dön</button></a><center>


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