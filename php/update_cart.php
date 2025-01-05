<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

require_once 'db_connection.php';
//update cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_keranjang = $_POST['id_keranjang'];
    $action = $_POST['action'];
    $value = isset($_POST['value']) ? $_POST['value'] : null;
    $user_id = $_SESSION['user_id'];
    //ketika remove item atau mengubah jumlah item
    if ($action === 'remove') {
        $query = "DELETE FROM keranjang WHERE id_keranjang = ? AND id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_keranjang, $user_id);
    } else {
        if ($action === 'increase') {
            $query = "UPDATE keranjang SET jumlah = jumlah + 1 
                     WHERE id_keranjang = ? AND id_user = ?";
        } elseif ($action === 'decrease') {
            $query = "UPDATE keranjang SET jumlah = GREATEST(1, jumlah - 1) 
                     WHERE id_keranjang = ? AND id_user = ?";
        } else { // set
            $query = "UPDATE keranjang SET jumlah = ? 
                     WHERE id_keranjang = ? AND id_user = ?";
        }
        
        $stmt = $conn->prepare($query);
        if ($action === 'set') {
            $stmt->bind_param("iii", $value, $id_keranjang, $user_id);
        } else {
            $stmt->bind_param("ii", $id_keranjang, $user_id);
        }
    }

    if ($stmt->execute()) {
        // Fetch updated cart total
        $total_query = "SELECT SUM(k.jumlah * m.harga) as total 
                       FROM keranjang k 
                       JOIN menu m ON k.id_menu = m.id_menu 
                       WHERE k.id_user = ? AND k.status = 'pending'";
        $total_stmt = $conn->prepare($total_query);
        $total_stmt->bind_param("i", $user_id);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total = $total_result->fetch_assoc()['total'] ?? 0;

        echo json_encode([
            'success' => true, 
            'total' => $total,
            'message' => 'Cart updated successfully'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
    }
}
?>