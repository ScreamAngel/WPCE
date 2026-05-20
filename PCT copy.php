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
                <li><a href="#bölüm1">Bölüm 1</a></li>
                <li><a href="#bölüm2">Bölüm 2</a></li>
                <li><a href="#bölüm3">Bölüm 3</a></li>
            </ul>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                <p>Öncelikle Parçaları öğrenelim. Bilgisayarlarda temel parçalar: CPU (Central Processing Unit) diğer adıyla İşlemci, GPU (Graphics Processing Unit) diğer adıyla ekran kartı, RAM (Random Access Memory), PSU (Power Supply Unit) diğer adıyla güç kaynağı, Anakart, ve son olarak Depolama Birimi (SSD, HDD, M2). </p>
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


<section id="bölüm1" class="story-container">
    <div class="story-layout">

        <div class="story-text-column2">
            <h2 class="reveal-text">Bölüm 1: Parçaların İsimleri ve Türleri</h2>

            <div class="text-block reveal-text">
                <p>Burada parçaları tanıyacağız. Parçalar: CPU, GPU, RAM, PSU, Anakart, Depolama Birimi (SSD, HDD, M2).</p>
            </div>

            <div class="text-block reveal-text">
                <p>Şimdi bu parçaların türlerini inceleyeceğiz.</p>
            </div>
            </div>
    
</section>

