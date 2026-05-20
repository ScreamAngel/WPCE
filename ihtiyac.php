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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>İhtiyaç Seçimi</title>
        <style>
        /* Ticker Konteynırı */
.ticker-wrapper {
    margin-left:-10px;
    width: 101%;
    background-color: rgba(0, 0, 0, 0.9); /* Arka plan siyah */
    border-top: 2px solid #ff0000;
    border-bottom: 2px solid #ff0000;
    overflow: hidden; /* Dışarı taşan yazıları gizle */
    position: fixed;
    bottom: 0;
    white-space: nowrap;
    padding: 10px 0;
    z-index: 999;
}

/* Kayan Yazı Stili */
.ticker-text {
    display: inline-block;
    padding-left: 100%; /* Başlangıç pozisyonu */
    animation: ticker-animation 25s linear infinite; /* 25 saniyede bir döngü */
}

.ticker-text span {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    font-weight: bold;
    color: #ff0000; /* İstediğin kırmızı renk */
    padding: 0 50px;
    text-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
}

/* Animasyon Tanımı */
@keyframes ticker-animation {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

/* Mouse ile üzerine gelince durması için */
.ticker-wrapper:hover .ticker-text {
    animation-play-state: paused;
}

/*===================================================================================================================================*/

/* Chat Butonu */
.chat-toggle-btn {
    position: fixed;
    bottom: 60px;
    right: 20px;
    padding: 15px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: 0.3s;
    z-index: 1000;
}

.chat-toggle-btn:hover {
    background-color: #0056b3;
}

/* Chat Penceresi */
.chat-window {
    position: fixed;
    bottom: 120px;
    right: 20px;
    width: 350px;
    height: 450px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 1000;
    transition: opacity 0.3s ease;
}

.chat-window.hidden {
    display: none;
    opacity: 0;
}

/* Üst Kısım (Header) */
.chat-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h4 {
    margin: 0;
    font-size: 16px;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

/* Mesajlaşma Alanı */
.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background-color: #f9f9f9;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Mesaj Balonları */
.message {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}

.bot-message {
    background-color: #e9ecef;
    color: #333;
    align-self: flex-start;
    border-bottom-left-radius: 2px;
}

.user-message {
    background-color: #007bff;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 2px;
}

/* Giriş Alanı */
.chat-input-area {
    display: flex;
    padding: 10px;
    background-color: white;
    border-top: 1px solid #ddd;
}

.chat-input-area input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
}

.chat-input-area button {
    margin-left: 10px;
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.chat-input-area button:hover {
    background-color: #218838;
}

/* Sekme Konteyneri */
.chat-tabs {
    display: flex;
    background-color: #f1f1f1;
    border-bottom: 1px solid #ddd;
}

/* Sekme Butonları */
.tab-btn {
    flex: 1;
    padding: 10px;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: bold;
    color: #555;
    transition: 0.3s;
}

.tab-btn:hover {
    background-color: #e9ecef;
}

/* Aktif Sekme */
.tab-btn.active {
    background-color: white;
    color: #007bff;
    border-bottom: 2px solid #007bff;
}

/* Sekme İçerikleri (Gizleme/Gösterme) */
.tab-content {
    display: none;
    flex-direction: column;
    flex: 1; /* İçeriğin pencereye tam oturması için */
    overflow: hidden;
}

.tab-content.active-tab {
    display: flex;
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
                <button class="sekme-tusu"style="padding: 5px 10px; display: flex; align-items: center; justify-content: center;">
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
    </header><br><br>
    <h2 class="pop">İhtiyacınız Olanı Seçin</h2>
    <br><br><br><br>
    
      <div class="grid-container">
        <a href="sistem.php">
        <div class="resim-karti">
          <img src="Sistem Öneri.jpg" alt="Sistem Öneri">
          <div class="hover-bilgi">
            <h3>Sistem Öneri</h3>
            
          </div>
        </div>
        </a>

        <a href="MaviEkran.php">
        <div class="resim-karti">
          <img src="bluescreen.jpg" alt="Aksiyon">
          <div class="hover-bilgi">
            <h3>Mavi Ekran</h3>

          </div>
          </div>
          </a>

          <a href="PCT.php">
          <div class="resim-karti">
            <img src="PCTamir.jpg" alt="Korku-Gerilim">
            <div class="hover-bilgi">
              <h3>PC Tamir</h3>

            </div>
        </div>
        </a>
        
        </div>
        <br>
        <br>

        <center><a href="kullanici.php"><button class="don">Geri Dön</button></a></center>

        <button id="chat-toggle-btn" class="chat-toggle-btn">💬 Destek</button>

<div id="chat-window" class="chat-window hidden">
    <div class="chat-header">
        <h4>Destek Merkezi</h4>
        <button id="chat-close-btn" class="close-btn">&times;</button>
    </div>
    
    <div class="chat-tabs">
        <button class="tab-btn active" data-target="bot-tab">🤖 Asistan</button>
        <button class="tab-btn" data-target="live-tab">👤 Canlı Destek</button>
    </div>
    
    <div id="bot-tab" class="tab-content active-tab">
        <div id="chat-messages" class="chat-messages">
            <div class="message bot-message">
                Merhaba! Hata kodlarını veya yazılım sorunlarını bana sorabilirsin.
            </div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="user-input" placeholder="Bir soru veya hata kodu yaz..." autocomplete="off">
            <button id="send-btn">Gönder</button>
        </div>
    </div>

    <div id="live-tab" class="tab-content">
        <div id="live-messages" class="chat-messages">
            <div class="message bot-message">
                Hoş geldiniz. Bir yöneticiye bağlanmak veya mesaj bırakmak için aşağıdan yazabilirsiniz.
            </div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="live-input" placeholder="Yöneticiye mesajınızı yazın..." autocomplete="off">
            <button id="live-send-btn" style="background-color: #dc3545;">Gönder</button>
        </div>
    </div>
</div>

<br>
<div class="ticker-wrapper">
    <div class="ticker-text">
        <span>🔴 SON DAKİKA: NVIDIA 591.xx Sürücüsü Yayınlandı!</span>
        <span>|</span>
        <span>🚀 Arch Linux Kernel 6.x Güncellemesi Erişime Açıldı.</span>
        <span>|</span>
        <span>⚠️ KRİTİK: Yeni Windows Güncellemesi BSOD Hatalarına Yol Açıyor!</span>
        <span>|</span>
        <span>🔴 SON DAKİKA: RAM Krizinden Kaynaklı PC Fiyatlarında Büyük Artış Görüldü.</span>
        <span>|</span>
        <span>🧠 BİLGİ: Windows 10 LTSC Sürümü 2030'a Kadar Destek Almaya Devam Edecek</span>
        <span>|</span>
        <span>🧠 BİLGİ: Windows Sisteminizde CMD'yi Yönetici Açıp "sfc /scannow" Komutunu Denediniz Mi?</span>
        <span>|</span>
        <span>🐧 LİNUX: Linux'te Sıkıntısız Oyun Oynamak İsterseniz Arch Linux Kullanabilirsiniz</span>
    </div>
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

document.addEventListener("DOMContentLoaded", function() {
    
    // --- 1. HTML ELEMENTLERİNİ TANIMLAMA ---
    const chatToggleBtn = document.getElementById("chat-toggle-btn");
    const chatWindow = document.getElementById("chat-window");
    const chatCloseBtn = document.getElementById("chat-close-btn");
    
    const botMessages = document.getElementById("chat-messages");
    const botInput = document.getElementById("user-input");
    const botSendBtn = document.getElementById("send-btn");

    const liveMessages = document.getElementById("live-messages");
    const liveInput = document.getElementById("live-input");
    const liveSendBtn = document.getElementById("live-send-btn");

    // --- 2. PENCERE AÇ/KAPAT ---
    chatToggleBtn.addEventListener("click", () => {
        chatWindow.classList.remove("hidden");
        // Pencere açıldığında Canlı Destek sekmesi aktifse mesajları hemen getir
        if (document.getElementById("live-tab").classList.contains("active-tab")) {
            fetchLiveMessages();
        } else {
            botInput.focus();
        }
    });

    chatCloseBtn.addEventListener("click", () => {
        chatWindow.classList.add("hidden");
    });

    // --- 3. SEKME GEÇİŞ MANTIĞI ---
    const tabBtns = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            tabBtns.forEach(b => b.classList.remove("active"));
            tabContents.forEach(c => c.classList.remove("active-tab"));

            btn.classList.add("active");
            const targetId = btn.getAttribute("data-target");
            document.getElementById(targetId).classList.add("active-tab");

            // Kullanıcı Canlı Destek sekmesine geçer geçmez mesajları çek
            if (targetId === "live-tab") {
                fetchLiveMessages();
                liveInput.focus();
            } else {
                botInput.focus();
            }
        });
    });

    // --- 4. ASİSTAN (BOT) MANTIĞI ---
    function sendBotMessage() {
        const text = botInput.value.trim();
        if (text === "") return;

        appendBotMessage(text, "user-message");
        botInput.value = "";

        const loadingId = "loading-" + Date.now();
        appendBotMessage("Araştırılıyor...", "bot-message " + loadingId);

        fetch('bot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(text) 
        })
        .then(response => response.json())
        .then(data => {
            const loadingMsg = document.getElementsByClassName(loadingId)[0];
            if(loadingMsg) loadingMsg.remove();
            appendBotMessage(data.reply, "bot-message");
        })
        .catch(error => {
            appendBotMessage("Bağlantı hatası.", "bot-message");
        });
    }

    botSendBtn.addEventListener("click", sendBotMessage);
    botInput.addEventListener("keypress", (e) => { if (e.key === "Enter") sendBotMessage(); });

    function appendBotMessage(text, className) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        const classes = className.split(" ");
        messageDiv.classList.add(...classes);
        messageDiv.textContent = text;
        botMessages.appendChild(messageDiv);
        botMessages.scrollTop = botMessages.scrollHeight;
    }


    // --- 5. CANLI DESTEK MANTIĞI ---
    
    // Geçmiş mesajları çeken fonksiyon
    function fetchLiveMessages() {
        fetch('mesajlari_getir.php')
        .then(response => response.json())
        .then(data => {
            // Önce ekranı temizle
            liveMessages.innerHTML = `
                <div class="message bot-message">
                    Hoş geldiniz. Bir yöneticiye bağlanmak veya mesaj bırakmak için aşağıdan yazabilirsiniz.
                </div>
            `;

            if (data.hata) {
                appendLiveMessage("⚠️ " + data.hata, "bot-message");
                return;
            }
            if (data.bilgi) {
                return; // Mesaj yoksa sadece karşılama yazısı kalsın
            }

            if (Array.isArray(data)) {
                data.forEach(msg => {
                    const className = msg.kimden === 'user' ? 'user-message' : 'bot-message';
                    appendLiveMessage(msg.metin, className);
                });
            }
        })
        .catch(error => console.error("Hata:", error));
    }

    // Yeni mesaj gönderme fonksiyonu
    function sendLiveMessage() {
        const text = liveInput.value.trim();
        if (text === "") return;
        liveInput.value = ""; // Kutuyu temizle

        fetch('mesaj_gonder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(text)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                appendLiveMessage("Hata: " + data.message, "bot-message");
            } else {
                // Mesaj başarıyla gittiyse ekranı anında güncelle
                fetchLiveMessages(); 
            }
        });
    }

    liveSendBtn.addEventListener("click", sendLiveMessage);
    liveInput.addEventListener("keypress", (e) => { if (e.key === "Enter") sendLiveMessage(); });

    function appendLiveMessage(text, className) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        const classes = className.split(" ");
        messageDiv.classList.add(...classes);
        messageDiv.textContent = text;
        liveMessages.appendChild(messageDiv);
        liveMessages.scrollTop = liveMessages.scrollHeight;
    }

    // --- 6. ARKA PLAN YENİLEME SİSTEMİ (POLLING) ---
    // Her 3 saniyede bir yeni mesaj kontrolü yapar
    setInterval(() => {
        // Chat penceresi GÖRÜNÜR durumdaysa VE Canlı Destek sekmesi AKTİF durumdaysa çalışır
        if (!chatWindow.classList.contains("hidden") && document.getElementById("live-tab").classList.contains("active-tab")) {
            fetchLiveMessages();
        }
    }, 3000);

});

</script>
    
</body>
</html>
