<?php
include("connection.php");
session_start();

$user_session = isset($_SESSION['user']) ? strtolower($_SESSION['user']) : null;
$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($user_session || $admin_session)) {
    header('Location: giris.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style5.css">
    <title>İletişim</title>
</head>
<body>
<center>
    <div class="mesaj">
    <h2>Mesajınız Başarıyla İletildi!</h2>
    <a href="kullanici.php"><button class="ilet">Anasayfaya dön</button></a>
    </div>
</center>

</body>
</html>