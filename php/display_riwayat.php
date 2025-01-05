<?php
session_start();
require_once 'db_connection.php';

require_once 'auto_check.php';

// Query untuk mengelompokkan transaksi berdasarkan waktu yang sama
$query = "SELECT 
            DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i') as timestamp,
            GROUP_CONCAT(CONCAT(m.nama_menu, ' x', c.jumlah) SEPARATOR '||') AS menu_details,
            SUM(m.harga * c.jumlah) AS total_harga,
            c.status
          FROM checkout c
          JOIN menu m ON c.id_menu = m.id_menu 
          WHERE c.id_user = ?
          GROUP BY 
            DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i'),
            c.status
          ORDER BY c.created_at DESC";
#menjalankan query
try {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    echo '<h2>Riwayat Transaksi</h2>';
    
    $current_date = null;
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // mengubah timestamp to date for grouping
            $date = date('Y-m-d', strtotime($row['timestamp']));
            
            // Jika tanggal berubah, tampilkan header baru
            if ($current_date !== $date) {
                $current_date = $date;
                echo '<h3>' . date('d-m-Y', strtotime($current_date)) . '</h3>';
            }
            #menampilkan riwayat transaksi
            echo '<div class="transaction-card">';
            $menu_items = explode("||", $row['menu_details']);
            foreach ($menu_items as $item) {
                echo '<div class="menu-item">' . htmlspecialchars($item) . '</div>';
            }
            echo '<div class="total">Total Rp.' . number_format($row['total_harga'], 0, ',', '.') . '</div>';
            echo '<div class="status ' . strtolower($row['status']) . '">' . htmlspecialchars($row['status']) . '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Belum ada riwayat transaksi.</p>';
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>