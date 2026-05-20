<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

include("connection.php");

$result = $conn->query("SELECT * FROM sistemler");

?>



    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Sponsorlar</title>
</head>

<div class="admin-table-wrapper">
    <h2><i class="fas fa-exclamation-triangle"></i>Sistem Yönetimi</h2>
    
    <table class="error-table">
        <thead>
            <tr>
                <th>Sistem Adı</th>
                <th>CPU</th>
                <th>GPU</th>
                <th>RAM</th>
                <th>Fiyat</th>
                <th>Link</th>
                <th>Yüklenme Tarihi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="code-cell"><code><?php echo htmlspecialchars($row['sistem_adi']); ?></code></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['cpu']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['gpu']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['ram']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['fiyat']); ?></td>
                    <td class="text-cell"><?php echo htmlspecialchars($row['link']); ?></td>
                    <td class="date-cell"><date><?php echo date('d.m.Y', strtotime($row['created_at'])); ?></date></td>

                    <td>
                        <a href="admin_yonetimi_sistem.php?id=<?php echo $row['id']; ?>">
                            <button class="edit-btn">Düzenle</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<center><a href="admin.php"><button class="back-btn">Geri dön</button></a></center>