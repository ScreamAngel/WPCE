<?php
// Render'ın vereceği ortam değişkenleri
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
$port = "5432"; // PostgreSQL varsayılan portu

try {
    // PostgreSQL için DSN (Data Source Name) bağlantı dizesi
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    // PDO nesnesini oluştur
    $conn = new PDO($dsn, $user, $pass);
    
    // Hataları daha net görebilmek için hata modunu aktif et
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
?>
