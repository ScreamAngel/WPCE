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
    <link rel="stylesheet" href="stylePCT.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>Bilgisayar Tamiri</title>
    <style>
/* Layout Yapısı */
.story-container {
    width: 100%;
    min-height: 150vh; /* Yazıların akması için uzun bir alan */
    padding: 100px 0;
}

.story-layout {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    gap: 50px;
}

.story-text-column { width: 50%; }
.story-image-column { width: 65%;}

/* Sticky (Sabit) Resim Alanı */
.sticky-image-wrapper {
    position: sticky;
    top: 300px; /* Ekranın üstünden ne kadar aşağıda sabitlensin? */
    height: fit-content;
}

.image-frame {
    border: 1px solid #333;
    padding: 4px;
    background: #111;
    box-shadow: 0 0 30px rgba(0,0,0,0.8);
}

.image-frame img { width: 100%; display: block; filter: grayscale(30%); }

/* --- ANIMASYON: Opaklık Efekti --- */
.reveal-text {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s ease-out;
    margin-bottom: 150px; /* Yazılar arası mesafe: Videodaki akış için yüksek verilmeli */
}

.reveal-text.visible {
    opacity: 1;
    transform: translateY(0);
}

.full-page {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid #333;
}

.story-text-column2 { width: 90%; }

p{
    color: #e0e0e0;
}
/*
table{
    background-color: rgba(15, 15, 20, 0.2);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 20px;
    width: 100%;
    border-bottom: 3px solid rgba(0, 0, 0, 0.2);
}*/

/* Ana kart kapsayıcısı */
.info-card {
    display: flex; /* İçindeki resmi ve yazıyı yan yana dizer */
    align-items: center; /* Dikeyde tam ortalar */
    background: rgba(20, 20, 30, 0.7); /* Senin görseldeki gibi yarı şeffaf koyu renk */
    border-radius: 15px; /* Köşeleri yuvarlatır */
    margin-bottom: 30px; /* Kartlar arası boşluk */
    width: 100%; /* Kartın bulunduğu alanı %100 kaplamasını sağlar! */
    overflow: hidden; /* Resmin köşelerden taşmasını engeller */
}

/* Hover efekti (İsteğe bağlı: Üzerine gelince kart hafifçe yukarı kalkar) */
.info-card:hover {
    transform: translateY(-5px);
    transition: 0.25;
}

/* Resmin olduğu bölüm */
.card-image {
    flex-shrink: 0; /* Resmin daralmasını engeller */
    width: 35%; /* Resim kartın %35'ini kaplasın */
}

.card-image img {
    width: 100%;
    height: 250px;
    object-fit: cover; /* Resmi sündürmeden alanı doldurur */
    display: block;
}

/* Yazıların olduğu bölüm */
.card-text {
    padding: 30px;
    width: 65%; /* Yazılar kartın %65'ini kaplasın */
    color: #e0e0e0; /* Açık gri okunabilir yazı rengi */
}

.card-text h2 a {
    color: #ffffff;
    text-decoration: none;
}

.card-text h2 a:hover {
    color: dodgerblue; /* Linkin üzerine gelince altı çizilsin */
    transition: 0.25;
}

    
</style>
</head>
<body>
    <header>
        <nav>
                    <div id="logo-container" style="cursor:pointer;">
       <a href="kullanici.php"><img id="site-logo" src="oyun-avcısı.jpg" width="30%" height="30%" title="Oyun-Avcısı.com" alt="Oyun-Avcısı.com"></a>
</div>
    <div id="logo-hint" style="display:none; position:fixed; background:#1793d1; color:white; padding:5px 10px; border-radius:5px; font-family:monospace; font-size:12px; z-index:10001;">
    Sistem Modu Değiştirildi!
</div>
            <div class="menu">
                            <ul>
                <li><a href="#bölüm1">Bölüm 1: Parçalar</a></li>
                <li><a href="#bölüm2">Bölüm 2: Hatalar</a></li>
            </ul>
            <ul>

                <li><div class="sekme2">
                <a href="Arch.php"><button class="sekme-tusu2">Arch</button></a>
                </div>
                </li>


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

<section id="top" class="full-page hero">
    <div class="content">

        <h1>Bilgisayar Temel Tamir</h1>
        <center><p>Öğreticisi</p></center>

    </div>
