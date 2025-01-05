<?php
session_start();
require_once 'db_connection.php';
#agar konten yang dikirim adalah json
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
#mengambil data user
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nama, nomor_telepon, email, alamat FROM user WHERE id_user = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

echo json_encode($userData);
?>