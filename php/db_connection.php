<?php
#mengubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "pizzagut";

try {
    // Membuat koneksi
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    // Periksa koneksi
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    // Set charset ke utf8
    mysqli_set_charset($conn, "utf8");
    
} catch (Exception $e) {
    // Tutup koneksi jika terjadi error
    die("Error: " . $e->getMessage());
}
?>

