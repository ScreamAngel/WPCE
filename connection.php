<?php
    $servername = "localhost:3306";
    $username = "root";
    $password = "emir1234%";
    $dbname = "pc";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if(!$conn){
        die("Bağlantı Hatası: " . mysqli_connect_error());
    }
?>