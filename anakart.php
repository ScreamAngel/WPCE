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
    $geriLink = "PCT.php#anakart";
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
        
        <div class="story-text-column">
            <h2 class="reveal-text">Motherboard, Anakart</h2>
            
            <div class="text-block reveal-text">
                <p>Anakart (Motherboard), bilgisayarın tüm donanım bileşenlerinin (CPU, GPU, RAM, depolama) üzerine takıldığı, bu parçaların elektriksel olarak beslenmesini ve birbirleriyle veri alışverişi yaparak koordineli çalışmasını sağlayan ana baskılı devre kartıdır (PCB).</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Anakart, üzerine takılan bileşenler arasında veri yollarını (bus) oluşturarak iletişimin gerçekleştiği devasa bir ağ gibidir. CPU, RAM, ekran kartı, ses kartı ve depolama aygıtları gibi tüm parçalar, anakart üzerindeki yuvaya (socket) veya porta (port) takılarak anakarta fiziksel ve elektriksel olarak bağlanır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>şlemciyi bilgisayarın beyni, güç kaynağını kalbi, ekran kartını da kas gücü olarak tanımlamıştık. Bu analojiye göre anakart, tüm bu organları bir arada tutan iskelet ve aralarındaki iletişimi sağlayan sinir sistemidir.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Anakart seçimi, sistemin geleceği açısından kritik öneme sahiptir çünkü anakart, CPU, RAM ve genişleme kartlarının (ekran kartı, ses kartı vb.) hangi standartlarda ve kapasitelerde çalışabileceğini belirler. Yanlış anakart seçimi, pahalı bileşenlerin uyumsuz olmasına ve sistemin potansiyel performansının kısıtlanmasına neden olabilir. Bu nedenle, anakartın yonga seti, desteklediği bellek hızı ve türü, port sayıları ve form faktörü (ATX, Micro-ATX, ITX gibi) gibi teknik özellikler dikkatlice değerlendirilmelidir.</p>
            </div>
                        <div class="text-block reveal-text">
                <p>Detaylı anakart değişimi videoları için aşağıdaki linke bakabilirsiniz. Laptoplarda anakart değişimi laptop'taki tüm her şeyi sökerek yapılması gerektiği için sabit bir video önermek zordur. Bu yüzden bu konuda bir bilee danışmak en iyisidir</p>
                <br><br>
                <p style="background-color: black;"><a href="https://www.youtube.com/watch?v=ExOPdpnjpQk"><b>Kasalarda PSU Değişimi Videosu İçin Tıklayınız. (Eğer kendiniz yapacaksanız dikkatli olun. Eğer hiç el yatkınlığınız yoksa işi bir uzmana yaptırın.)</b></a></p>
                <br><br>
            </div>
            <div class="text-block reveal-text">
                <center><a href="<?php echo $geriLink; ?>"><button class="don">Geri Dön</button></a></center>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="anakart.jpg" alt="Anakart">

                </div>
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