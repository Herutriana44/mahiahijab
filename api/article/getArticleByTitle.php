<?php
// Include database connection
require '../koneksi.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Check if search keyword is provided
if (isset($_GET['select'])) {
    $searchTerm = mysqli_real_escape_string($db, $_GET['select']);

    // SQL query to search posts
    $query = "SELECT * FROM tbl_pos WHERE judul LIKE '%$searchTerm%' ORDER BY id_pos DESC";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        $articles = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $articles[] = [
                'id_pos' => $data['id_pos'],
                'judul' => $data['judul'],
                'gambar' => $data['gambar'],
                'tgl' => date("F d, Y", strtotime($data['tgl'])),
                'preview' => substr($data['isi'], 0, 110) . '...',
                'detail_url' => "detail-postingan.php?id=" . $data['id_pos']
            ];
        }
        echo json_encode([
            'status' => 'success',
            'data' => $articles
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No articles found for the search term.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Search term is required.'
    ]);
}
?>