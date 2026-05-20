<?php
include("connection.php");
session_start();

$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($user_session || $admin_session)) {
    header('Location: giris.php'); 
    exit;
}

$email = $_SESSION['user'] ?? $_SESSION['admin'] ?? null;

$query = mysqli_query($conn, "SELECT profile_image FROM users WHERE email = '$email'");
$user_data = mysqli_fetch_assoc($query);
$user_photo = (!empty($user_data['profile_image'])) ? $user_data['profile_image'] : "default-avatar.png";
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Evil Style | Fan Page</title>
    <style>
	* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #050505;
    color: white;
    overflow-x: hidden;
}

/* Navigasyon */
header {
    position: fixed;
    width: 99%;
    height: 85px;
    z-index: 1000;
    margin-right: 0.5%;

}

nav {
    display: flex;
    justify-content: space-between;
    height: 100%;
    align-items: center;
}


/* Hero Bölümü */
.hero {
    height: 100vh;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), 
                url('https://images.alphacoders.com/131/1311029.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.hero-h1 {
    font-size: 5rem;
    letter-spacing: 10px;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 15px 40px;
    border: 2px solid white;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    margin-top: 20px;
    transition: 0.4s;
}

.btn:hover {
    background-color: white;
    color: black;
}

/* İçerik Bölümü */
.content-section {
    padding: 100px 10%;
    height: 80vh;
    display: flex;
    align-items: center;
    background: #0a0a0a;
}

/* Animasyon Sınıfı */
/* Başlangıç hali: Görünmez ve aşağıda */
.reveal {
    opacity: 0;
    transform: translateY(50px);
    /* Buradaki transition'ı siliyoruz veya çok kısa tutuyoruz */
}

/* Aktif hali: Görünür ve yerinde */
.reveal.active {
    opacity: 1;
    transform: translateY(0);
    transition: 1s all ease; /* Animasyon sadece buradayken çalışır */
}

.hero {
    height: 100vh;
    position: relative; /* İçindeki elemanların konumlanması için şart */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    overflow: hidden; /* Videonun taşmasını engeller */
}

.back-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Videonun en-boy oranını bozmadan alanı kaplamasını sağlar */
    z-index: -1; /* Videoyu en arka katmana atar */
}

/* Videonun üzerindeki yazıların okunabilirliğini artırmak için bir 'Overlay' (Maske) */
.hero::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4); /* Siyah, yarı şeffaf bir katman */
    z-index: 0;
}

.hero-content {
    z-index: 1; /* İçeriği maskenin ve videonun üzerine çıkarır */
}


.sekme {
  position: relative;
  display: inline-block;
}


.sekme-tusu {
  background-color: transparent;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  font-size: 16px;
  text-shadow: 2px 2px 3px black;
  border-radius: 10px;
}


.sekme-tusu:hover {
  background-color: dodgerblue;
  transform:scale(1.05);
  transition:0.3s;
  border-radius: 10px;
}


.sekme-icerik {
  display: none;
  position: absolute;
  background-color: white;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  width: 152px;
  z-index: 1;
  transition: 0.3s;
  border-radius: 10px;
}


.sekme-icerik a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  border-radius: 10px;
}


.sekme-icerik a:hover {
  background-color: #f0f0f0;
  transition: 0.3s;
}


.sekme:hover .sekme-icerik {
  display: block;
  transition: 0.3s;
}


.sekme:hover .sekme-tusu {
  background-color: dodgerblue;
}

main{
  color: white;
  padding-top: 150px;
}


ul:hover{
  color: dodgerblue;
  transition: 0.25s;
}

li:hover{
  color: dodgerblue;
  transition: 0.25s;
}

a:hover{
  color: dodgerblue;
  transition: 0.25s;
}


ul{
  list-style-type: none;
  display: flex;
  column-gap: 30px;
  text-decoration: none;
  color: white;
}

li{
  text-decoration: none;
  color: white;
}

a{
  text-decoration: none;
  color: white;
}

.menu{
  display: flex;
  align-items: center;
  column-gap: 40px;
}

.menu-button{
  color: dodgerblue;
  text-decoration: none;
  background-color: #ffffff;
  padding: 12px 24px;
  border-radius: 56px;
}

.menu-button:hover{
  background-color: dodgerblue;
  color: white;
  transition: 0.25s;
    transform: scale(1.05);
}


b{
    text-decoration: underline;
}


    </style>
</head>
<body>
<!--
    <header>
        <nav>
            <div class="logo">WPCE</div>
            <ul>
                <li><a href="kullanici.php">GERİ DÖN</a></li>
                <li><a href="#home">BAŞLANGIÇ</a></li>
                <li><a href="#about">HAKKINDA</a></li>
                <li><a href="#media">MEDYA</a></li>
            </ul>
        </nav>
    </header>
