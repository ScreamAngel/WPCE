<?php
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'connection.php';

if (!isset($_SESSION['admin']) || !isset($_POST['kullanici']) || !isset($_POST['mesaj'])) {
    echo json_encode(['status' => 'error']);
    exit;
}

$alici = mysqli_real_escape_string($conn, trim($_POST['kullanici']));
$mesaj = mysqli_real_escape_string($conn, trim($_POST['mesaj']));

if (!empty($mesaj)) {
    $sql = "INSERT INTO mesajlar (gonderen, alici, mesaj_metni) VALUES ('admin', '$alici', '$mesaj')";
    mysqli_query($conn, $sql);
    echo json_encode(['status' => 'success']);
}
?>