<?php
include 'db_connection.php';
#menampilkan menu
$query = "SELECT id_menu, nama_menu, harga, deskripsi, type, image_path FROM menu";
$result = $conn->query($query);

$menu = array();
while($row = $result->fetch_assoc()) {
    $menu[] = $row;
}
#mengirim menu dengan mengubahnya menjadi json
header('Content-Type: application/json');
echo json_encode($menu);
?>