</section>
<!--
<section id="news" class="story-container">
    <div class="story-layout">

        <div class="story-text-column2">
            <h2 class="reveal-text">Neler Göreceğiz?</h2>

            <div class="text-block reveal-text">
                <table border="0">
      <tr>
        <td><img src="re9.jpg" width="85%" height="250"></td>
        <td><h2><a href="CPU.php">CPU (Central Processing Unit)</a></h2>
        <p>CPU nedir, ne işe yarar? Nasıl değiştirilir?</p>
        </td>
</tr>
</table>
</div>
<div class="text-block reveal-text">
<table border="0" width="100%">
      <tr>
        <td><img src="re9.jpg" width="85%" height="250"></td>
        <td><h2><a href="GPU.php">GPU (Graphics Processing Unit)</a></h2>
        <p>GPU nedir, ne işe yarar? Nasıl değiştirilir?</p>
        </td>
</tr>
</table>
</div>
<div class="text-block reveal-text">
<table border="0" width="100%">
      <tr>
        <td><img src="re9.jpg" width="85%" height="250"></td>
        <td><h2><a href="RAM.php">RAM (Random Access Memory)</a></h2>
        <p>RAM nedir, ne işe yarar? Nasıl değiştirilir?</p>
        </td>
</tr>
</table>
</div>
<br>
<br>
<br>
<br>
<a href="ihtiyac.php"><button class="don">Geri Dön</button></a>
</div>
-->

<section id="bölüm1" class="story-container">
    <div class="story-layout">
        <div class="story-text-column2">
            <h2 class="reveal-text">Bölüm 1: Parçaların Tanıtımı</h2>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <a href="CPU.php"><img src="cpu.jpg" alt="CPU"></a>
                </div>
                <div class="card-text">
                    <div id="cpu">
                    <h2><a href="CPU.php?kaynak=pct">CPU (Central Processing Unit)</a></h2>
                    <p>CPU nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="gpu.jpg" alt="GPU">
                </div>
                <div class="card-text">
                    <div id="gpu">
                    <h2><a href="GPU.php?kaynak=pct">GPU (Graphics Processing Unit)</a></h2>
                    <p>GPU nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="ram2.jpg" alt="RAM">
                </div>
                <div class="card-text">
                    <div id="ram">
                    <h2><a href="RAM.php?kaynak=pct">RAM (Random Access Memory)</a></h2>
                    <p>RAM nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="psu.jpg" alt="PSU">
                </div>
                <div class="card-text">
                    <div id="psu">
                    <h2><a href="PSU.php?kaynak=pct">PSU (Power Supply Unit)</a></h2>
                    <p>PSU nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="anakart.jpg" alt="Anakart">
                </div>
                <div class="card-text">
                    <div id="anakart">
                    <h2><a href="Anakart.php?kaynak=pct">Anakart (Motherboard)</a></h2>
                    <p>Anakart nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="ssd.jpg" alt="Depolama">
                </div>
                <div class="card-text">
                    <div id="ssd">
                    <h2><a href="Depolama.php?kaynak=pct">Depolama Birimleri (HDD, SSD, M2 (SATA, NVMe))</a></h2>
                    <p>Depolama nedir, ne işe yarar? Nasıl değiştirilir?</p>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>

<section id="bölüm2" class="story-container">
    <div class="story-layout">
        <div class="story-text-column2">
            <h2 class="reveal-text">Bölüm 2: Hatalar ve Çözümleri</h2>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="blackscreen.jpg" alt="Siyah Ekran Hatası">
                </div>
                <div class="card-text">
                    <div id="siyah-ekran">
                    <h2><a href="siyah-ekran.php?kaynak=pct">Siyah Ekran Hatası</a></h2>
                    <p>Siyah Ekran Hatası nedir, Neden olur? Nasıl düzeltilir?</p>
                </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="bluescreen.jpg" alt="BSOD Hatası">
                </div>
                <div class="card-text">
                    <div id="bsod">
                    <h2><a href="MaviEkran.php?kaynak=pct">BSOD (Blue Screen of Death (Mavi Ekran)) Hatası</a></h2>
                    <p>BSOD Arama Motoruna yönlendirileceksiniz</p>
                </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="ısı.jpg" alt="Thermal Throttling Hatası">
                </div>
                <div class="card-text">
                    <div id="ısınma">
                    <h2><a href="Thermal-Throttling.php?kaynak=pct">Thermal Throttling (Aşırı Isınma, Performans Kaybı ve Ani Kapanma)</a></h2>
                    <p>Thermal Throttling nedir, Neden olur? Nasıl düzeltilir?</p>
                </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="kernelpanic.png" alt="Kernel Panic Hatası">
                </div>
                <div class="card-text">
                    <div id="kernel-panic">
                    <h2><a href="Kernel-Panic.php?kaynak=pct">Kernel Panic (Linux Mavi Ekranı)</a></h2>
                    <p>Kernel Panic Hatası nedir, Neden olur? Nasıl düzeltilir?</p>
                </div>
                </div>
            </div>

            <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="dll-files.jpg" alt="DLL Hataları">
                </div>
                <div class="card-text">
                    <div id="dll">
                    <h2><a href="DLL-Hatalari.php?kaynak=pct">Eksik DLL Hataları</a></h2>
                    <p>Eksik DLL Hataları nedir, Neden olur? Nasıl düzeltilir?</p>
                    </div>
                </div>
            </div>

                <div class="info-card text-block reveal-text">
                <div class="card-image">
                    <img src="AI.jpg" alt="Yapay Zeka">
                </div>
                <div class="card-text">
                    <h2><a href="kullanici.php?sohbet=yapayzeka">Yapay Zeka Asistanına Sor</a></h2>
                    <p>Daha fazlası için Yapay Zeka Asistanımıza başvurabilirsiniz</p>
                </div>
            </div>



            
        </div>
    </div>