<section id="CPU" class="story-container">
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
                    <img src="cpu.jpg" alt="CPU">

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
                    <img src="gpu.jpg" alt="GPU">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">GPU (Graphics Processing Unit), Ekran Kartı</h2>
            
            <div class="text-block reveal-text">
                <p>GPU (Graphics Processing Unit), Türkçesiyle Grafik İşlemci Birimi, temelde görüntüleri, videoları ve 2D/3D grafikleri işlemek ve ekrana yansıtmak üzere özel olarak tasarlanmış bir donanım bileşenidir. Bilgisayarlarda, akıllı telefonlarda ve oyun konsollarında bulunur.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Başlangıçta sadece oyunlardaki ve programlardaki grafikleri ekrana çizmek için geliştirilmiş olsalar da, günümüzde mimari yapıları gereği çok daha karmaşık görevleri yerine getirmektedirler.</p>
            </div>

            <div class="text-block reveal-text">
                <p>GPU, CPU’dan farklı olarak verileri sırayla işlemek yerine, paralel işlemcilerden oluşan çekirdek yapılarını kullanarak aynı anda binlerce işlemi gerçekleştirebilir. Bu özellik, özellikle yüksek çözünürlüklü oyunlarda karmaşık sahnelerin oluşturulması, video düzenleme, 3D modelleme ve yapay zeka algoritmalarının eğitimi gibi hesaplama yoğun görevlerde kritik öneme sahiptir.</p>
            </div>
        </div>



    </div>
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">RAM (Random Access Memory), Rastgele Erişim Belleği</h2>
            
            <div class="text-block reveal-text">
                <p>RAM (Random Access Memory - Rastgele Erişimli Bellek), bilgisayarın veya mobil cihazların aktif olarak kullandığı verileri geçici ve çok hızlı bir şekilde depoladığı kritik bir donanım bileşenidir. İşletim sisteminin çekirdek süreçleri, arka planda çalışan servisler ve o an açık olan uygulamaların tümü doğrudan RAM üzerinde tutulur.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Verilerin kalıcı olarak saklandığı depolama birimlerinin (SSD veya HDD) aksine, RAM uçucu (volatile) bir bellektir. Sisteme giden güç kesildiği anda üzerindeki tüm elektron yükleri sıfırlanır ve veriler silinir.</p>
            </div>

            <div class="text-block reveal-text">
                <p>İşlemci (CPU), verileri işlemek için doğrudan depolama sürücüsüne başvurmaz çünkü en hızlı NVMe SSD'ler bile işlemcinin hızına yetişemez. Bunun yerine, ihtiyaç duyulan veriler önce diskten RAM'e kopyalanır. İşlemci bu verilere RAM üzerinden nanosaniyeler (ns) içinde erişir. RAM'i büyük bir "çalışma masası", SSD'yi ise "dosya dolabı" olarak düşünebilirsiniz. Masa ne kadar genişse, aynı anda o kadar fazla dosya ve proje (uygulama, oyun veya tarayıcı sekmesi) sistemi yavaşlatmadan açık tutulabilir.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Sistem performansı açısından RAM miktarı kritik bir faktördür. Yetersiz RAM olduğunda, işletim sistemi sürekli olarak SSD'den veri çekmek ve yazmak zorunda kalır (bu duruma "swapping" veya "paging" denir). Bu süreç, fiziksel diskin I/O hız limitlerine takıldığı için sistemde ciddi yavaşlamalara, donmalara ve uygulamaların tepki süresinin uzamasına neden olur. Bu yüzden bilgisayar alırken veya yükseltirken RAM miktarının ihtiyaçlarınıza uygun olduğundan emin olmak performansı doğrudan etkiler.</p>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="ram2.jpg" alt="RAM">

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
                    <img src="psu.jpg" alt="PSU">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">PSU (Power Supply Unit), Güç Kaynağı</h2>
            
            <div class="text-block reveal-text">
                <p>PSU (Power Supply Unit), Türkçesiyle Güç Kaynağı Birimi, bilgisayarın en hayati donanımlarından biridir. Temel görevi, evimizdeki prizden gelen yüksek voltajlı dalgalı akımı (AC), bilgisayarın içindeki hassas donanımların kullanabileceği düşük voltajlı doğru akıma (DC) dönüştürmek ve bu enerjiyi bileşenlere kararlı bir şekilde dağıtmaktır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Eğer işlemciyi (CPU) bilgisayarın beyni, ekran kartını (GPU) görsel kas gücü olarak tanımlarsak; PSU şüphesiz bilgisayarın kalbidir. Gerekli olan elektriği (kanı) sisteme temiz ve stabil bir şekilde pompalayamazsa, sistemin geri kalanı ne kadar üst düzey olursa olsun düzgün çalışamaz veya zarar görür.</p>
            </div>

            <div class="text-block reveal-text">
                <p>PSU’lar, bilgisayar bileşenlerinin gereksinim duyduğu voltaj seviyelerine (genellikle +12V, +5V ve +3.3V) ve güce göre sınıflandırılır. Kullanıcının sisteminde bulunan CPU, GPU ve disk sürücüleri gibi bileşenlerin toplam güç tüketimi hesaplanır ve buna güvenli bir pay eklenerek uygun kapasitede bir PSU seçilir. Yetersiz bir PSU, sistem kararsızlıklarına ve ani kapanmalara yol açarken, aşırı yüksek kapasiteli bir PSU gereksiz maliyet anlamına gelir.</p>
            </div>
        </div>



    </div>
</section>


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


