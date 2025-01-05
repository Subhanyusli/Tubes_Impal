<?php
session_start();
require_once 'db_connection.php';
#agar konten berupa json
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
#mendapatkan data json
$data = json_decode(file_get_contents('php://input'), true);
$userId = $_SESSION['user_id'];
#update data user
$stmt = $conn->prepare("UPDATE user SET nama = ?, nomor_telepon = ?, email = ?, alamat = ? WHERE id_user = ?");
$stmt->bind_param("ssssi", $data['nama'],$data['no-telpon'],$data['email'], $data['alamat'] , $userId);


if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Update failed']);
}
?>