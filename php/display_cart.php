<?php
require 'db_connection.php'; 
#menampilkan item yang ada pada keranjang
$query = "SELECT k.id_keranjang, k.id_user, m.nama_menu, k.jumlah, k.harga 
          FROM keranjang k 
          JOIN menu m ON k.id_menu = m.id_menu";

$result = $conn->query($query);
#menyimpan data
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
#mengirim data sebagai json
header('Content-Type: application/json');
echo json_encode($data);
