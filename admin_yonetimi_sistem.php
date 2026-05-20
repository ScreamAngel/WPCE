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
    

    $result = $conn->query("SELECT * FROM sistemler WHERE id = $id");
    $sistem_adi = $result->fetch_assoc();
    

    if (!$sistem_adi) {
        echo "Bir şey bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz id.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sistem_adi = $_POST['sistem_adi'];
    $cpu = $_POST['cpu'];
    $gpu = $_POST['gpu'];
    $ram = $_POST['ram'];
    $fiyat = $_POST['fiyat'];
    $link = $_POST['link'];


    $stmt = $conn->prepare("UPDATE sistemler SET sistem_adi = ?, cpu = ?, gpu = ?, ram = ?, fiyat = ?, link = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $sistem_adi, $cpu, $gpu, $ram, $fiyat, $link, $id);
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

        <label>Sistem Adı:</label><br>
        <input type="text" name="sistem_adi" value="<?php echo $sistem_adi['sistem_adi']; ?>" required><br><br>
        
        <label>CPU:</label><br>
        <input type="text" name="cpu" value="<?php echo $sistem_adi['cpu']; ?>" required><br><br>
        
        <label>GPU:</label><br>
        <input type="text" name="gpu" value="<?php echo $sistem_adi['gpu']; ?>" required><br><br>

        <label>Ram:</label><br>
        <input type="text" name="ram" value="<?php echo $sistem_adi['ram']; ?>" required><br><br>

        <label>Fiyat:</label><br>
        <input type="text" name="fiyat" value="<?php echo $sistem_adi['fiyat']; ?>" required><br><br>

        <label>Link:</label><br>
        <input type="text" name="link" value="<?php echo $sistem_adi['link']; ?>" required><br><br>
        
        
        <button type="submit" class="ilet">Güncelle</button>
        

    </form>
    <a href="admin_sistem.php"><button class="ilet">Geri dön</button></a>
    </div>
    </center>

    
</body>
</html>