<section id="story" class="story-container">
    <div class="story-layout">
        
                <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="ssd.jpg" alt="Depolama Birimleri">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">Depolama birimi (SSD, HDD, M2), Storage Devices</h2>
            
            <div class="text-block reveal-text">
                <p>Depolama birimi, bilgisayarın çalışması için gerekli olan işletim sistemini, uygulamaları ve kullanıcı verilerini kalıcı olarak saklayan donanımdır. Hard Disk Drive (HDD), Solid State Drive (SSD) ve M.2 SSD olmak üzere başlıca depolama teknolojileri bulunur. Her teknolojinin kendine özgü hız, kapasite ve fiyat avantajları vardır. Bu nedenle, bilgisayar toplarken depolama birimi seçimi, kullanım amacına ve bütçeye göre dikkatlice yapılmalıdır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>RAM'i bilgisayarın "çalışma masası" olarak tanımlamıştık. Bu analojiye göre SSD, masanın hemen yanındaki modern ve ultra hızlı dosya dolabıdır. İşlemci (CPU) bir veriye ihtiyaç duyduğunda (örneğin bir oyunu açmak istediğinizde), bu veri önce SSD'den (dolaptan) alınıp RAM'e (masaya) kopyalanır. SSD ne kadar hızlıysa; sistemin boot süresi (açılışı), oyunların yükleme (loading) ekranları ve büyük dosyaların transferi o kadar kısa sürer.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Çalışma Mantığı ve Geleneksel Disklerden (HDD) Farkı: <br><br> Geleneksel Sabit Disklerde (HDD) veriler, dönen manyetik plakalar üzerine mekanik bir okuma/yazma kafası ile işlenir. Plakanın dönmesini ve kafanın veriyi bulmasını beklemek, sistemde ciddi bir gecikmeye (latency) sebep olur.</p>
            </div>

            <div class="text-block reveal-text">
                <p>SSD'lerde ise adından da anlaşılacağı gibi hiçbir hareketli/mekanik parça yoktur. Veriler, devasa bir USB flash bellek gibi mikroskobik NAND Flash bellek yongalarında elektrik yükleri halinde depolanır. Fiziksel bir okuma süreci olmadığı için verilere milisaniyeler içinde doğrudan erişilir. Ayrıca hareketli parça barındırmadıkları için darbelere, düşmelere ve sarsıntılara karşı HDD'lere göre çok daha dayanıklı ve tamamen sessizdirler.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Arayüz ve Hız Sınırları (SATA vs. NVMe): <br><br>SATA SSD'ler:<br><br> Geleneksel 2.5 inç boyutundaki kutu tasarımlı SSD'lerdir. Anakarta SATA kablosuyla bağlanırlar ve bu kablonun bant genişliği sınırı nedeniyle maksimum 500-600 MB/s okuma/yazma hızlarına ulaşabilirler. <br><br> NVMe (M.2) SSD'ler:<br><br> Günümüzün standardı olan bu sürücüler, sakız kutusu büyüklüğündedir ve anakart üzerindeki PCIe (Genişleme) yuvalarına doğrudan takılırlar. İşlemciyle aradaki "SATA kontrolcüsü" aracısını ortadan kaldırıp doğrudan PCIe yollarını kullandıkları için hızları saniyede 7000 MB/s (PCIe 4.0) veya 14000 MB/s (PCIe 5.0) gibi muazzam seviyelere çıkabilir.</p>
            </div>
        </div>



    </div>
</section>


