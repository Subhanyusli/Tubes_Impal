<!--halaman admin-->
<?php 
require_once 'db_connection.php';
require_once 'process_order.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PizzaGut</title>
    <link rel="stylesheet" href="../css/admin_recipe.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">PizzaGut Admin</div>
            <ul class="nav-links">
                <li><a href="admin_recipe.php">Pesanan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Daftar Pesanan</h2>
        <!--notif-->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="alert alert-success">Pesanan berhasil diupdate!</div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="alert alert-error">Gagal mengupdate pesanan!</div>
            <?php endif; ?>
        <?php endif; ?>

        <?php
        #mengambil pesanan dan memeriksa pesanan
        $orders = getAllOrders($conn);
        
        if ($orders && $orders->num_rows > 0) {
            #menampilkan detail setiap pesanan
            while ($order = $orders->fetch_assoc()) {
                $menu_details = explode("||", $order['menu_details']);#memishkan string 
        ?>
                <div class="order-card <?php echo $order['status']; ?>">
                    <h3>Pesanan #<?php echo $order['id_checkout']; ?></h3>
                    <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <div class="order-details">
                        <strong>Detail Pesanan:</strong>
                        <ul>
                            <?php
                            foreach ($menu_details as $detail) {
                                echo "<li>" . htmlspecialchars($detail) . "</li>";
                            }
                            ?>
                        </ul>
                        <p><strong>Total:</strong> Rp <?php echo number_format($order['harga'], 0, ',', '.'); ?></p>
                        <p><strong>Alamat:</strong> <?php echo htmlspecialchars($order['alamat']); ?></p>
                        <p><strong>Tanggal Pesanan:</strong> <?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?></p>
                    </div>
                    <!--tombol aksi ketika status pending-->
                    <?php if ($order['status'] === 'pending'): ?>
                        <div class="order-actions">
                            <form method="POST" action="process_order.php" style="display: inline;">
                                <input type="hidden" name="timestamp" value="<?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?>">
                                <input type="hidden" name="user_id" value="<?php echo $order['id_user']; ?>">
                                <button type="submit" name="action" value="accept" class="btn-accept">Terima Pesanan</button>
                                <button type="submit" name="action" value="reject" class="btn-reject">Tolak Pesanan</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <p><strong>Status:</strong> 
                            <span class="status-badge <?php echo $order['status']; ?>">
                                <?php 
                                $status_text = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Diterima',
                                    'rejected' => 'Ditolak'
                                ];
                                echo $status_text[$order['status']] ?? ucfirst($order['status']); 
                                ?>
                            </span>
                        </p>
                    <?php endif; ?>
                </div>
        <?php
            }
        } else {
            echo "<p>Tidak ada pesanan saat ini.</p>";
        }
        ?>
    </main>
</body>
</html>