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
    

    $result = $conn->query("SELECT * FROM users WHERE id = $id");
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
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $tel_no = $_POST['tel_no'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];


    $stmt = $conn->prepare("UPDATE users SET `name` = ?, surname = ?, email = ?, tel_no = ?, `password` = ?, user_type = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $name, $surname, $email, $tel_no, $password, $user_type, $id);
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
        <input type="text" name="name" value="<?php echo $email['name']; ?>" required><br><br>
        
        <label>Soyad:</label><br>
        <input type="text" name="surname" value="<?php echo $email['surname']; ?>" required><br><br>
        
        <label>Mail:</label><br>
        <input type="text" name="email" value="<?php echo $email['email']; ?>" required><br><br>
        
        <label>Telefon Numarası:</label><br>
        <input type="text" name="tel_no" value="<?php echo $email['tel_no']; ?>" required><br><br>

        <label>Şifre:</label><br>
        <input type="text" name="password" value="<?php echo $email['password']; ?>" required><br><br>

        <label>Kullanıcı Tipi:</label><br>
        <input type="text" name="user_type" value="<?php echo $email['user_type']; ?>" required><br><br>
        
        <button type="submit" class="ilet">Güncelle</button>
        

    </form>
    <a href="admin_kul.php"><button class="ilet">Geri dön</button></a>
</div>
</center>

    
</body>
</html>