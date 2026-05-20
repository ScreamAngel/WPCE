<?php
include("connection.php");
session_start();

// Hataları çek
$error_query = mysqli_query($conn, "SELECT * FROM error_codes");
$errors_from_db = [];
while($row = mysqli_fetch_assoc($error_query)) {
    $errors_from_db[] = $row;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="giphy.gif">
    <title>Mavi Ekran Sorunu</title>
    <style>
        /* Genel Sayfa Düzeni */
        body { background-image: url(img/Win111.jpg); background-size: cover; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;  }

        .mavi{
            padding: 40px; display: flex; flex-direction: column; align-items: center;
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

nav{
  display: flex;
  justify-content: space-between;
  height: 100%;
  align-items: center;
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

header{
  height: 100%;
  border-bottom: 2px solid #ffffff06;
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

.secim{
  background-color: white;
  text-align: center;
  box-shadow: 0px 6px 20px darkgray;
  border-radius: 10px;
  padding: 1.5rem;
  width: 50rem;
  justify-content: center;
  margin-left: 28%;
  margin-top: 270px;
}

.button{
  padding: 10px;
  border-radius: 10px;
  background-color: black;
  color: white;
}

.button:hover{
  background-color: gray;
  color: white;
  transition: 0.25s;
  transform: scale(1.05);
  cursor: pointer;
}



        /* Arama Kutusu Tasarımı */
        .wrapper { position: relative; width: 100%; max-width: 600px; }
        
        .search-input {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box; /* Padding dahil genişlik hesaplaması için */
        }

        .search-input:focus { border-color: #0078D7; }

        /* Otomatik Tamamlama Listesi (Öneriler) */
        .suggestions-box {
            position: absolute;
            top: 100%; /* Inputun tam altına yapış */
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: 300px; /* Çok uzarsa scroll çıksın */
            overflow-y: auto;
            z-index: 1000;
            display: none; /* Başlangıçta gizli */
        }

        .suggestions-box li {
            list-style: none;
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .suggestions-box li:hover { background-color: #f0f8ff; color: #0078D7; }
        .suggestions-box li strong { color: #d32f2f; } /* Kod kısmı kırmızı olsun */

        /* Sonuç Gösterim Alanı */
        #result-area {
            margin-top: 30px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
            display: none;
            border-left: 5px solid #0078D7;
        }

        .result-title { font-size: 22px; color: #333; margin-bottom: 10px; }
        .label { font-weight: bold; color: #555; }

        .don{
            padding: 10px;
            border-radius: 10px;
            background-color: black;
            color: white;
            width: 250px;
            justify-content: center;
            align-items: center;
            margin-left: 43%;
        }

        .don:hover{
             background-color: dodgerblue;
            color: white;
            transition: 0.25s;
            transform: scale(1.05);
            cursor: pointer;
        }
    nav {
  display: flex;
  justify-content: space-between;
  height: 100%;
  align-items: center;
  margin-right: 25px;
}

.sekme-icerik {
  display: none;
  position: absolute;
  background-color: white;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  width: 130px;
  z-index: 1;
  transition: 0.3s;
  border-radius: 10px;
}
</style>
</head>
<body>
    <header>
        <nav>
                    <div id="logo-container" style="cursor:pointer;">
       <img id="site-logo" src="oyun-avcısı.jpg" width="30%" height="30%" title="Oyun-Avcısı.com" alt="Oyun-Avcısı.com">
</div>
      
            <div class="menu">
            <ul>
                <li><div class="sekme">
                <a href="kullaniciM.php"><button class="sekme-tusu">Anasayfa</button></a>
                </div>
                </li>



                <li>
                <div class="sekme">
                <button class="sekme-tusu">
                <i class="fa-solid fa-circle-user"></i>&nbsp;Misafir
                </button>
                <div class="sekme-icerik">
                        <a href="cikis.php">Çıkış Yap</a>
                </div>
                </div>
                </li>
            </div>
        </nav>
    </header>
    <br><br><br><br><br><br><br><br><br><br>
        <div class="mavi">
    <h1 style="color:#ffffff;">BSOD Hata Çözücü</h1>
    
    <div class="wrapper">
        <input type="text" class="search-input" id="searchInput" placeholder="Hata kodu veya ismi yazın (Örn: 0x00.. veya MEMORY...)">
        <ul class="suggestions-box" id="suggestions"></ul>
    </div>

    <div id="result-area">
        <h2 id="res-title" class="result-title"></h2>
        <p><span class="label">Neden:</span> <span id="res-reason"></span></p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
        <p><span class="label">Çözüm:</span> <span id="res-fix"></span></p>
    </div>
    </div>


    <br>
     <a href="ihtiyacM.php"><button class="don">Geri Dön</button></a>

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

//===============================================================================================

(function() {
    const errorData = <?php echo json_encode($errors_from_db); ?>;
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestions');
    const resultArea = document.getElementById('result-area');

    // --- ARAMA VE ÖNERİ MANTIĞI ---
    searchInput.addEventListener('input', (e) => {
        const input = e.target.value.toLowerCase().trim();
        suggestionsBox.innerHTML = ''; 
        
        if (input.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        const filteredErrors = errorData.filter(error => 
            error.error_code.toLowerCase().includes(input)
        );

        if (filteredErrors.length > 0) {
            filteredErrors.forEach(error => {
                const li = document.createElement('li');
                li.innerHTML = `<strong>${error.error_code}</strong>`;
                li.onclick = () => showResult(error);
                suggestionsBox.appendChild(li);
            });
            suggestionsBox.style.display = 'block';
        } else {
            suggestionsBox.style.display = 'none';
        }
    });

    // --- SONUCU GÖSTERME VE KAYDETME ---
    function showResult(error) {
        // Arama kutusunu güncelle
        searchInput.value = error.error_code;
        suggestionsBox.style.display = 'none';

        // Ekrana yazdır (tablo sütun isimleri)
        document.getElementById('res-title').innerText = "Hata Kodu: " + error.error_code;
        document.getElementById('res-reason').innerText = error.hata_neden;
        document.getElementById('res-fix').innerText = error.cozum;
        
        resultArea.style.display = 'block';

    }

    // Boşluğa tıklayınca kapat
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });
})();



    </script>
</body>
</html>