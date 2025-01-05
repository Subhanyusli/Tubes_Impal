<?php
//untuk memasukkan akun Admin secara manual
require_once 'db_connection.php';

$test_data = [
    'nama' => 'rian',
    'password' => password_hash('Admin12345', PASSWORD_DEFAULT),
    'nomor_telepon' => '1234567890',
    'email' => 'rian@gmail.com'
];

$sql = "INSERT INTO admin (nama, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", 
    $test_data['nama'], 
    $test_data['password'], 
    $test_data['email']
);

if ($stmt->execute()) {
    echo "Test insert berhasil!";
} else {
    echo "Error: " . $stmt->error;
}
?>