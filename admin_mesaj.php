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
$result = $conn->query("SELECT * FROM iletisim"); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Mesajlar</title>
</head>

<div class="admin-table-wrapper">
    <h2><i class="fas fa-exclamation-triangle"></i> Mesajlar</h2>
    
    <table class="error-table">
        <thead>
            <tr>
                <th>AD / SOYAD</th>
                <th>E-POSTA</th>
                <th>MESAJ</th>
                <th>TARİH</th>
                <th>İŞLEMLER</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="text-cell"><?php echo htmlspecialchars($row['ad']); ?>
                    <?php echo htmlspecialchars($row['soyad']); ?></td>
                    
                    <td class="text-cell"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['mesaj']); ?></span></td>
                    <td class="date-cell"><?php echo date('d.m.Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="admin_yonetimi_mesaj.php?id=<?php echo $row['id']; ?>">
                            <button class="edit-btn">Düzenle</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<center><a href="admin.php"><button class="back-btn">Geri dön</button></a></center>