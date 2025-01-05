<?php
require 'db_connection.php';
// Fungsi untuk membersihkan input
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Cek apakah permintaan berasal dari form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json'); // Pastikan response berupa JSON
    try {
        $user = cleanInput($_POST['username'] ?? '');
        $email = cleanInput($_POST['email'] ?? '');
        $nomor_telepon = cleanInput($_POST['nomor_telepon'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? ''; 
        // Validasi input
        if (empty($user) || empty($email) || empty($password) || empty($confirm_password) || empty($nomor_telepon)) {
            throw new Exception("Semua field harus diisi!");
        }

        // Pastikan password dan confirm password sama
        if ($password !== $confirm_password) {
            throw new Exception("Password dan Confirm Password harus sama!");
        }

        // Validasi password (minimal 8 karakter, huruf besar, huruf kecil, angka)
        if (strlen($password) < 8 || 
            !preg_match("/[A-Z]/", $password) || 
            !preg_match("/[a-z]/", $password) || 
            !preg_match("/[0-9]/", $password)) {
            throw new Exception("Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, dan angka!");
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO user (nama, password, nomor_telepon, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user, $hashed_password, $nomor_telepon, $email]);

        echo json_encode(['success' => true, 'message' => 'Pendaftaran berhasil!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