<section id="bölüm2" class="story-container">
    <div class="story-layout">

        <div class="story-text-column2">
            <h2 class="reveal-text">Bölüm 2: Değişim</h2>

            <div class="text-block reveal-text">
                <p>Burada parçaların değişimini anlatacağız.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Şimdi bu parçaları nasıl değiştireceğiz onu inceleyeceğiz.</p>
            </div>
            </div>
    
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">CPU (Central Processing Unit), İşlemci</h2>
            
            <div class="text-block reveal-text">
                <p>Öncelikle işlemci değişimi yeni nesil Laptop'larda maalesef yoktur. Laptop'larda İşlemci genelde anakarta lehimlidir. Anakartta lehimli olan işlemciyi değiştirmek için özel makinalar gereklidir. Bu nedenleLaptoplarda işlemci değişimi neredeyse imkansızdır. Ancak bazı Laptop'larda işlemci soketli olabilir. Bu durumda işlemci değişimi yapılabilir. Kasalarda ise işlemci değişimi gayet basittir.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>İlk olarak kasamızda bulunan güç kaynağını çıkarıyoruz. Ardından işlemci fanını çıkarıyoruz. Fanın altında işlemciyi tutan bir mekanizma göreceksiniz. Bu mekanizmayı gevşetiyoruz. Ardından işlemciyi yavaşça çıkarıyoruz. Yeni işlemciyi takarken dikkat ediyoruz. İşlemcinin üzerinde ok işareti vardır. Bu işaret anakart üzerindeki ok işareti ile aynı yönde olmalıdır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>İşlemciyi değiştirdikten sonra işlemci fanını geri takıyoruz. Fanın altında işlemciyi tutan mekanizmayı sıkıştırıyoruz. Ardından güç kaynağını geri takıyoruz. Artık işlemci değişimimiz tamamlanmıştır.</p>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="cpu.gif" alt="CPU">

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
                    <img src="gpu.gif" alt="GPU">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">GPU (Graphics Processing Unit), Ekran Kartı</h2>
            
            <div class="text-block reveal-text">
                <p>Öncelikle GPU laptop'larda anakarta lehimlidir, bu nedenle değiştirilemez. Ancak bazı laptop'larda GPU soketli olabilir. Bu durumda GPU değişimi yapılabilir. Kasalarda ise GPU değişimi gayet basittir.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Kasalarda GPU değişimi için öncelikle güç kaynağını çıkarıyoruz. Ardından GPU'yu anakarta bağlayan vidaları çıkarıyoruz. Sonrasında GPU'yu yavaşça çıkarıyoruz. Yeni GPU'yu takarken dikkat ediyoruz. GPU'nun yuvaya tam oturduğundan emin oluyoruz.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Sonrasında GPU'yu anakarta bağlayan vidaları geri takıyoruz. Ardından güç kaynağını geri takıyoruz. Artık GPU değişimimiz tamamlanmıştır.</p>
            </div>

        </div>



    </div>
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">RAM (Random Access Memory), Bellek</h2>
            
            <div class="text-block reveal-text">
                <p>Öncelikle Laptop ve Kasa RAM'leri değiştirme mantığı benzerdir ama biraz farkları vardır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>İlk olarak Laptop RAM'ini değiştirmek için laptop'umuzun arkasını açıyoruz. Genelde RAM'ler bir kapağın altında bulunur. Kapağı açınca iki adet RAM yuvası göreceksiniz. Bu yuvalardaki RAM'leri değiştirmek için RAM'lerin yanlarındaki mandallara hafifçe bastırıyoruz. RAM yuvasından kurtulunca RAM'i yavaşça çıkarıyoruz. RAM Laptop'larda 30 ile 45 derece açıyla takılmalıdır. Kaslarda ise 90 derece açıyla takılmalıdır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Laptop RAM'ini takarken aynı şekilde 30 ile 45 derece açıyla takıyoruz. Ardından RAM'i yavaşça aşağı doğru bastırıyoruz. RAM yuvaya tam oturunca RAM'in yanlarındaki mandallar kapanacaktır. Kasalarda ise RAM'i yavaşça aşağı doğru bastırıyoruz. RAM yuvaya tam oturunca RAM'in yanlarındaki mandallar kapanacaktır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Ram de voltaj 
                    farklılıkları vardır. Mesela DDR3, DDR4, DDR5 gibi. Bu ramler birbirinin yerine takılamaz. 
                    Bunlara dikkat ediyoruz.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Laptop için gif olmadığı için detaylı bir video linki bırakıyorum:</p>
            </div>

            <div class="text-block reveal-text">
                <p><a href="https://www.youtube.com/watch?v=zt7sSPhN7UA">RAM Montajı için video linki</a></p>
            </div>

        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="ram.gif" alt="RAM">

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
                    <img src="psu.gif" alt="PSU">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">PSU (Power Supply Unit), Güç Kaynağı</h2>
            
            <div class="text-block reveal-text">
                <p>Öncelikle PSU laptop'larda şarj aletidir. Bu yüzden belirli watt değerlerine sahip şarj aletleri kullanılır. Kasalarda ise PSU değişimi biraz zordur ama bir yerden sonra kolaylaşır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Kasalarda PSU değişimi için öncelikle güç kaynağını prizden çekiyoruz. Ardından PSU'nun kasaya bağlı vidalarını söküyoruz. Sonra PSU'yu tamamen sökmeden önce PSU'nun anakarta takılı tüm kablolarını söküyoruz. Tüm kablolar söküldükten sonra PSU'yu sökebilirsiniz.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Yeni PSU'yu takarken yeni PSU'nun anakarta takılı tüm kablolarını takıyoruz. Ardından PSU'yu kasaya bağlayan vidaları geri takıyoruz. Sonrasında PSU'yu prize takıyoruz. PSU değişimi bu kadar.</p>
            </div>

            <div class="text-block reveal-text">
                <p><a href="https://www.youtube.com/watch?v=Pc4W5TdrpXM">PSU Montajı için video linki</a></p>
            </div>

        </div>



    </div>
