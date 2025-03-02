<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once '../koneksi.php';

$query = "SELECT a.id_pos, a.judul, a.gambar, a.tgl, m.nm_kategori
          FROM tbl_pos a
          JOIN tbl_kat_pos m ON a.id_kategori = m.id_kategori
          ORDER BY a.judul ASC";

$result = mysqli_query($db, $query);

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

echo json_encode(['status' => 'success', 'data' => $articles]);
mysqli_close($db);
