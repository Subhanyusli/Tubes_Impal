<?php
//memulai session
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}
//mengubah data json menjadi array php
$data = json_decode(file_get_contents('php://input'), true);
$menu_id = $data['menu_id'];
$quantity = $data['quantity'];
$user_id = $_SESSION['user_id'];

// Get harga dari menu berdasarkan id_menu
$price_query = "SELECT harga FROM menu WHERE id_menu = ?";
$stmt = $conn->prepare($price_query);
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();
$menu_data = $result->fetch_assoc();
$total_harga = $menu_data['harga'] * $quantity;

// Insert into keranjang
$sql = "INSERT INTO keranjang (id_user, id_menu, jumlah, harga) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiid", $user_id, $menu_id, $quantity, $total_harga);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>