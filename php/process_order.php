<?php
session_start();
require_once 'db_connection.php';

// Fungsi untuk mengambil semua pesanan
function getAllOrders($conn) {
    $query = "SELECT 
        MIN(c.id_checkout) as id_checkout,
        c.status,
        c.id_user,
        c.created_at,
        c.alamat,
        u.nama as customer_name,
        GROUP_CONCAT(m.nama_menu, ' x', c.jumlah SEPARATOR '||') as menu_details,
        SUM(m.harga * c.jumlah) as harga
    FROM checkout c
    INNER JOIN user u ON c.id_user = u.id_user
    INNER JOIN menu m ON c.id_menu = m.id_menu
    GROUP BY 
        DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i'),
        c.id_user,
        c.status,
        c.alamat,
        u.nama
    ORDER BY c.created_at DESC";
    
    return $conn->query($query);
}

// Proses update status pesanan
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['timestamp']) && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $timestamp = $_POST['timestamp'];
    $action = $_POST['action'];
    
    if ($action === 'accept') {
        $status = 'confirmed';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    }
    
    // Update semua pesanan dalam grup yang sama (berdasarkan waktu dan user)
    $query = "UPDATE checkout 
              SET status = ?, id_admin = ? 
              WHERE id_user = ? 
              AND DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siss", $status, $_SESSION['admin_id'], $user_id, $timestamp);
    
    if ($stmt->execute()) {
        header("Location: admin_recipe.php?status=success");
    } else {
        header("Location: admin_recipe.php?status=error");
    }
    exit();
}
?>