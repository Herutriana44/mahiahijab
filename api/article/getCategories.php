<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once '../koneksi.php';

$query = "SELECT DISTINCT nm_kategori FROM tbl_kat_pos";
$result = mysqli_query($db, $query);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $categories]);
mysqli_close($db);
