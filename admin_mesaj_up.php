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
    <title>Düzenle</title>

    <style>
        body{
            background-image:url(img/re93.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .mesaj{
            background-color: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(4px); /* Cam efekti */
            opacity: 87%;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            width: 30%;
            padding: 2rem;
            margin-top: 19%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        a{
            text-decoration: none;
        }

        .ilet{
            background: #89b4fa;
            color: #1e1e2e;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 10px auto;
        }

        .ilet:hover{
            transform: scale(1.1);
            transition: 0.25s;
            box-shadow:  0px 6px 20px darkgray;
            color: white;
        }
    </style>
</head>
<body>
    <center><div class="mesaj">
    <h2>Veri Tabanı başarıyla güncellendi.</h2>
    <a href="admin.php"><button class="ilet">Anasayfaya dön</button></a>
    </div></center>
</body>
</html>