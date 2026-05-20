<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

$email = $_SESSION['user'] ?? $_SESSION['admin'] ?? null;

$query = mysqli_query($conn, "SELECT profile_image, gizli_soru FROM users WHERE email = '$email'");
$user_data = mysqli_fetch_assoc($query);
$user_photo = (!empty($user_data['profile_image'])) ? $user_data['profile_image'] : "default-avatar.png";

// KARTAL GÖZÜ: Eğer kullanıcının gizli sorusu yoksa veya boşsa, anasayfayı görmesini engelle!
if (empty($user_data['gizli_soru'])) {
    header('Location: profil-guncelle-admin.php');
    exit;
}

//$ = değişken (variable)

//=================================================================================================

//İstatistik Sorguları (SELECT COUNT): users, iletisim, sponsorlar, sistemler gibi tablolardaki toplam satır sayısını sayar.
$sorgu1 = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM users");
$veri1 = mysqli_fetch_assoc($sorgu1);
$userCount1 = $veri1['toplam'];

// 3. İlerleme yüzdesini hesaplıyoruz (Hedef: 100 kullanıcı)
$target = 100; 
$percentage = ($userCount1 / $target) * 100;
if ($percentage > 100) $percentage = 100;

// SVG için daire çevresi (r=90 ise 2 * PI * 90 = 565.48)
$circumference = 565;

//===================================================================================================

// 2. MySQLi kullanarak kullanıcı sayısını çekiyoruz
// Sorgu sonucu tek bir satır döneceği için mysqli_query ve fetch kullanıyoruz
$sorgu2 = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM iletisim");
$veri2 = mysqli_fetch_assoc($sorgu2);
$userCount2 = $veri2['toplam'];

// 3. İlerleme yüzdesini hesaplıyoruz (Hedef: 100 kullanıcı)
$target = 100; 
$percentage2 = ($userCount2 / $target) * 100;
if ($percentage2 > 100) $percentage2 = 100;

// SVG için daire çevresi (r=90 ise 2 * PI * 90 = 565.48)
$circumference = 565;

//===================================================================================================

// 2. MySQLi kullanarak kullanıcı sayısını çekiyoruz
// Sorgu sonucu tek bir satır döneceği için mysqli_query ve fetch kullanıyoruz
$sorgu3 = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM sponsorlar");
$veri3 = mysqli_fetch_assoc($sorgu3);
$userCount3 = $veri3['toplam'];

// 3. İlerleme yüzdesini hesaplıyoruz (Hedef: 100 kullanıcı)
$target = 100; 
$percentage3 = ($userCount3 / $target) * 100;
if ($percentage3 > 100) $percentage3 = 100;

// SVG için daire çevresi (r=90 ise 2 * PI * 90 = 565.48)
$circumference = 565;


//===================================================================================================

// 2. MySQLi kullanarak kullanıcı sayısını çekiyoruz
// Sorgu sonucu tek bir satır döneceği için mysqli_query ve fetch kullanıyoruz
$sorgu4 = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM sistemler");
$veri4 = mysqli_fetch_assoc($sorgu4);
$userCount4 = $veri4['toplam'];

// 3. İlerleme yüzdesini hesaplıyoruz (Hedef: 100 kullanıcı)
$target = 100; 
$percentage4 = ($userCount4 / $target) * 100;
if ($percentage4 > 100) $percentage4 = 100;

// SVG için daire çevresi (r=90 ise 2 * PI * 90 = 565.48)
$circumference = 565;


//===================================================================================================

// 1. Toplam hata sayısını çekelim (Payda olacak)
$toplam_sorgu = mysqli_query($conn, "SELECT COUNT(*) as total FROM error_codes");
$toplam_veri = mysqli_fetch_assoc($toplam_sorgu);
$toplam_hata = $toplam_veri['total'];

// 2. Belirli bir kategorideki hata sayısını çekelim (Pay olacak)
// Örnek: Sürücü hataları
$kategori_sorgu = mysqli_query($conn, "SELECT COUNT(*) as cat_total FROM error_codes WHERE kategori = 'Driver (Sürücü)'");
$kategori_veri = mysqli_fetch_assoc($kategori_sorgu);
$surucu_sayisi = $kategori_veri['cat_total'];

