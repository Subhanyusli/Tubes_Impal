<?php
session_start();
session_unset(); // Hapus semua data session
session_destroy(); // Hancurkan session
header("Location: ../html/home.html"); // Redirect ke halaman home
exit();
?>