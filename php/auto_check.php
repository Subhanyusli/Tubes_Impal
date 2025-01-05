
<?php
#memastikan pengguna / admin telah login
session_start();

// Cek apakah user atau admin sudah login
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: ../html/login.html"); // Redirect ke halaman login
    exit();
}
?>
