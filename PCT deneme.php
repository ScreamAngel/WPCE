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
    #arch-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: transparent; z-index: 9999; display: none;
    }
    #matrix-canvas {
        position: absolute; top: 0; left: 0; z-index: 1;
    }
    /* Arka planı karartacak olan asıl katman */
    #fade-layer {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-color: black; opacity: 0; z-index: 2;
        transition: opacity 3s ease-in-out;
    }
    #terminal-content {
        position: relative; z-index: 3; color: #00ff00;
        font-family: 'Courier New', monospace; padding: 50px;
        text-shadow: 2px 2px 5px black; /* Okunabilirliği artırır */
    }

    #init-screen {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: #000; display: flex; flex-direction: column;
        justify-content: center; align-items: center; z-index: 10000;
        font-family: 'Courier New', monospace;
    }
    #start-btn {
        padding: 15px 30px; background: transparent; color: #00ff00;
        border: 2px solid #00ff00; cursor: pointer; font-size: 1.2rem;
        transition: 0.3s;
    }
    #start-btn:hover { background: #00ff00; color: #000; }

    /* Yükleme Barı Konteynırı */
    #progress-container {
        display: none; width: 300px; border: 1px solid #00ff00;
        padding: 3px; margin-top: 20px;
    }
    /* Dolacak olan Yeşil Bar */
    #progress-bar {
        width: 0%; height: 20px; background: #00ff00;
        transition: width 0.1s linear;
    }
    #status-text { color: #00ff00; margin-top: 10px; display: none; }