</section>


<section id="bölüm3" class="story-container">
    <div class="story-layout">

        <div class="story-text-column2">
            <h2 class="reveal-text">Bölüm 3: Hatalar ve Çözümleri</h2>

            <div class="text-block reveal-text">
                <p>Her parçanın kendine göre sorunları vardır. Bunları inceleyeceğiz.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Şimdi bu hataları ve çözümlerini inceleyeceğiz.</p>
            </div>
            </div>
    
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">Görüntü Gelmiyor</h2>
            
            <div class="text-block reveal-text">
                <p>Böyle bir şeyle karşılaştığınızda öncelikle yapmanız gereken şey bu görüntü gelmemesi öncesinde ne yaptığınız hatırlamaktır. Eğer bir sebep yokke nbaşladığıysa öncelikle monitörü ve HDMI girişlerini kontrol edin. Eğer Laptop kullanıyosanız önce paneli kontrol edin. Eğer monitör arızalı değil ve HDMI girişlerinde bir problem yoksa o zmaan kasaya inmeliyiz.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Kasadaki RAM'leri kontrol edeceğiz. RAM'leri yuvadan çıkarıyoruz ve sarı renkli iletken kısımlarda herhangi bir oksitlenme var mı diye kontrol ediyoruz. Eğer varsa bir silgi aracığılıyla sadece sarı kısımları silgi ile silin. Ama sakın kapasitörlere temas etmeyin. Kapasitörler oldukça hassastır ve silgi darbesiyle lehimlerinde çatlama olabilir. Temizledikten sonra yuvada toz birikintisi varsa temizliyoruz. RAM'i takmadan öncee üstünde herhangi bir silgi tozu klamadığından iyice emin olduktan sonra RAM'leri geri takıyoruz. Eğer görüntü gelmemeye devam ediyorsa burada iki seçenek var. Eğer bu durumdan önce yeni bir RAM taktıysanız RAM uyumsuzluğu olabilir. Eğer ortada bir RAM uyumsuzluğu varsa eski RAM'leri takın. Eğer herhangi bir RAM eklemesi yapmadıysanız burada sorun GPU, CPU ya da PSU'dadır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Önce GPU'dan başlayalım. GPU'yu çıkarıyoruz ve sarı renkli iletken kısımlarda herhangi bir oksitlenme var mı diye kontrol ediyoruz. Eğer varsa bir silgi aracığılıyla sadece sarı kısımları silgi ile silin. Ama sakın kapasitörlere temas etmeyin. Kapasitörler oldukça hassastır ve silgi darbesiyle lehimlerinde çatlama olabilir. Temizledikten sonra yuvada toz birikintisi varsa temizliyoruz. GPU'yu takmadan öncee üstünde herhangi bir silgi tozu klamadığından iyice emin olduktan sonra GPU'yu geri takıyoruz. Eğer görüntü gelmemeye devam ediyorsa burada GPU'nun kendisinde sorun olabilir. Burada eğer mümkünse başka bir GPU ile test ediniz. Eğer başka GPU'nuz yoksa test amaçlı CPU'nun kendi grafik birimini kullanarak görüntü almayı deneyiniz. Eğer CPU'nuzda görüntü birimi yoksa GPU'da sorun olup olmadığını %100 garantileyemeyiz. Eğer CPU grafik biriminiz olmasına rağmen hala görüntü gelmiyorsa sorun ya parçalardan birindeki bir arıza sonucu sistemin kilitlenmesi ya da CPU veya PSU'dadır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Burada yapmanız gereken şey PSU test cihazınız varsa PSU test cihazı ile PSU'yu test etmektir. Eğer PSU test cihazınız yoksa PSU'yu çıkarıp başka bir sistemde test etmektir. Eğer başka bir sistemde test etme imkanınız yoksa maalesef ki PSU'yu değiştirip test etmektir. Ama eğer PSU'yu değiştiremezseniz %100 garantileyemeyiz. Eğer farklı bir PSU denemenize rağmen sorun devam ediyorsa sorun CPU'da olabilir.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Eğer sorun CPU'da ise burada yapmanız gereken şey CPU'yu çıkarıp yerine geçici bir CPU takarak test etmektir. Eğer başka CPU takma şansınız yoksa %100 garanti veremeyiz. Eğer farklı CPU takmanıza rağmen sorun devam ediyorsa sorun anakartta olabilir. O zaman anakartın değişmesi gerekmektedir. Ama unutmayın ki eğer diğer parçalara tam teşhis koymadıysanız bu yola hemen girmeyin.</p>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="siyah.png" alt="Görüntü gelmiyor">

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
                    <img src="bluescreen.jpg" alt="Mavi Ekran">

                </div>
            </div>
        </div>

        <div class="story-text-column">
            <h2 class="reveal-text">BSOD (Blue Screen Of Death), Mavi Ekran Hataları</h2>
            
            <div class="text-block reveal-text">
                <p>Öncelikle bu tarz mavi ekran hataları alıyorsanız sitemizdeki Mavi Ekran Hataları bölümüne bakabilirsiniz. Orada bu hataların çözümlerini detaylı bir şekilde bulabilirsiniz. Eğer hatayı orada bulamazsanız yapay zeka asistanımıza sorabilir ya da bize ulaşarak siteyi güncellememize yardımcı olabilirsiniz.</p>
            </div>
            
        </div>

    </div>