</section>

            <center><a href="ihtiyac.php"><button class="don">Geri Dön</button></a></center>

<!--============================================================================================================================================================================-->


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

//=====================================================================================================

(function() {
    const logoImg = document.getElementById('site-logo');
    const logoContainer = document.getElementById('logo-container');
    const hint = document.getElementById('logo-hint');

    let isArchMode = false;
    
    // Müzik dosyasını JS içinde tanımlıyoruz
    // DİKKAT: "soldier_of_dance.mp3" dosyasını sitenin ana dizinine eklemeyi unutma!
    const easterEggAudio = new Audio('TF2.ogg'); 
    easterEggAudio.loop = true; // Müzik bitince arka planda döngüye girsin

    // Ayarlar
    const config = {
        normal: {
            img: "oyun-avcısı.jpg",
            url: "kullanici.php"
        },
        secret: {
            img: "giphy.gif" // Arch logolu gif
        }
    };

    // 1. SAĞ TIK: Mod Değiştirme
    window.addEventListener('contextmenu', (e) => {
        // Sadece logo üzerindeyken mod değiştirmek istiyorsan buraya bir if kontrolü ekleyebilirsin
        // Şimdilik sayfanın neresine sağ tıklanırsa çalışır durumda
        e.preventDefault();
        
        isArchMode = !isArchMode; // Modu değiştir

        if (isArchMode) {
            logoImg.src = config.secret.img;
            showHint(e, "Arch Mode: ON (I use Arch btw)");
        } else {
            logoImg.src = config.normal.img;
            showHint(e, "Normal Mode: Restored");
            
            // Gizlilik modundan çıkınca müziği otomatik durdur ve başa sar
            easterEggAudio.pause();
            easterEggAudio.currentTime = 0;
        }
    });

    // 2. SOL TIK: Müzik Kontrolü ve Yönlendirme
    logoContainer.addEventListener('click', (e) => {
        e.preventDefault(); // Varsayılan link davranışını durdur
        
        if (isArchMode) {
            // Arch modundaysa YouTube'a gitmek yerine müziği başlat/durdur
            if (easterEggAudio.paused) {
                easterEggAudio.play();
                showHint(e, "🎵 Kazotsky Kick! (Durdurmak için tıkla)");
            } else {
                easterEggAudio.pause();
                showHint(e, "Müzik durduruldu");
            }
        } else {
            // Normal moddaysa ana sayfaya git
            window.location.href = config.normal.url; 
        }
    });

    // İpucu Fonksiyonu
    function showHint(event, text) {
        hint.innerText = text;
        hint.style.display = 'block';
        hint.style.left = (event.clientX + 10) + 'px';
        hint.style.top = (event.clientY + 10) + 'px';
        setTimeout(() => { hint.style.display = 'none'; }, 2000);
    }
})();



//======================================================================================================

const observerOptions = {
    threshold: 0.5 // Yazının %50'si göründüğünde tetiklensin
};

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Ekrana girdiğinde opaklık %100 olur
            entry.target.classList.add('visible');
        } else {
            // Ekrandan çıktığında (yukarı veya aşağı) tekrar görünmez olur
            entry.target.classList.remove('visible');
        }
    });
}, observerOptions);

// Tüm başlık ve paragrafları dinlemeye al
document.querySelectorAll('.reveal-text').forEach(el => revealObserver.observe(el));


</script>
</body>
</html>