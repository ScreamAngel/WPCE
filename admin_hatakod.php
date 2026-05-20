<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

include("connection.php");

// Bu satırı ekleyerek $result değişkenini tanımlıyoruz:
$result = $conn->query("SELECT * FROM error_codes"); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Hata Kodları</title>
</head>

<div class="admin-table-wrapper">
    <h2><i class="fas fa-exclamation-triangle"></i> Hata Kodu Yönetimi</h2>
    
    <table class="error-table">
        <thead>
            <tr>
                <th>Hata Kodu</th>
                <th>Nedeni</th>
                <th>Çözüm</th>
                <th>Kategori</th>
                <th>Tarih</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="code-cell"><code><?php echo htmlspecialchars($row['error_code']); ?></code></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['hata_neden']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['cozum']); ?></td>
                    <td><span class="category-badge"><?php echo htmlspecialchars($row['kategori']); ?></span></td>
                    <td class="date-cell"><?php echo date('d.m.Y', strtotime($row['updated_at'])); ?></td>
                    <td>
                        <a href="admin_yonetimi_hatalar.php?id=<?php echo $row['id']; ?>">
                            <button class="edit-btn">Düzenle</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<center><a href="admin.php"><button class="back-btn">Geri dön</button></a></center>