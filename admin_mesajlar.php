<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css">
    <title>Canlı İletişim</title>
    <style>

        .admin-chat-container {
        display: flex;
        width: 90%;
        height: 800px;
        margin: 20px auto;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Sol Menü (Kullanıcılar) */
    .chat-sidebar {
        width: 30%;
        background-color: #f8f9fa;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
    }
    .chat-sidebar h3 {
        padding: 15px;
        margin: 0;
        background-color: #343a40;
        color: white;
        text-align: center;
    }
    .user-list {
        flex: 1;
        overflow-y: auto;
    }
    .user-item {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
        color: black;
    }
    .user-item:hover {
        background-color: #e9ecef;
    }
    .user-item.active-user {
        background-color: #007bff;
        color: white;
    }

    /* Sağ Menü (Sohbet Alanı) */
    .chat-main {
        width: 70%;
        display: flex;
        flex-direction: column;
        /*background-color: #e5ddd5; /* Klasik WhatsApp arka plan rengi */
        background-image: url(PCTamir.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.6);
    }
    .chat-header {
        padding: 16.5px;
        background-color: #343a40;
        color: white;
        font-weight: bold;
    }
    .admin-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: black;
    }
    .admin-input-area {
        display: flex;
        padding: 15px;
        background-color: #f0f0f0;
    }
    .admin-input-area input {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 20px;
        outline: none;
    }
    .admin-input-area button {
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
    }

    /* --- MESAJ BALONCUKLARI TASARIMI --- */

/* 1. Tüm mesajların ortak özellikleri (Kutu yapısı, gölge, köşeler) */
.admin-messages .message {
    padding: 10px 15px;
    border-radius: 15px;
    max-width: 70%; /* Çok uzun mesajlar ekranı tamamen kaplamasın */
    word-wrap: break-word; /* "asdwasdaw" gibi boşluksuz harfleri alt satıra atar, taşmayı önler */
    box-shadow: 0 1px 2px rgba(0,0,0,0.15); /* WhatsApp tarzı hafif alt gölge */
    font-size: 15px;
    line-height: 1.4;
    position: relative;
    margin-bottom: 5px;
}

/* 2. Gelen Mesajlar (Karşı tarafın yazdıkları -> Beyaz ve Sola dayalı) */
.admin-messages .bot-message {
    background-color: #ffffff;
    color: #333333;
    align-self: flex-start; /* Sola yaslar */
    border-top-left-radius: 2px; /* Sol üst köşeyi sivriltip konuşma balonu efekti verir */
}

/* 3. Giden Mesajlar (Senin yazdıkların -> Mavi ve Sağa dayalı) */
.admin-messages .user-message {
    background-color: #007bff; /* Şık bir mavi */
    color: #ffffff;
    align-self: flex-end; /* Sağa yaslar */
    border-top-right-radius: 2px; /* Sağ üst köşeyi sivriltir */
}

    </style>
</head>
<body>

<div class="admin-chat-container">
    <div class="chat-sidebar">
        <h3>Destek Talepleri</h3>
        <div id="user-list" class="user-list">
            </div>
    </div>
    
    <div class="chat-main">
        <div id="chat-header" class="chat-header">Lütfen sol taraftan bir kullanıcı seçin...</div>
        <div id="admin-messages" class="admin-messages">
            </div>
        <div class="admin-input-area">
            <input type="text" id="admin-chat-input" placeholder="Kullanıcıya cevap yazın..." disabled>
            <button id="admin-chat-send" disabled>Gönder</button>
        </div>
    </div>
</div>
<center><a href="admin.php"><button class="ilet2">Geri dön</button></a></center>



    <script>
document.addEventListener("DOMContentLoaded", function() {
    let activeUser = null; // Şu an kiminle konuşuyoruz?

    const userList = document.getElementById("user-list");
    const chatHeader = document.getElementById("chat-header");
    const adminMessages = document.getElementById("admin-messages");
    const adminInput = document.getElementById("admin-chat-input");
    const adminSendBtn = document.getElementById("admin-chat-send");

    // 1. SOL MENÜ: Kullanıcıları Getir
    function fetchUsers() {
        fetch('admin_kullanicilari_getir.php')
        .then(response => response.json())
        .then(data => {
            if (data.hata) return; // Admin değilse işlem yapma
            
            userList.innerHTML = ""; // Listeyi temizle
            data.forEach(user => {
                const div = document.createElement("div");
                div.classList.add("user-item");
                if (user === activeUser) div.classList.add("active-user");
                div.textContent = user;
                
                // Kullanıcıya tıklandığında sohbeti aç
                div.addEventListener("click", () => {
                    activeUser = user;
                    chatHeader.textContent = "Sohbet Edilen: " + user;
                    adminInput.disabled = false;
                    adminSendBtn.disabled = false;
                    fetchMessages(); // O kişinin mesajlarını getir
                    fetchUsers(); // Sol menüyü renklendirmek için yenile
                });
                userList.appendChild(div);
            });
        });
    }

    // 2. SAĞ EKRAN: Seçili Kullanıcının Mesajlarını Getir
    function fetchMessages() {
        if (!activeUser) return;

        fetch('admin_mesajlari_getir.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'kullanici=' + encodeURIComponent(activeUser)
        })
        .then(response => response.json())
        .then(data => {
            adminMessages.innerHTML = ""; // Ekranı temizle
            data.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.classList.add("message");
                // Adminin attığı sağda (mavi), kullanıcının attığı solda (gri) dursun
                if (msg.kimden === 'admin') {
                    msgDiv.classList.add("user-message"); // Sağa yaslar
                } else {
                    msgDiv.classList.add("bot-message"); // Sola yaslar
                }
                msgDiv.textContent = msg.metin;
                adminMessages.appendChild(msgDiv);
            });
            adminMessages.scrollTop = adminMessages.scrollHeight; // En alta kaydır
        });
    }

    // 3. MESAJ GÖNDERME
    function sendMessage() {
        const text = adminInput.value.trim();
        if (text === "" || !activeUser) return;
        adminInput.value = "";

        fetch('admin_mesaj_gonder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'kullanici=' + encodeURIComponent(activeUser) + '&mesaj=' + encodeURIComponent(text)
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                fetchMessages(); // Giden mesajı anında ekranda gör
            }
        });
    }

    adminSendBtn.addEventListener("click", sendMessage);
    adminInput.addEventListener("keypress", (e) => { if (e.key === "Enter") sendMessage(); });

    // 4. OTOMATİK YENİLEME (Polling)
    fetchUsers(); // Sayfa açılınca kullanıcıları getir
    setInterval(() => {
        fetchUsers(); // Yeni mesaj atan var mı diye sol listeyi güncelle
        if (activeUser) fetchMessages(); // Seçili kişi cevap yazdıysa sağ ekranı güncelle
    }, 3000);
});
</script>

    
</body>
</html>