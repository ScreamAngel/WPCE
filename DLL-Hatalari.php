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

if($_GET['kaynak'] == 'pct') {
    $geriLink = "PCT.php#dll";
}   
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
b{
    text-decoration: underline;
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

<section id="story" class="story-container">
    <div class="story-layout">
        
                <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="dll-files.jpg" alt="DLL Hataları">

                </div>
            </div>
        </div>
        
        <div class="story-text-column">
            <h2 class="reveal-text">DLL Hataları</h2>
            
            <div class="text-block reveal-text">
                <p><b>DLL (Dinamik Bağlantı Kütüphanesi)</b> hataları, bir program çalıştırılmaya çalışıldığında ortaya çıkan ve genellikle işletim sisteminin veya uygulamanın ihtiyaç duyduğu bir dosyanın eksik, bozuk veya uyumsuz olduğunu belirten hatalardır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p><b><font color="red">Genel Nedenler:</font></b><br><br>

1. <b><font color="red">Eksik veya Bozuk DLL Dosyaları:</font></b> En sık karşılaşılan nedendir. Gerekli DLL dosyası sistemde bulunamaz veya hasar görmüştür.<br><br>
2. <b><font color="red">Yazılım Çakışmaları:</font></b> İki veya daha fazla program aynı DLL dosyasının farklı sürümlerini kullanmaya çalıştığında çakışma yaşanabilir.<br><br>
3. <b><font color="red">Sürücü Sorunları:</font></b> Özellikle ekran kartı, ses kartı veya diğer donanımların sürücüleri bozulmuş veya uyumsuz olduğunda DLL hataları ortaya çıkabilir.<br><br>
4. <b><font color="red">Kötü Amaçlı Yazılımlar:</font></b> Virüsler ve casus yazılımlar DLL dosyalarını değiştirebilir veya silebilir.<br><br>
5. <b><font color="red">Yetersiz Disk Alanı:</font></b> Disk alanı bittiğinde sistem yeni DLL dosyalarını yazamaz ve hata verir.<br><br>
6. <b><font color="red">Windows Update Hataları:</font></b> Güncellemeler sırasında yaşanan kesintiler veya uyumsuzluklar DLL hatalarına yol açabilir.</p>
            </div>

            <div class="text-block reveal-text">
                <p><b><font color="red">Çözüm Yöntemleri:</font></b><br><br>

1. <b><font color="red">DLL Dosyalarını Onarma:</font></b><br><br>

- <b><font color="red">SFC (System File Checker) Taraması:</font></b> Komut istemini yönetici olarak çalıştırıp <b>sfc /scannow</b> komutunu kullanabilirsiniz.<br><br>
- <b><font color="red">DISM Aracı:</font></b> <b>DISM /Online /Cleanup-Image /RestoreHealth</b> komutu ile sistem dosyalarını onarabilirsiniz.<br><br>
2. <b><font color="red">Programları Onarma veya Yeniden Yükleme:</font></b> Hata veren programı Denetim Masası'ndan onarmayı veya tamamen kaldırıp yeniden yüklemeyi deneyin.<br><br>
3. <b><font color="red">Sürücüleri Güncelleme:</font></b> Özellikle ekran kartı ve ses kartı sürücülerini üreticinin web sitesinden indirip kurun.<br><br>
4. <b><font color="red">Windows Güncellemelerini Kontrol Etme:</font></b> Eksik güncellemeleri yükleyin veya sorunlu güncellemeleri kaldırın.<br><br>
5. <b><font color="red">Kötü Amaçlı Yazılımları Temizleme:</font></b> Güvenilir bir antivirüs programı ile tam sistem taraması yapın.<br><br>
6. <b>Disk Alanını Kontrol Etme:</b> Gerekirse diskteki gereksiz dosyaları silerek yer açın.</p>
            </div>

            <div class="text-block reveal-text">
                <p><b><font color="red">Özel Çöz</font>ümler:</b><br><br>

- <b><font color="red">DirectX S</font>orunl<font color="red">arı:</font></b> DirectX onarım aracını indirip çalıştırabilirsiniz.<br><br>
- <b><font color="red">Visual C++ Re</font>distri<font color="red">butable:</font></b> İlgili Visual C++ paketini Microsoft'un web sitesinden indirip kurun.<br><br>
- <b><font color="red">Program Bağımlılık</font>larını<font color="red"> Kontrol Etme:</font></b> Programın ihtiyaç duyduğu tüm bileşenlerin yüklü olduğundan emin olun.<br><br>
- <b><font color="red">Sistem Geri Yükleme:</font></b> Sorunun başlamadığı bir tarihe sistem geri yükleme yapmayı deneyin.</p>
            </div>

            <div class="text-block reveal-text">
                <center><a href="<?php echo $geriLink; ?>"><button class="don">Geri Dön</button></a></center>
            </div>
        </div>

    </div>
</section>

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