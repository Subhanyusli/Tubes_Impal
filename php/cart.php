<?php
// cart.php
include 'auto_check.php';

require_once 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Fetch cart items with menu details
$query = "SELECT k.id_keranjang, k.jumlah, m.id_menu, m.nama_menu, m.harga, m.image_path 
          FROM keranjang k 
          JOIN menu m ON k.id_menu = m.id_menu 
          WHERE k.id_user = ? AND k.status = 'cart'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - PizzaGut</title>
    <link rel="stylesheet" href="../css/cart3.css">
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

    <div class="cart-container">
        <h2>Your Cart</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="cart-items">
                <?php 
                $total = 0;
                while ($row = $result->fetch_assoc()):
                    $subtotal = $row['jumlah'] * $row['harga'];
                    $total += $subtotal;
                ?>
                    <div class="cart-item" data-id="<?= $row['id_keranjang'] ?>">
                        <img src="<?= $row['image_path'] ?>" alt="<?= $row['nama_menu'] ?>">
                        <div class="item-details">
                            <h3><?= $row['nama_menu'] ?></h3>
                            <p>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></p>
                        </div>
                        <div class="quantity-controls">
                            <button class="quantity-btn minus" onclick="updateQuantity(<?= $row['id_keranjang'] ?>, 'decrease')">-</button>
                            <input type="number" class="quantity-input" value="<?= $row['jumlah'] ?>" 
                                   min="1" onchange="updateQuantity(<?= $row['id_keranjang'] ?>, 'set', this.value)">
                            <button class="quantity-btn plus" onclick="updateQuantity(<?= $row['id_keranjang'] ?>, 'increase')">+</button>
                        </div>
                        <div class="subtotal">
                            Rp. <?= number_format($subtotal, 0, ',', '.') ?>
                        </div>
                        <button class="remove-btn" onclick="removeItem(<?= $row['id_keranjang'] ?>)">×</button>
                    </div>
                <?php endwhile; ?>
                
                <div class="cart-summary">
                    <div class="total">
                        <h3>Total: Rp. <?= number_format($total, 0, ',', '.') ?></h3>
                    </div>
                    <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
                </div>
            </div>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty</p>
            <a href="menu.php" class="continue-shopping">Continue Shopping</a>
        <?php endif; ?>
    </div>

    <script src="../javascript/cart.js" ></script>
</body>
</html>