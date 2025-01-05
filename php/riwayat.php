<!---Halaman Riwayat-->
<?php
include 'auto_check.php';
require_once 'db_connection.php';

// memodifiai query menjadi group berdasarkan timestamp dan user_id
$sql = "SELECT 
        DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i') as timestamp,
        GROUP_CONCAT(CONCAT(m.nama_menu, ' x', c.jumlah) SEPARATOR '<br>') as items,
        SUM(m.harga * c.jumlah) as total_harga,
        c.status
        FROM checkout c 
        JOIN menu m ON c.id_menu = m.id_menu 
        WHERE c.id_user = ?
        GROUP BY 
            DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i'),
            c.status
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PizzaGut</title>
    <link rel="stylesheet" href="../css/riwayat1.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">PizzaGut</div>
            <div class="nav-links">
                <li><a href="../php/profil.php">Profil</a></li>
                <li><a href="../php/main.php">Home</a></li>
                <li><a href="../php/menu.php">Menu</a></li>
                <li><a href="../php/cart.php">Cart</a></li>
                <li><a href="../php/riwayat.php">Riwayat</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </div>
        </nav>
    </header>
    <div class="content">
        <h2>Riwayat Transaksi</h2>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="transaction">
                <p><?php echo $row['items']; ?></p>
                <p class="total">Total Rp.<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></p>
                <p><?php echo date('d-m-Y H:i', strtotime($row['timestamp'])); ?></p>
                <p class="status <?php echo strtolower($row['status']); ?>">
                    <?php
                    $status_text = [
                        'pending' => 'Menunggu',
                        'confirmed' => 'Pesanan Diterima',
                        'rejected' => 'Pesanan Ditolak'
                    ];
                    echo $status_text[$row['status']] ?? ucfirst($row['status']);
                    ?>
                </p>
            </div>
        <?php } ?>
    </div>
</body>
</html>