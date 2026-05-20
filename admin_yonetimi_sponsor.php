<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $result = $conn->query("SELECT * FROM sponsorlar WHERE id = $id");
    $sponsor_adi = $result->fetch_assoc();
    

    if (!$sponsor_adi) {
        echo "Bir şey bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz id.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sponsor_adi = $_POST['sponsor_adi'];
    $website = $_POST['website'];
    $created_at = $_POST['created_at'];


    $stmt = $conn->prepare("UPDATE sponsorlar SET sponsor_adi = ?, website = ?, created_at = ? WHERE id = ?");
    $stmt->bind_param("sssi", $sponsor_adi, $website, $created_at, $id);
    $stmt->execute();
    $stmt->close();

    header("location: admin_mesaj_up.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylemesaj.css">
    <title>Düzenle</title>
</head>
<body>
    <center>
        <div class="form">
    <form method="POST">
        <label>Sponsor Adı:</label><br>
        <input type="text" name="sponsor_adi" value="<?php echo $sponsor_adi['sponsor_adi']; ?>" required><br><br>
        
        <label>Soyad:</label><br>
        <input type="text" name="website" value="<?php echo $sponsor_adi['website']; ?>" required><br><br>
        
        <label>Mail:</label><br>
        <input type="text" name="created_at" value="<?php echo $sponsor_adi['created_at']; ?>" required><br><br>
        
        
        <button type="submit" class="ilet">Güncelle</button>
        

    </form>
    <a href="admin_sponsor.php"><button class="ilet">Geri dön</button></a>
    </div>
    </center>

    
</body>
</html>