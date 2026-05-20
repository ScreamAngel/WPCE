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

if ($_GET['kaynak'] == 'pct') {
        $geriLink = "PCT.php#kernel-panic";
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
        
        <div class="story-text-column">
            <h2 class="reveal-text">Kernel Panic</h2>
            
            <div class="text-block reveal-text">
                <p>İşletim sisteminin kalbi olan Kernel (Çekirdek), sistemin çalışmaya devam etmesini tehlikeye atacak veya verileri tamamen bozacak kadar kritik ve içinden çıkılamaz bir hatayla karşılaştığında sistemi aniden durdurur.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>En yaygın nedenlerden biri <b>hatalı sürücüler</b> ve <b>kernel modülleridir</b>. Özellikle Linux sistemlerde <b>ekran kartı (örneğin NVIDIA) sürücülerinin <font color="red">güç yönetimi sorunları yaşaması</font> veya <font color="red">sistem çekirdeği güncellendikten sonra eski sürücülerin yeni yapıyla uyumsuz kalması</font></b> doğrudan paniğe yol açar.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Bir diğer hata <b>Bozuk Boot Yapılandırmasıdır</b>. Sistem başlarken <b>kök dosya sistemini (root filesystem) bağlayıp bulamazsa</b> anında panikler. <b>systemd-boot</b> veya <b>GRUB</b> gibi önyükleyicilerde <b><font color="red">yanlış girilen bir kernel parametresi veya harici bir diske kurulum yaparken yapılan yapılandırma hataları</font></b> sistemi bu duruma sokar.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Bir diğeri ise <b>Donanım Arızaları ve Sınırlardır</b>. Donanımlar, özellikle de <b>CPU ve RAM</b>, fabrika çıkışlı hatalar içerebilir veya <b>zamanla arızalanabilir</b>. Bu durum, sistem çekirdeğinin kararlı bir şekilde çalışmasını engelleyen <b>beklenmedik veri hatalarına</b> veya <b>bellek erişim sorunlarına</b> yol açarak doğrudan <b><font color="red">kernel panik</font></b> tetikleyebilir. Ayrıca, <b><font color="red">yetersiz veya uyumsuz RAM modülleri</font></b>, özellikle yüksek bellek kullanan uygulamalar başlatıldığında sistemi çökertir. Ayrıca <b>okuma/yazma hatası veren bir SSD</b> veya <b>sıcaklık/watt limitlerine takılıp termal darbogaza (thermal throttling) giren donanımlar</b> çekirdeğin veri işlemesini engellediği için sistem kilitlenir.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Bir diğer sorun da <b>Dosya Sistemi Bozulmalarıdır</b>. <b><font color="red">Ani güç kesintileri veya donanımsal müdahaleler nedeniyle işletim sisteminin kritik dosyalarının okunamayacak şekilde bozulması</font></b> sonucudur.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Peki çözüm yok mu? Çözüm var ama hepsine yok. Eğer Kernel Panic nedeniniz <b>donanım arızası</b> kaynaklıysa yapabileceğiniz en iyi şey o <b>arızalı parçayı tespit etmek ve değiştirmektir</b>. Eğer <b>Root dosyasında veya Linux içindeki dosyalarda</b> yaptığınız değişiklikler sonucu Kernel Panic'e yakalndıysanız burada varsa <b>fall-back imajına</b> girip <b>değişiklikleri geri alarak</b> kurtulabilirsiniz. Ama bir <b>fall-back imajınız</b> <b><font color="red">yoksa ya da arızalandıysa</font></b> maalesef kurtuluş yok ve <b><font color="red">tek çare formattır.</font></b> Sistem dosyalarında oluşan hata sonucu oluşan Kernel Panic ise <b><font color="red">geri dönüşü tamamen şansınıza bağlıdır.</font></b> Eğer şanslıysanız <b>fall-back imajı</b> ile sisteme girmeyi başarabilirsiniz ama <b><font color="red">yüksek ihtimalle olmayacak ve girseniz bile eksik dosyalar yüzünden %100 kesin düzeltme yapamayacaksınız.</font></b> Bu yüzden <b><font color="red">format</font></b> tek çaredir. </p>
            </div>

            <div class="text-block reveal-text">
                <p><b><font color="red">Not:</font></b> Hatanın kaynağını öğrenmek için <b>dmesg</b> komutunu kullanabilirsiniz. Bu komut size sistemin çekirdek mesajlarını gösterir ve hatanın nerede oluştuğunu anlamanıza yardımcı olur.</p>
            </div>

            <div class="text-block reveal-text">
                <center><a href="<?php echo $geriLink; ?>"><button class="don">Geri Dön</button></a></center>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="kernelpanic.png" alt="Görüntü gelmiyor">

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