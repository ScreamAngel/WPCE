<?php
include("connection.php");
session_start();

$admin_session = isset($_SESSION['admin']) ? strtolower($_SESSION['admin']) : null;

if (!($admin_session)) {
    header('Location: giris.php'); 
    exit;
}

include("connection.php");

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Yönetimi</title>
    <link rel="stylesheet" href="style6.css">

</head>
<body>
<div class="admin-table-wrapper">
    <h2><i class="fas fa-users"></i> Kullanıcı Yönetim Listesi</h2>
    
    <table class="user-table">
        <thead>
            <tr>
                <th>Ad / Soyad</th>
                <th>E-posta</th>
                <th>Şifre</th>
                <th>Tür</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): 
                $is_blocked = ($row['password'] === NULL || $row['password'] === "");
                $row_class = $is_blocked ? "row-blocked" : "";
            ?>
                <tr class="<?php echo $row_class; ?>">
                    <td>
                        <strong><?php echo htmlspecialchars($row['name']); ?></strong> 
                        <?php echo htmlspecialchars($row['surname']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <code><?php echo $is_blocked ? "---KİLİTLİ---" : htmlspecialchars($row['password']); ?></code>
                    </td>
                    <td>
                        <span class="badge <?php echo ($row['user_type'] == 'admin') ? 'badge-admin' : 'badge-user'; ?>">
                            <?php echo strtoupper($row['user_type']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if($is_blocked): ?>
                            <span class="badge badge-danger">BLOKE EDİLDİ</span>
                        <?php else: ?>
                            <span class="badge badge-success">AKTİF</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="admin_yonetimi.php?id=<?php echo $row['id']; ?>">
                            <button class="ilet2"><i class="fas fa-edit"></i> Düzenle</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<center><a href="admin.php"><button class="ilet2">Geri dön</button></a></center>
</body>
</html>

