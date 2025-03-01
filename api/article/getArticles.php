<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu
header('Content-Type: application/json');
include_once '../koneksi.php'; // Koneksi ke database

// Query untuk mengambil artikel dengan kategori tertentu
$query = "SELECT a.id_pos, a.judul, a.gambar, a.tgl, m.nm_kategori
          FROM tbl_pos a
          JOIN tbl_kat_pos m ON a.id_kategori = m.id_kategori
          ORDER BY a.judul ASC";  // Mengambil semua artikel

$result = mysqli_query($db, $query);

// Cek apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    $articles = [];
    while ($data = mysqli_fetch_array($result)) {
        $articles[] = [
            'id_pos' => $data['id_pos'],
            'judul' => $data['judul'],
            'gambar' => $data['gambar'],
            'tgl' => date("F d, Y", strtotime($data['tgl'])),
            'nm_kategori' => $data['nm_kategori']
        ];
    }

    // Mengirim data dalam format JSON
    echo json_encode([
        'status' => 'success',
        'data' => $articles
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Tidak ada artikel ditemukan'
    ]);
}

// Menutup koneksi
mysqli_close($db);
?>