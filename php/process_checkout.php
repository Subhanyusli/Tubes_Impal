<?php
session_start();
require_once 'db_connection.php';

$conn->begin_transaction();
// Get data json
try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    if (!isset($data['total_items'])) {
        throw new Exception('Total items not provided');
    }

    $user_id = $_SESSION['user_id'];
    
    // Get data user
    $user_query = "SELECT alamat FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    
    if (!$user_data) {
        throw new Exception('User data not found');
    }
    
    $alamat = $user_data['alamat'];
    
    // Get cart items
    $cart_query = "SELECT k.*, m.harga, k.id_menu 
                   FROM keranjang k 
                   JOIN menu m ON k.id_menu = m.id_menu 
                   WHERE k.id_user = ? AND k.status = 'cart'";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    
    if ($cart_result->num_rows === 0) {
        throw new Exception('Cart is empty');
    }
    
    // Insert data ke table checkout (Secara terpisah)
    $checkout_query = "INSERT INTO checkout (id_user, alamat, jumlah, harga, id_menu, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($checkout_query);
    
    while ($item = $cart_result->fetch_assoc()) {
        $item_total = $item['jumlah'] * $item['harga'];
        $item_quantity = $item['jumlah'];
        $item_menu_id = $item['id_menu'];
        $stat= "pending";
        $stmt->bind_param("isidis", 
            $user_id, 
            $alamat,
            $item_quantity,
            $item_total,
            $item_menu_id,
            $stat
        );
        $stmt->execute();
    }
    
    // Delete cart items
    $delete_cart = "DELETE FROM keranjang WHERE id_user = ? AND status = 'cart'";
    $stmt = $conn->prepare($delete_cart);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Checkout successful'
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Error processing checkout: ' . $e->getMessage()
    ]);
}

$conn->close();
?>