-->

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
                <img src="uploads/<?php echo $user_photo; ?>"
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

    <section id="home" class="hero">
        <video autoplay muted loop playsinline class="back-video">
        <source src="Saul goodman 3d.webm" type="video/mp4">
        Tarayıcınız video etiketini desteklemiyor.
    </video>
        <div class="hero-content">
            <h1>Arch Linux</h1>
            <p>Hızlı bir Arch Linux özeti için tıklayın</p>
            <a href="https://www.youtube.com/watch?v=vvoRCXQViS0" class="btn">Video izle</a>
        </div>
    </section>



    <section id="about" class="content-section">
        <div class="reveal">
            <h2>Arch Linux Nedir?</h2>
            <p>Arch, Linux çekirdek temelleri üzerine kurulu, basit, hafif ve esnek bir işletim sistemidir. Arch felsefesi basitlik, modernlik, paragm ve kullanıcı merkezlilik üzerine kuruludur. Arch, diğer dağıtımların aksine önceden yapılandırılmış bir sistem sunmaz. Kullanıcıya sistemi kurarken donanım seçimi, masaüstü ortamı seçimi gibi birçok konuda özgürlük tanır. Bu sayede kullanıcı kendi ihtiyaçlarına göre özelleştirilmiş bir sistem kurabilir. Arch, aynı zamanda <a href="https://archlinux.org/"><b>Arch Linux</b></a>'un resmi dağıtımıdır.</p>
        </div>
    </section>

    

    <section id="media" class="content-section">
        <div class="reveal">
            <h2>Kurulum Rehberi</h2><br>
            <p>Kullanıcıya sistemi kurarken donanım seçimi, masaüstü ortamı seçimi gibi birçok konuda özgürlük tanır. Kurulum ilk çalıştığında kurulum <b>RAM</b>'e yazılır. Bu yüzden kurulum sırasında bir sorun oluşursa kurulumu tekrar yapmanız gerekir. Kurulum sırasında bir sorun oluşursa kurulumu tekrar yapmanız gerekir. RAM'e yazıldıktan sonra önünüze bir ekran gelir. Burada öncelikle internete bağlanmamız gerekir. Öncelikle Wi-fi'a bağlanmak için <b>systemctl start iwd</b> komutunu yazarak internet bağlantı servisini başlatın. Sonrasında <b>iwctl</b> yazarak wi-fi servisine girin. Ardından <b>station list</b> komutunu yazarak internet kartınızı bulun. Karşınıza wlan0 gibi isimler çıkacaktır. Sonrasında <b>station wlan0 scan</b> diyerek internet bağlantılarını tarayınız. Ardından <b>station wlan0 get-networks</b> komutunu yazarak internet bağlantılarını listeleyin. Karşınıza internet bağlantılarının isimleri çıkacaktır. Bağlanmak istediğiniz interneti seçin. Ardından <b>station wlan0 connect 'Wi-fi Adı'</b> yazın. Ardından şifreyi yazmanız için yer gelecek ve oraya internetin şifresini yazarak internete bağlanın.</p>
        <br><br><br>
            <p>Eğer <b>station wlan0 scan</b> komutundan sonra karşınıza hata çıkarsa ya da boş liste çıkarsa burada iki seçenek var. <br><br> 1) Ethernet kablosu takmak. <br><br> 2) Telefonu USB ile bağlayıp internete açmak <br><br> Eğer telefondan bağlanacaksanız öncelikle telefonu usb ile takıp usb ile bağlanmayı aktif ettikten sonra kuruluma <b>ls /sys/class/net</b> yazın. Ardından çıkan yazılarda en alttakilerden birisi büyük ihtimalle telefonun internet kartıdır. Oradaki hangisinin telefonun internet kartı olduğunu bulduktan sonra <b>dhcpcd (internet_kartı_adı)</b> komutunu yazarak internete bağlanın. İnternete bu üç yoldan biriyle bağlandıktan sonra <b>archinstall</b> komutunu yazarak kurulum ekranına ilerleyin. Kurulum ekranında dil, klavye, bölge, disk, masaüstü ortamı, çekirdek, yöneticilik, kullanıcı adı, şifre, önyükleyici, saat ayarı, ağ ayarları gibi ayarları yaptıktan sonra kur tuşuna basarak kurulumu başlatın. Kurulum bittikten sonra <b>reboot</b> komutunu yazarak sistemi yeniden başlatın.</p>
<br><br>
            <h2>Kurulum Videosu</h2>
            <p>Arch Linux kurulum videosu için tıklayın: <a href="https://www.youtube.com/watch?v=LiG2wMkcrFE"><b><font color="dodgerblue">Arch Linux Kurulumu</font><b></a></p><br><br>
            <p>Yakın zamanda kendi Arc hlinux Kurulum videomu çekeceğim. O zmaan geldiğinde buradaki linki yenileyeceğim</p>
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

//=====================================================================================================

