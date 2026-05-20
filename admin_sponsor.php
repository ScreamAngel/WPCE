<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

include("connection.php");

$result = $conn->query("SELECT * FROM sponsorlar");

?>



    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Sponsorlar</title>
</head>

<div class="admin-table-wrapper">
    <h2><i class="fas fa-exclamation-triangle"></i> Hata Kodu Yönetimi</h2>
    
    <table class="error-table">
        <thead>
            <tr>
                <th>Sponsor Adı</th>
                <th>Web Site</th>
                <th>Tarih</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="code-cell"><code><?php echo htmlspecialchars($row['sponsor_adi']); ?></code></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['website']); ?></td>
                    <td class="date-cell"><?php echo date('d.m.Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="admin_yonetimi_sponsor.php?id=<?php echo $row['id']; ?>">
                            <button class="edit-btn">Düzenle</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<center><a href="admin.php"><button class="back-btn">Geri dön</button></a></center>