</section>


<section id="story" class="story-container">
    <div class="story-layout">
        
        <div class="story-text-column">
            <h2 class="reveal-text">CPU veya GPU ısınma sorunu</h2>
            
            <div class="text-block reveal-text">
                <p>Böyle bir şeyle karşılaştığınızda öncelikle yapmanız gereken şey işlemci ve ekran kartı üzerindeki termal macunu kontrol etmektir. Eğer termal macun kurumuşsa ya da yoksa işlemci ve ekran kartı üzerindeki termal macunu temizleyip yerine yenisini sürün. Eğer sorun devam ediyorsa sorun işlemci, ekran kartı ya da anakarttadır.</p>
            </div>
            
            <div class="text-block reveal-text">
                <p>Kasadaki fanları kontrol edeceğiz. Fanlar düzgün dönüyor mu? Eğer dönmüyorsa fanı temizleyin ya da değiştirin. Fanlar düzgün dönüyorsa sorun işlemci, ekran kartı ya da anakarttadır.</p>
            </div>

            <div class="text-block reveal-text">
                <p>Eğer sıv ısoğutma veya kule tipi soğutma takıldıktan sonra sorun başladıysa soğutucuyu çıkarıp termal macunu kontrol edin. Ardından soğutucuğu bloktaki jelatini çıkardığınızdan emin olun. Eğer sorun devam ediyorsa sorun işlemci, ekran kartı ya da anakarttadır.</p>
            </div>
        </div>

        <div class="story-image-column">
            <div class="sticky-image-wrapper">
                <div class="image-frame">
                    <img src="ısı.jpg" alt="Isınma Sorunu">

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