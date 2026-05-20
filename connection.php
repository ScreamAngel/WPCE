<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pc";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if(!$conn){
        die("Bağlantı Hatası: " . mysqli_connect_error());
    }
?>
