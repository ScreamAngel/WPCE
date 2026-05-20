<?php
// Hataları ekrana basalım ki sorunu görelim
ini_set('display_errors', 1);
error_reporting(E_ALL);

$apiKey = "AIzaSyC-UCFFKulyWyIbMX9IM4lM9m6QQGhx5r8"; 
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// SSL hatasını atlamak için
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo "Bağlantı Hatası: " . curl_error($ch);
} else {
    // Gelen JSON verisini okunaklı bir şekilde ekrana basıyoruz
    echo "<pre>";
    print_r(json_decode($response, true));
    echo "</pre>";
}

curl_close($ch);
?>