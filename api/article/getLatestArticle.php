<?php
// Include database connection
require '../koneksi.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// SQL query to get latest articles
$query = "SELECT * FROM tbl_pos ORDER BY id_pos DESC LIMIT 8";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) > 0) {
    $articles = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $articles[] = [
            'id_pos' => $data['id_pos'],
            'judul' => $data['judul'],
            'gambar' => $data['gambar'],
            'detail_url' => "detail-blog.php?id=" . $data['id_pos']
        ];
    }
    echo json_encode([
        'status' => 'success',
        'data' => $articles
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No latest articles found.'
    ]);
}
?>