<?php
// Include your database connection
require '../koneksi.php'; // Assuming your database connection is here

// Set the response content type to JSON
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Fetch the list of products
$query = "SELECT * FROM tbl_produk ORDER BY id_produk DESC";
$result = mysqli_query($db, $query);

// Check if any products exist
if (mysqli_num_rows($result) > 0) {
    // Create an array to store the products
    $products = [];

    // Loop through the query result and store product data
    while ($data = mysqli_fetch_assoc($result)) {
        $products[] = [
            'id_produk' => $data['id_produk'],
            'nm_produk' => $data['nm_produk'],
            'gambar' => $data['gambar'],
            'detail_url' => "detail-produk.php?id=" . $data['id_produk']
        ];
    }

    // Return the products in JSON format
    echo json_encode([
        'status' => 'success',
        'data' => $products
    ]);
} else {
    // If no products found, return an error
    echo json_encode([
        'status' => 'error',
        'message' => 'No products found.'
    ]);
}
?>