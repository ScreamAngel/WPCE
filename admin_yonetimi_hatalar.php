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
    

    $result = $conn->query("SELECT * FROM error_codes WHERE id = $id");
    $error_code = $result->fetch_assoc();
    

    if (!$error_code) {
        echo "Bir şey bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz id.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_code = $_POST['error_code'];
    $hata_neden = $_POST['hata_neden'];
    $cozum = $_POST['cozum'];


    $stmt = $conn->prepare("UPDATE error_codes SET error_code = ?, hata_neden = ?, cozum = ? WHERE id = ?");
    $stmt->bind_param("sssi", $error_code, $hata_neden, $cozum, $id);
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

        <label>Hata Kodu:</label><br>
        <input type="text" name="error_code" value="<?php echo $error_code['error_code']; ?>" required><br><br>
        
        <label>Hata Nedeni:</label><br>
        <input type="text" name="hata_neden" value="<?php echo $error_code['hata_neden']; ?>" required><br><br>
        
        <label>Çözüm:</label><br>
        <input type="text" name="cozum" value="<?php echo $error_code['cozum']; ?>" required><br><br>
        
        
        <button type="submit" class="ilet">Güncelle</button>
        

    </form>
    <a href="admin_hatakod.php"><button class="ilet">Geri dön</button></a>
    </div>
    </center>

    
</body>
</html>