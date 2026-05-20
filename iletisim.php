<?php
include("connection.php");
session_start();

$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($user_session || $admin_session)) {
    header('Location: giris.php'); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $mesaj = $_POST['mesaj'];


    $stmt = $conn->prepare("INSERT INTO iletisim (ad, soyad, email, mesaj) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ad, $soyad, $email, $mesaj);
    $stmt->execute();
    $stmt->close();

    header("location: mesaj_il.php");
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
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="oyun-avcısı.jpg">
    <title>İletişim</title>
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
                <a href="kullanici.php"><button class="sekme-tusu">Anasayfa</button></a>
                </div>
                </li>
                
                <li><div class="sekme">
                <a href="iletisim.php"><button class="sekme-tusu">İletişim</button></a>
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
    <div class="iletisim">
    <form method="post"><br>
    <label>Ad: <br><input type="text" name="ad" required></label><br>
    <label>Soyad: <br><input type="text" name="soyad" required></label><br>
    <label>Email: <br><input type="email" name="email" value="<?php echo $_SESSION['user']; ?>" readonly></label><br>
    <label>Mesaj: <br><textarea name="mesaj" cols="26" rows="12"></textarea></label><br>
    <button type="submit" class="ilet">Gönder</buton>
    </form>
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

</script>
</body>
</html>
                