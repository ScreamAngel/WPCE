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

// Oturum yoksa girişe yönlendir
if (!$email) {
    header('Location: giris.php'); 
    exit;
}

// Veritabanından bu kullanıcının profil resmini çekelim
$query = mysqli_query($conn, "SELECT `name`, surname, profile_image FROM users WHERE email = '$email'");
if ($query) {
    $user_data = mysqli_fetch_assoc($query);
} else {
    die("Veritabanı hatası: " . mysqli_error($conn));
}

// 3. Veri bulundu mu kontrol edelim (Null hatasını engeller)
if ($user_data) {
    $real_name = $user_data['name'] . " " . $user_data['surname'];
    $user_photo = (!empty($user_data['profile_image'])) ? $user_data['profile_image'] : "default-avatar.png";
} else {
    // Eğer oturumdaki email veritabanında yoksa
    $real_name = "Kullanıcı Bulunamadı";
    $user_photo = "default-avatar.png";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="java.js" type="text/Javascript"></script>
    <link rel="stylesheet" href="style8.css">

    <title>Profil</title>
</head>
<body>

<div class="profile-card">
    <div class="image-container">
        <img src="uploads/<?php echo $user_photo; ?>" alt="Profil Fotoğrafı" id="profileDisplay">
    </div>
    
    <h2><?php echo htmlspecialchars(ucfirst($email)); ?></h2>
    <p><?php echo isset($_SESSION['admin']) ? "Sistem Yöneticisi" : "Admin";?></p>

    <form action="uploadad.php" method="POST" enctype="multipart/form-data">
        <label for="fileInput" class="custom-file-upload">
            Fotoğraf Seç
        </label>
        <input type="file" name="profile_pic" id="fileInput" accept="image/*" onchange="previewImage(this)">
        <button type="submit" name="submit" class="save-btn">Değişiklikleri Kaydet</button>
        
    </form>
    <a href="admin.php"><button class="save-btn">Geri Dön</button></a>
</div>
<div id="toast" class="toast">İşlem Başarılı! 🚀</div>



<?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <script>
        // Sayfa yüklendiğinde JS fonksiyonunu çağır
        window.onload = function() {
            showToast("Profil fotoğrafı başarıyla güncellendi!");
        };
    </script>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <script>
        window.onload = function() {
            showToast("Bir hata oluştu, lütfen tekrar deneyin.", "error");
        };
    </script>
<?php endif; ?>
    
</body>
</html>


