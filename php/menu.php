<!--Halaman menu-->
<?php include 'auto_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PizzaGut</title>
    <link rel="stylesheet" href="../css/menu.css">
    <script src="../javascript/menu1.js"></script>  
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
    <div class="menu_selection">
        <div class="menu-item menu-filter" id="allButton">
            <img src="../asset/menu_all.png" alt="Semua">
            <p>All</p>
        </div>
        <div class="menu-item menu-filter" id="foodButton">
            <img src="../asset/menu_makanan.jpg" alt="Pizza">
            <p>Food</p>
        </div>
        <div class="menu-item menu-filter" id="drinkButton">
            <img src="../asset/menu_minuman.jpg" alt="Minuman">
            <p>Drink</p>
        </div>
    </div>
    
    <div class="menu-container" id="menu-container">
        
        
    </div>
</body>
</html>
