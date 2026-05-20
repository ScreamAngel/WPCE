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
    

    $result = $conn->query("SELECT * FROM iletisim WHERE id = $id");
    $email = $result->fetch_assoc();
    

    if (!$email) {
        echo "Bir şey bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz id.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $mesaj = $_POST['mesaj'];
    $created_at = $_POST['created_at'];


    $stmt = $conn->prepare("UPDATE iletisim SET ad = ?, soyad = ?, email = ?, mesaj = ?, created_at = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $ad, $soyad, $email, $mesaj, $created_at, $id);
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

        <label>Ad:</label><br>
        <input type="text" name="ad" value="<?php echo $email['ad']; ?>" required><br><br>
        
        <label>Soyad:</label><br>
        <input type="text" name="soyad" value="<?php echo $email['soyad']; ?>" required><br><br>
        
        <label>Mail:</label><br>
        <input type="text" name="email" value="<?php echo $email['email']; ?>" required><br><br>
        
        <label>Mesaj:</label><br>
        <input type="text" name="mesaj" value="<?php echo $email['mesaj']; ?>" required><br><br>

        <label>Mesaj Atılma Tarihi:</label><br>
        <input type="text" name="created_at" value="<?php echo $email['created_at']; ?>" required><br><br>
        
        <button type="submit" class="ilet">Güncelle</button>
        

    </form>
    <a href="admin_mesaj.php"><button class="ilet">Geri dön</button></a>
    </div>
    </center>

    
</body>
</html>