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
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servislerimiz - WPCE</title>
    
    <!-- Leaflet CSS (Harita stilleri için zorunlu) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        body {
            font-family: arial, sans-serif;
            background-image: url(img/Win112.jpg);
            background-size: cover;
            background-repeat: no-repeat;
        }

        .services-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: #fff;
        }
        
        /* Haritanın boyutları ve tasarımı */
        #wpce-map {
            width: 100%;
            height: 500px; /* Yüksekliği tasarımına göre değiştirebilirsin */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            margin-top: 20px;
            z-index: 1;
        }

        .don{
            padding: 10px;
            border-radius: 10px;
            background-color: black;
            color: white;
            width: 250px;
            justify-content: center;
            align-items: center;
            
        }

        .don:hover{
             background-color: dodgerblue;
            color: white;
            transition: 0.25s;
            transform: scale(1.05);
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="services-container">
    <h2>Servislerimiz ve WPCE Mağazaları</h2>
    <p>Size en yakın WPCE mağazasını ve teknik servisini harita üzerinden bulabilirsiniz. Ekibimiz her zaman yanınızda.</p>
    
    <!-- Haritanın yükleneceği kapsayıcı -->
    <div id="wpce-map"></div>
</div>

<!-- Leaflet JS (Haritanın çalışması için zorunlu) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<center><a href="kullanici.php"><button class="don">Geri Dön</button></a></center>

<script>
    // 1. Haritayı başlat (Merkez olarak Türkiye'yi alıyoruz, zoom seviyesi 6)
    var map = L.map('wpce-map').setView([39.0, 35.0], 6);

    // 2. Harita görüntülerini (Tile) OpenStreetMap'ten çekiyoruz (Tamamen Ücretsiz)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // 3. WPCE Formalite Mağaza Konumları (Enlem ve Boylam verileri)
    var wpceStores = [
        { name: "WPCE Merkez Şube - Teknik Servis ve Satış (İstanbul)", lat: 41.0081, lng: 29.0400, status: "Açık" },
        { name: "WPCE Teknik Servis ve Satış (Ankara)", lat: 39.9208, lng: 32.8871, status: "Açık" },
        { name: "WPCE Teknik Servis ve Satış (İzmir)", lat: 38.4192, lng: 27.1687, status: "Bakımda" },
        { name: "WPCE Teknik Servis ve Satış (Eskişehir)", lat: 39.7767, lng: 30.5206, status: "Açık" }
    ];

    // 4. Döngü ile her bir mağazayı haritaya ekle ve tıklandığında açılacak balonu ayarla
    wpceStores.forEach(function(store) {
        // Duruma göre renk/metin belirleme (Opsiyonel detay)
        let statusColor = store.status === "Açık" ? "green" : "red";
        
        // İşaretçiyi haritaya ekle
        L.marker([store.lat, store.lng])
         .addTo(map)
         .bindPopup(
             "<b style='font-size: 14px;'>" + store.name + "</b><br>" +
             "Durum: <span style='color:" + statusColor + "; font-weight:bold;'>" + store.status + "</span>"
         );
    });
</script>

</body>
</html>