// 3. Yüzdeyi hesaplayalım
// Formül: $$ \text{Yüzde} = \left( \frac{\text{Kategori Sayısı}}{\text{Toplam Sayı}} \right) \times 100 $$
$yuzde_surucu = ($toplam_hata > 0) ? ($surucu_sayisi / $toplam_hata) * 100 : 0;

$circumference = 565; // Sabit daire çevresi


//===================================================================================================

// 1. Toplam hata sayısını çekelim (Payda olacak)
$toplam_sorgu2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM error_codes");
$toplam_veri = mysqli_fetch_assoc($toplam_sorgu2);
$toplam_hata = $toplam_veri['total'];

// 2. Belirli bir kategorideki hata sayısını çekelim (Pay olacak)
// Örnek: Sürücü hataları
$kategori_sorgu2 = mysqli_query($conn, "SELECT COUNT(*) as cat_total2 FROM error_codes WHERE kategori = 'Hardware (Donanım)'");
$kategori_veri = mysqli_fetch_assoc($kategori_sorgu2);
$donanim_sayisi = $kategori_veri['cat_total2'];

// 3. Yüzdeyi hesaplayalım
// Formül: $$ \text{Yüzde} = \left( \frac{\text{Kategori Sayısı}}{\text{Toplam Sayı}} \right) \times 100 $$
$yuzde_donanim = ($toplam_hata > 0) ? ($donanim_sayisi / $toplam_hata) * 100 : 0;

$circumference = 565; // Sabit daire çevresi



//===================================================================================================

// 1. Toplam hata sayısını çekelim (Payda olacak)
$toplam_sorgu3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM error_codes");
$toplam_veri = mysqli_fetch_assoc($toplam_sorgu3);
$toplam_hata = $toplam_veri['total'];

// 2. Belirli bir kategorideki hata sayısını çekelim (Pay olacak)
// Örnek: Sürücü hataları
$kategori_sorgu3 = mysqli_query($conn, "SELECT COUNT(*) as cat_total3 FROM error_codes WHERE kategori = 'Kernel/Software (Sistem ve Çekirdek)'");
$kategori_veri = mysqli_fetch_assoc($kategori_sorgu3);
$kernel_sayisi = $kategori_veri['cat_total3'];

// 3. Yüzdeyi hesaplayalım
// Formül: $$ \text{Yüzde} = \left( \frac{\text{Kategori Sayısı}}{\text{Toplam Sayı}} \right) \times 100 $$
$yuzde_kernel = ($toplam_hata > 0) ? ($kernel_sayisi / $toplam_hata) * 100 : 0;

$circumference = 565; // Sabit daire çevresi


//===================================================================================================

// 1. Toplam hata sayısını çekelim (Payda olacak)
$toplam_sorgu4 = mysqli_query($conn, "SELECT COUNT(*) as total FROM error_codes");
$toplam_veri = mysqli_fetch_assoc($toplam_sorgu4);
$toplam_hata = $toplam_veri['total'];

// 2. Belirli bir kategorideki hata sayısını çekelim (Pay olacak)
// Örnek: Sürücü hataları
$kategori_sorgu = mysqli_query($conn, "SELECT COUNT(*) as cat_total4 FROM error_codes WHERE kategori = 'Storage (Disk ve Dosya Sistemi)'");
$kategori_veri = mysqli_fetch_assoc($kategori_sorgu);
$disk_sayisi = $kategori_veri['cat_total4'];

// 3. Yüzdeyi hesaplayalım
// Formül: $$ \text{Yüzde} = \left( \frac{\text{Kategori Sayısı}}{\text{Toplam Sayı}} \right) \times 100 $$
$yuzde_disk = ($toplam_hata > 0) ? ($disk_sayisi / $toplam_hata) * 100 : 0;

$circumference = 565; // Sabit daire çevresi


