<!--Halaman Profil-->
<?php
include 'auto_check.php';
require_once 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PizzaGut</title>
        <link rel="stylesheet" href="../css/profil.css">
        <script src="../javascript/profil.js"></script>  <!-- Menyisipkan JavaScript -->  <!-- Jika ingin menggunakan AJAX, tambahkan ini -->
    </head>
    
<body>
<header>
        <nav>
            <div class="logo">PizzaGut</div>
            <ul class="nav-links">
            <li><a href="../php/profil.php">Profil</a></li>
                <li><a href="../php/main.php">Home</a></li>
                <li><a href="../php/menu.php">Menu</a></li>
                <li><a href="../php/cart.php">Cart</a></li>
                <li><a href="../php/riwayat.php">Riwayat</a></li>
              
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="profile-container">
        <div class="profile-pic"></div>
        <div class="user-name">User Name</div>
        <div class="edit-profile-button">
            <button onclick="toggleEditMode(true)">Edit Profil</button>
        </div>
        <div class="button-group">
            <button onclick="saveProfile()">Save</button>
            <button onclick="toggleEditMode(false)">Cancel</button>
        </div>
    </div>
    <div class="form-container">
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" readonly>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" readonly>
    </div>
    <div class="form-group">
        <label for="no-telpon">No Telpon</label>
        <input type="text" id="no-telpon" name="no-telpon" readonly>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" readonly>
    </div>
</div>
    
</body>
</html>