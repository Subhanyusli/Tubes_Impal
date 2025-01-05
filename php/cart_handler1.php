<?php
session_start();
header('Content-Type: application/json');

require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Silakan login terlebih dahulu'
    ]);
    exit();
}

// menangani permintaan post dan tambah item ke cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_menu'])) {
    try {
        mysqli_begin_transaction($conn);

        $id_menu = mysqli_real_escape_string($conn, $_POST['id_menu']);
        $query = "SELECT id_menu, nama_menu, harga FROM menu WHERE id_menu = '$id_menu'";
        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) === 0) {
            throw new Exception('Menu tidak ditemukan');
        }

        $menu = mysqli_fetch_assoc($result);
        $user_id = $_SESSION['user_id'];

        // check jika item sudah ada di cart
        $query = "SELECT id_keranjang, jumlah FROM keranjang 
                 WHERE id_user = '$user_id' 
                 AND id_menu = '$id_menu' 
                 AND status = 'cart'";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // update jumlah item yang ada
            $cart_item = mysqli_fetch_assoc($result);
            Echo "Gagal menambahkan item ke keranjang";
         
        } else {
            // insert item baru jika tidak ada
            $query = "INSERT INTO keranjang (id_user, id_menu, jumlah, harga, status) 
                     VALUES ('$user_id', '$id_menu', 1, '{$menu['harga']}', 'cart')";
        }

        if (!mysqli_query($conn, $query)) {
            throw new Exception('Gagal memperbarui keranjang');
        }

        // Commit transaksi
        mysqli_commit($conn);

        echo json_encode([
            'success' => true,
            'message' => 'Item berhasil ditambahkan ke keranjang'
        ]);

    } catch (Exception $e) {
        // Rollback jika error
        mysqli_rollback($conn);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menambahkan item ke keranjang: ' . $e->getMessage()
        ]);
    }

    exit();
}


// menangani permintaan GET untuk mengambil item dari keranjang
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT k.*, m.nama_menu, m.image_path 
                 FROM keranjang k 
                 JOIN menu m ON k.id_menu = m.id_menu 
                 WHERE k.id_user = '$user_id' 
                 AND k.status = 'cart'";
        
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            throw new Exception('Gagal mengambil data keranjang');
        }

        $cartItems = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cartItems[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $cartItems
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }

    exit();
}

// jika permintaan tidak valid
echo json_encode([
    'success' => false,
    'message' => 'Invalid request method'
]);

// menutup koneksi
mysqli_close($conn);
?>