//===================================================================================================
/*
// 1. Toplam hata sayısını çekelim (Payda olacak)
$toplam_sorgu5 = mysqli_query($conn, "SELECT COUNT(*) as total FROM update_requests");
$toplam_veri = mysqli_fetch_assoc($toplam_sorgu5);
$toplam_hata = $toplam_veri['total'];

// 2. Belirli bir kategorideki hata sayısını çekelim (Pay olacak)
// Örnek: Sürücü hataları
$kategori_sorgu = mysqli_query($conn, "SELECT COUNT(*) as cat_total5 FROM update_requests WHERE user_id");
$kategori_veri = mysqli_fetch_assoc($kategori_sorgu);
$talep_sayisi = $kategori_veri['cat_total5'];

// 3. Yüzdeyi hesaplayalım
// Formül: $$ \text{Yüzde} = \left( \frac{\text{Kategori Sayısı}}{\text{Toplam Sayı}} \right) \times 100 $$
$yuzde_talep = ($toplam_hata > 0) ? ($talep_sayisi / $toplam_hata) * 100 : 0;

$circumference = 565; // Sabit daire çevresi*/

//========================================================================================================

//İstatistik Sorguları (SELECT COUNT): users, iletisim, sponsorlar, sistemler gibi tablolardaki toplam satır sayısını sayar.
$sorgu5 = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM mesajlar");
$veri5 = mysqli_fetch_assoc($sorgu5);
$userCount5 = $veri5['toplam'];

// 3. İlerleme yüzdesini hesaplıyoruz (Hedef: 100 kullanıcı)
$target = 100; 
$percentage = ($userCount5 / $target) * 100;
if ($percentage > 100) $percentage = 100;

// SVG için daire çevresi (r=90 ise 2 * PI * 90 = 565.48)
$circumference = 565;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin</title>
    <style>
    .hacker-link {
    position: relative;
    display: inline-block;
    padding: 5px 15px;
    color: #FFFFFF; /* Yazı rengi Matrix yeşili */
    text-decoration: none;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    z-index: 1;
    overflow: hidden; /* Taşmaları engelle */
    transition: color 0.3s ease;
}

/* Renkli ve Şeffaf Katman */
.hacker-link::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0; /* Başlangıçta genişlik sıfır */
    height: 100%;
    background: rgba(255, 255, 255, 0.5); /* %30 şeffaf yeşil (50 değeri buradan gelir) */
    z-index: -1; /* Yazının arkasında kalması için */
    transition: width 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Yumuşak geçiş eğrisi */
}

/* Üzerine gelince (Hover) */
.hacker-link:hover::before {
    width: 100%; /* Soldan sağa %100 dol */
}

/* Üzerine gelince yazı rengini biraz daha parlak yapabilirsin */
.hacker-link:hover {
    color: #000;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

/*==================================================================================*/

    .hacker-link-2 {
    position: relative;
    display: inline-block;
    padding: 5px 15px;
    color: #FFFFFF; /* Yazı rengi Matrix yeşili */
    text-decoration: none;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    z-index: 1;
    overflow: hidden; /* Taşmaları engelle */
    transition: color 0.3s ease;
}

/* Renkli ve Şeffaf Katman */
.hacker-link-2::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0; /* Başlangıçta genişlik sıfır */
    height: 100%;
    background: rgba(255, 0, 0, 0.5); /* %30 şeffaf yeşil (50 değeri buradan gelir) */
    z-index: -1; /* Yazının arkasında kalması için */
    transition: width 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Yumuşak geçiş eğrisi */
}

/* Üzerine gelince (Hover) */
.hacker-link-2:hover::before {
    width: 100%; /* Soldan sağa %100 dol */
}

/* Üzerine gelince yazı rengini biraz daha parlak yapabilirsin */
.hacker-link-2:hover {
    color: #FFFFFF;
    text-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
}


/*======================================================================================*/

.user-stats-container {
    display: flex; justify-content: center; align-items: center;
    background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(2px); padding: 40px; border: 1px solid rgba(255, 255, 255, 0.1); width:50%; margin-top:-45%; margin-left:10%; border-radius: 10px;
}

.user-stats-container:hover{
    transform:scale(1.1);
    transition:0.25s;
    box-shadow: 0px 6px 20px darkgray;
    backdrop-filter: blur(7px);
}