(function() {
    const logoImg = document.getElementById('site-logo');
    const logoContainer = document.getElementById('logo-container');
    const hint = document.getElementById('logo-hint');

    // Modları sırayla geçmek için bir değişken: 0 = Normal, 1 = Arch, 2 = Saul Goodman
    let currentMode = 0; 
    
    // Müzik dosyaları
    const easterEggAudio = new Audio('asd.ogg'); 
    const easterEggAudio2 = new Audio('sg.ogg'); 
    const easterEggAudio3 = new Audio('matrix.ogg');
    easterEggAudio.loop = true; 
    easterEggAudio2.loop = true;
    easterEggAudio3.loop = true;

    // Ayarlar (Virgül hatası düzeltildi)
    const config = {
        normal: {
            img: "oyun-avcısı.jpg",
            url: "kullanici.php"
        },
        arch: {
            img: "giphy.gif" // Arch logolu gif
        },
        saul: {
            img: "sg.gif"    // Saul Goodman logolu gif
        },
        matrix: {
            img: "matrix.gif"    // Matrix logolu gif
        }
    };

    // 1. SAĞ TIK: Mod Değiştirme Döngüsü
    window.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        
        // Sağ tıklandıkça mod 0, 1, 2 arasında döner
        currentMode = (currentMode + 1) % 4;

        if (currentMode === 1) {
            // Arch Modu
            logoImg.src = config.arch.img;
            showHint(e, "Arch Mode: ON (I use Arch btw)");
            
            // Diğer müziği kapat
            easterEggAudio2.pause();
            easterEggAudio2.currentTime = 0;
            easterEggAudio3.pause();
            easterEggAudio3.currentTime = 0;
        } 
        else if (currentMode === 2) {
            // Saul Goodman Modu
            logoImg.src = config.saul.img;
            showHint(e, "Saul Goodman Mode: ON (Better Call Saul!)");
            
            // Diğer müziği kapat
            easterEggAudio.pause();
            easterEggAudio.currentTime = 0;
            easterEggAudio3.pause();
            easterEggAudio3.currentTime = 0;
        }

        else if (currentMode === 3) {
            // Matrix Modu
            logoImg.src = config.matrix.img;
            showHint(e, "Matrix Mode: ON (Choose Red pill or Blue pill!)");
            
            // Diğer müziği kapat
            easterEggAudio.pause();
            easterEggAudio.currentTime = 0;
            easterEggAudio2.pause();
            easterEggAudio2.currentTime = 0;
        }
        else {
            // Normal Mod (Sıfırlama)
            logoImg.src = config.normal.img;
            showHint(e, "Normal Mode: Restored");
            
            // Tüm müzikleri kapat
            easterEggAudio.pause();
            easterEggAudio.currentTime = 0;
            easterEggAudio2.pause();
            easterEggAudio2.currentTime = 0;
            easterEggAudio3.pause();
            easterEggAudio3.currentTime = 0;
        }
    });

    // 2. SOL TIK: Müzik Kontrolü ve Yönlendirme
    logoContainer.addEventListener('click', (e) => {
        e.preventDefault(); // Varsayılan link davranışını durdur
        
        if (currentMode === 1) {
            // Arch Modu Müzik Kontrolü
            if (easterEggAudio.paused) {
                easterEggAudio.play();
                showHint(e, "🎵 Don't Touch My Pizza! (Durdurmak için tıkla)");
            } else {
                easterEggAudio.pause();
                showHint(e, "Müzik durduruldu");
            }
        } 
        else if (currentMode === 2) {
            // Saul Modu Müzik Kontrolü
            if (easterEggAudio2.paused) {
                easterEggAudio2.play();
                showHint(e, "🎵 It's Saul Goodman! (Durdurmak için tıkla)");
            } else {
                easterEggAudio2.pause();
                showHint(e, "Müzik durduruldu");
            }
        } 
        else if (currentMode === 3) {
            // Matrix Modu Müzik Kontrolü
            if (easterEggAudio3.paused) {
                easterEggAudio3.play();
                showHint(e, "🎵 The Matrix is Calling! (Durdurmak için tıkla)");
            } else {
                easterEggAudio3.pause();
                showHint(e, "Müzik durduruldu");
            }
        }
        else {
            // Normal Mod - Ana Sayfaya Git
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

// Gözlemci seçenekleri: %20'si göründüğünde tetiklensin
const options = {
    threshold: 0.2 
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Ekrana girdiğinde animasyonu başlat
            entry.target.classList.add('active');
        } else {
            // Ekrandan çıktığında animasyonu sıfırla
            entry.target.classList.remove('active');
        }
    });
}, options);

// Tüm .reveal sınıflarını gözlemlemeye başla
const revealElements = document.querySelectorAll('.reveal');
revealElements.forEach(el => observer.observe(el));


    </script>

</body>
</html>