<?php
$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if(!$conn){
        die("Bağlantı Hatası: " . mysqli_connect_error());
    }
?>