.circular-progress {
    position: relative; width: 200px; height: 200px;
}

svg { transform: rotate(-90deg); /* Dairenin tepeden başlaması için */ }

circle {
    fill: none;
    stroke-width: 15;
    stroke-linecap: round; /* Çizgi uçlarını yuvarlatır */
}

.bg { stroke: #222; } /* Arka plan halkası */

.progress {
    stroke: #1793d1; /* Arch Mavisi veya Matrix Yeşili yapabilirsin */
    stroke-dasharray: 565; /* 2 * PI * r (2 * 3.14 * 90) */
    transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 0 8px #1793d1);
}

.number {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    text-align: center; font-family: 'Courier New', monospace;
}

.count { display: block; color: #000; font-size: 2.5rem; font-weight: bold;}
.label { color: #000; font-size: 0.8rem; letter-spacing: 2px;}


/*========================================================================================*/


.sekme-tusu img {
    transition: transform 0.2s ease-in-out;
}

.sekme-tusu img:hover {
    transform: scale(1.2); /* Fare üzerine gelince %10 büyütür */
    border-color: #ffffff; /* Kenarlığı beyaza çevirir */
}


/*============================================================================================*/

 .glass-table-container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 20px;
    margin-top: 30px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
}

.pending-table {
    width: 100%;
    border-collapse: collapse;
}

.pending-table th, .pending-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.new-val { color: #55ff55; font-weight: bold; } /* Yeni değer yeşil görünsün */

.btn {
    padding: 5px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.8rem;
}

.approve { background: rgba(85, 255, 85, 0.2); color: #55ff55; border: 1px solid #55ff55; }
.reject { background: rgba(255, 85, 85, 0.2); color: #ff5555; border: 1px solid #ff5555; }



    </style>
</head>
<body>

<table border=0 width=100%>
    <tr>
        <th width=17%>

    <div class="secim">

    <div class="sekme">
        <button class="sekme-tusu" style="padding: 5px 10px; display: flex; align-items: center; justify-content: center;">
        <img src="uploads/<?php echo $user_photo; ?>?t=<?php echo time(); ?>"
            alt="Profil" 
                style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; /* İşte sihirli dokunuş bu! */ object-position: center; /* Resmi ortalar */ border: 2px solid #89b4fa;">
        </button>
    <div class="sekme-icerik">
        <a href="profilad.php">Profil Fotoğrafı</a>
    </div>
    </div>


    <h2>Admin Paneli</h2><br>
    <a href="admin_kul.php" class="hacker-link">Kullanıcı Yönetimi</a><br><br>
    <a href="admin_hatakod.php" class="hacker-link">Hata Kodu Yönetimi</a><br><br>
    <a href="admin_sistem.php" class="hacker-link">Sistem Yönetimi</a><br><br>
    <a href="admin_sponsor.php" class="hacker-link">Sponsor Yönetimi</a><br><br>
    <a href="admin_mesajlar.php" class="hacker-link">Canlı İletişim</a><br><br>
    <a href="admin_mesaj.php" class="hacker-link">Gelen Mesajlar</a><br><br>
    <a href="admin_yapay zeka.php" class="hacker-link">Yapay Zeka Logları</a><br><br><br>
    <!--<a href="admin_bloke.php" class="hacker-link">Kullanıcı Durumu</a><br><br>-->
    <!--<a href="onay.php" class="hacker-link">Bekleyen Onaylar</a>--><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="cikis.php" class="hacker-link-2">Çıkış Yap</a>
    
    </div>
</th>
<th>
    <br><br><br><br><br><br><br><br>

        <div class="user-stats-container">
    <div class="circular-progress">
        <svg width="200" height="200">
            <circle class="bg" cx="100" cy="100" r="90"></circle>
            <circle class="progress" cx="100" cy="100" r="90" 
                    style="stroke-dashoffset: calc(565 - (565 * <?php echo $percentage; ?>) / 100);">
            </circle>
        </svg>
        <div class="number">
            <span class="count"><?php echo $userCount1; ?></span>
            <span class="label">KULLANICI</span>
        </div>
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <div class="user-stats-container">
    <div class="circular-progress">
        <svg width="200" height="200">
            <circle class="bg" cx="100" cy="100" r="90"></circle>
            <circle class="progress" cx="100" cy="100" r="90" 
                    style="stroke-dashoffset: calc(565 - (565 * <?php echo $percentage2; ?>) / 100);">
            </circle>
        </svg>
        <div class="number">
            <span class="count"><?php echo $userCount2; ?></span>
            <span class="label">MESAJ</span>
        </div>
    </div>
</div>
</th>

<th>

<br><br><br><br><br><br><br><br>


        <div class="user-stats-container">
    <div class="circular-progress">
        <svg width="200" height="200">
            <circle class="bg" cx="100" cy="100" r="90"></circle>
            <circle class="progress" cx="100" cy="100" r="90" 
                    style="stroke-dashoffset: calc(565 - (565 * <?php echo $percentage; ?>) / 100);">
            </circle>
        </svg>
        <div class="number">
            <span class="count"><?php echo $userCount5; ?></span>
            <span class="label">CANLI İLETİŞİM</span>
        </div>
    </div>
</div>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

     <div class="user-stats-container">
    <div class="circular-progress">
        <svg width="200" height="200">
            <circle class="bg" cx="100" cy="100" r="90"></circle>
            <circle class="progress" cx="100" cy="100" r="90" 
                    style="stroke-dashoffset: calc(565 - (565 * <?php echo $percentage4; ?>) / 100);">
            </circle>
        </svg>
        <div class="number">
            <span class="count"><?php echo $userCount4; ?></span>
            <span class="label">SİSTEMLER</span>
        </div>
    </div>
</div>
</th>



    <th>

    <br><br><br><br><br><br><br><br>
    <div class="user-stats-container">
        <div class="circular-progress">
            <svg width="200" height="200">
                <circle class="bg" cx="100" cy="100" r="90"></circle>
                <circle class="progress" cx="100" cy="100" r="90" 
                        style="stroke-dashoffset: calc(565 - (565 * <?php echo $yuzde_surucu; ?>) / 100);">
                </circle>
            </svg>
            <div class="number">
                <span class="count"><?php echo $surucu_sayisi; ?></span>
                <span class="label">SÜRÜCÜ</span>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

     <div class="user-stats-container">
        <div class="circular-progress">
            <svg width="200" height="200">
                <circle class="bg" cx="100" cy="100" r="90"></circle>
                <circle class="progress" cx="100" cy="100" r="90" 
                        style="stroke-dashoffset: calc(565 - (565 * <?php echo $yuzde_donanim; ?>) / 100);">
                </circle>
            </svg>
            <div class="number">
                <span class="count"><?php echo $donanim_sayisi; ?></span>
                <span class="label">DONANIM</span>
            </div>
        </div>
    </div>
</th>
<th>

<br><br><br><br><br><br><br><br>
     <div class="user-stats-container">
        <div class="circular-progress">
            <svg width="200" height="200">
                <circle class="bg" cx="100" cy="100" r="90"></circle>
                <circle class="progress" cx="100" cy="100" r="90" 
                        style="stroke-dashoffset: calc(565 - (565 * <?php echo $yuzde_kernel; ?>) / 100);">
                </circle>
            </svg>
            <div class="number">
                <span class="count"><?php echo $kernel_sayisi; ?></span>
                <span class="label">SİSTEM VE ÇEKİRDEK</span>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

         <div class="user-stats-container">
        <div class="circular-progress">
            <svg width="200" height="200">
                <circle class="bg" cx="100" cy="100" r="90"></circle>
                <circle class="progress" cx="100" cy="100" r="90" 
                        style="stroke-dashoffset: calc(565 - (565 * <?php echo $yuzde_disk; ?>) / 100);">
                </circle>
            </svg>
            <div class="number">
                <span class="count"><?php echo $disk_sayisi; ?></span>
                <span class="label">DİSK VE DOSYA SİSTEMİ</span>
            </div>
        </div>
    </div>

       
</th>

</tr>
</table>

    
</body>
</html>