/* Layout Yapısı */
.story-container {
    width: 100%;
    min-height: 200vh; /* Yazıların akması için uzun bir alan */
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




    
</style>
</head>
<body>
<header>
        <nav>
    <div id="logo-container" style="cursor:pointer;">
       <a href="https://www.youtube.com/watch?v=i-7QDCfkaxY"><img id="site-logo" src="oyun-avcısı.jpg" width="30%" height="30%" title="Oyun-Avcısı.com" alt="Oyun-Avcısı.com"></a>
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
        <a href="iletisim-sec.php"><button class="sekme-tusu">İletişim</button></a>
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

<section id="news" class="story-container">
    <div class="story-layout">

        <div class="story-text-column2">
            <h2 class="reveal-text">Neler Göreceğiz?</h2>

            <div class="text-block reveal-text">
                <p>Burada Laptop ve Kasalarda anakart üzerindeki parçaların temel tamirini öğreneceksiniz. Burada genel olarak parça değişimi, sorun bulma ve çözme gibi şeyleri göreceksiniz.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Bu kısımı 3 başlık altında inceleyeceğiz. Önce Parçaların isimleri, türlerini göreceğiz. Sonra değişimini anlatacağız ve son olarak sistemde oluşan bir problemde nasıl anlayacağınızı anlatacağız.</p>
            </div>

            <div class="text-block reveal-text">
                <p>O zaman başlayalım. Umarım bu sayfada görecekleriniz size yardımcı olur.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Öncelikle Parçaları öğrenelim. Bilgisayarlarda temel parçalar: Anakart, Ram, CPU (Central Processing Unit) diğer adıyla İşlemci, GPU (Graphics Processing Unit) diğer adıyla ekran kartı, PSU (Power Supply Unit) diğer adıyla güç kaynağı ve son olarak CPU soğutucusu. </p>
            </div>

            

            

            <!--
            <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="pcc.png" alt="PC Tamir">

                </div>
            </div>
        </div>
-->
</section>

<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">CPU (Central Processing Unit), İşlemci</h2>
            
            <div class="text-block reveal-text">
                <p>CPU bilgisayar, telefon, televizyon gibi sistemlerinin beynidir. Sistem üzerinde yapılacak herhangi bir işlem önce CPU'nun elinden geçer. Örneğin klavyede bir tuşa basmanız bile CPU'ya iletilir ve CPU'da işlendikten sonra gerekli yerlere gönderilir.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Hiç fark ettiniz mi? Genelde sistem güç tuşuna basıldığında işlemci fanı önce dönmeye başlar. Bunun nedeni sistem açılışı sırasında tüm sistem görevleri aniden CPU'ya gönderilir ve CPU bu işlemleri yaparken ısınmaya başlar. Fanlar bu ısıyı önlemek için erkenden çalışmaya başlar.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Sistem açılışında güç kaynağı çalıştıktan sonra CPU'ya bilgi gider. CPU bu bilgileri işler ve diğer parçalara gönderip onları da uyandırır. O parçalar geri tepki vererek CPU'ya bilgi gönderir. Sonrasında CPU Ram'lere bilgi gönderir. Ram'ler görüntü bilgilerini derler ve CPU'ya geri gönderir, sonrasında o bilgiler GPU'ya (Graphics Processing Unit), yani ekran kartına gönderilir ve görüntü ekrana gelir.</p>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="cpu.jpg" alt="Leon Kennedy">

                </div>
            </div>
        </div>

    </div>
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
                <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <a href="https://www.youtube.com/watch?v=fXVy4mALHLY"><img src="re93.jpg" alt="Leon Kennedy"></a>

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">GPU (Graphics Processing Unit), Ekran Kartı</h2>
            
            <div class="text-block reveal-text">
                <p>Yakında yazılacak. Resim şimdilik geçici süre duracak (Sponsor)</p>
            </div>
            
            <div class="text-block reveal-text">
                <p></p>
            </div>

            <div class="text-block reveal-text">
                <p></p>
            </div>
        </div>



    </div>
</section>

<!--============================================================================================================================================================================-->


<div id="arch-overlay">
    <canvas id="matrix-canvas"></canvas>
    <div id="fade-layer"></div>
    <div id="terminal-content"></div>
</div>

<div id="init-screen">
    <button id="start-btn">SİSTEMİ TARA VE ONARIMI BAŞLAT</button>
    <div id="progress-container">
        <div id="progress-bar"></div>
    </div>
    <div id="status-text">Sistem dosyaları taranıyor...</div>
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



//======================================================================================================


// Ses Dosyalarını Tanımlama ve Ön Yükleme
const sfx = {
    ambient: new Audio('sounds/sci_fi_drone.mp3'),
    riser: new Audio('sounds/riser.mp3'),
    ezio: new Audio('sounds/matrix.ogg'),
    beep: new Audio('sounds/system_beep.mp3')
};

// Ses ayarları
sfx.ambient.loop = true;
sfx.ambient.volume = 1;

let inputBuffer = "";
const codes = ["121310", "11838"];

window.addEventListener('keydown', (e) => {
    if (e.key >= '0' && e.key <= '9') {
        inputBuffer += e.key;
        if (inputBuffer.length > 10) inputBuffer = inputBuffer.substring(1);
        
        if (codes.some(code => inputBuffer.endsWith(code))) {
            startArchSequence();
            inputBuffer = "";
        }
    }
});

document.getElementById('start-btn').addEventListener('click', function() {

            const btn = this;
    const container = document.getElementById('progress-container');
    const bar = document.getElementById('progress-bar');
    const status = document.getElementById('status-text');
    const initScreen = document.getElementById('init-screen');

    // 1. Sesleri "Uyandır" (Mühürleme işlemi)
    Object.values(sfx).forEach(sound => {
        sound.play().then(() => {
            sound.pause();
            sound.currentTime = 0;
        }).catch(e => console.log("Ses uyandırma hatası:", e));
    });

    Object.entries(sfx).forEach(([name, sound]) => {
        if (name !== 'riser') {
            sound.play().then(() => { sound.pause(); sound.currentTime = 0; }).catch(() => {});
        }
    });

sfx.riser.pause(); // Eğer arka planda takılı kalmışsa durdur
    sfx.riser.currentTime = 0;
    sfx.riser.volume = 1; // Duyulması için %80'e çekelim
    sfx.riser.loop = true;

    // Küçük bir gecikmeyle başlat (Tarayıcının kendine gelmesi için 50ms)
    setTimeout(() => {
        sfx.riser.play()
            .then(() => console.log("riser şu an %80 sesle çalıyor!"))
            .catch(e => console.error("Başlatma başarısız:", e));
    }, 50);
    
    // 2. Görsel Geçiş
    btn.style.display = 'none';
    container.style.display = 'block';
    status.style.display = 'block';

    // 3. Yükleme Barı Animasyonu
    let width = 0;
    let interval = setInterval(() => {
        if (width >= 100) {
            clearInterval(interval);
            status.innerText = "Sistem Onarıldı. Hazır.";
            fadeOutMusic(sfx.riser, 1000);
            setTimeout(() => {
                document.getElementById('init-screen').style.opacity = "0";
                setTimeout(() => {
                    document.getElementById('init-screen').style.display = 'none';
                    console.log("Ses motoru artık serbest. Kodu girebilirsin.");
                }, 500);
            }, 1000);
        } else {
            width += 1; // Yükleme hızı
            bar.style.width = width + "%";
            if(width > 30) status.innerText = "Kütüphaneler doğrulanıyor...";
            if(width > 60) status.innerText = "Bağlantı noktaları optimize ediliyor...";
            if(width > 80) status.innerText = "Eksik dosyalar yeniden derleniyor...";
        }
    }, 50);
});

function fadeOutMusic(audio, duration) {
    let vol = audio.volume;
    let interval = 50;
    let step = vol / (duration / interval);
    
    let fadeOut = setInterval(() => {
        if (audio.volume > step) {
            audio.volume -= step;
        } else {
            audio.volume = 0;
            audio.pause();
            audio.currentTime = 0; // Başa sar ki ilerde Arch modunda tekrar çalabilsin
            audio.volume = 0.4; // Orijinal seviyesine geri getir (hazırda beklesin)
            clearInterval(fadeOut);
        }
    }, interval);
}

function lowerVolume(audio, targetVolume) {
    let interval = setInterval(() => {
        if (audio.volume > targetVolume) {
            audio.volume -= 0.05;
        } else {
            clearInterval(interval);
        }
    }, 200);
}

async function startArchSequence() {

    const overlay = document.getElementById('arch-overlay');
    const fadeLayer = document.getElementById('fade-layer');
    const terminal = document.getElementById('terminal-content');
    const fishOverlay = document.getElementById('matrix-fish-overlay');

    
    overlay.style.display = 'block';
    startMatrixEffect(); // Arka planda akmaya başlasın
    
    sfx.ambient.play().catch(e => console.log("Ambient hata:", e));

    // 1. Matrix başlar başlamaz kararma efekti başlasın
    setTimeout(() => {
        fadeLayer.style.opacity = "0.85"; // %85 karart ki alttan yeşil yazılar hafifçe seçilsin
    }, 100);



    await sleep(3000); // 3 saniye sonra terminal yazıları başlasın

    // --- KRİTİK DÜZELTME: Ezio's Family burada başlıyor ---
    lowerVolume(sfx.ambient, 0);
    fadeInMusic(sfx.ezio);
    
    
    // 2. Terminal Yazıları (Okunabilir şekilde)
    await typeLine(terminal, "> Arch Mode Activated...", 100);
    await sleep(1000);
    lowerVolume(sfx.ezio, 0.3);
    await typeLine(terminal, "> sudo nano /etc/pacman.conf", 50);
    await sleep(1900);
    await typeLine(terminal, ":: Multilib will be enable after use sudo pacman -Sy", 50);
    await sleep(1000);
    await typeLine(terminal, "> sudo pacman -Sy", 50);
    await sleep(1500);
    await typeLine(terminal, ":: Synchronizing multilib...", 30);
    await sleep(1000);
    await typeLine(terminal, "> sudo pacman -S reflector", 50);
    await sleep(1500);
    await typeLine(terminal, ":: reflector has been installed", 30);
    await sleep(1000);
    await typeLine(terminal, "> git clone https://aur.archlinux.org/paru.git", 50);
    await sleep(1500);
    await typeLine(terminal, "> cd paru", 50);
    await sleep(1000);
    await typeLine(terminal, "> makepkg -si", 50);
    await sleep(4500);
    await typeLine(terminal, ":: paru has been installed", 30);
    await sleep(1000);
    await typeLine(terminal, "> sudo pacman -Syu", 50);
    await sleep(1000);
    await typeLine(terminal, ":: system will be scan and prepared for updating", 30);
    await sleep(3500);
    await typeLine(terminal, ":: system scanned and there is no error", 30);
    await sleep(1000);
    await typeLine(terminal, ":: system update start now", 30);
    await sleep(1000);
    await typeLine(terminal, ":: system update continue, please do not turn off your PC...", 30);
    await sleep(5000);
    await typeLine(terminal, ":: system update finished", 30);
    await sleep(1500);
    
    // 3. Tam Kararma ve Yönlendirme
    fadeLayer.style.opacity = "1"; // Ekranı tamamen kapat
    await sleep(1000);
    await typeLine(terminal, ":: System ready. Redirecting...", 30);
    await sleep(2000);
    
    window.location.href = "arch.php";
}
// Yardımcı Fonksiyonlar
function sleep(ms) { return new Promise(resolve => setTimeout(resolve, ms)); }

// typeLine fonksiyonunu sesiz hale getirdik
async function typeLine(element, text, speed) {
    const line = document.createElement('div');
    element.appendChild(line);
    for (let char of text) {
        line.innerHTML += char;
        await sleep(speed);
    }
}

function fadeInMusic(audio) {
    audio.play();
    let vol = 0;
    let interval = setInterval(() => {
        if (vol < 0.6) {
            vol += 0.05;
            audio.volume = vol;
        } else {
            clearInterval(interval);
        }
    }, 200);
}


function startMatrixEffect() {
    const canvas = document.getElementById('matrix-canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const chars = "ARCHLINUX01".split("");
    const fontSize = 16;
    const columns = canvas.width / fontSize;
    const drops = Array(Math.floor(columns)).fill(1);

    const interval = setInterval(() => {
        ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = "#0F0";
        ctx.font = fontSize + "px monospace";

        drops.forEach((y, i) => {
            const text = chars[Math.floor(Math.random() * chars.length)];
            ctx.fillText(text, i * fontSize, y * fontSize);
            if (y * fontSize > canvas.height && Math.random() > 0.975) drops[i] = 0;
            drops[i]++;
        });
    }, 33);

    return () => clearInterval(interval);
}

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

// Sağ menüdeki linklere tıklayınca yumuşak kaydırma
document.querySelectorAll('.nav-link').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
</body>
</html>