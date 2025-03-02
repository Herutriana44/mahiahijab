<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include_once '../koneksi.php';

$category = $_GET['category'] ?? '';

$query = "SELECT a.id_pos, a.judul, a.gambar, a.tgl
          FROM tbl_pos a
          JOIN tbl_kat_pos m ON a.id_kategori = m.id_kategori
          WHERE m.nm_kategori = '$category'
          ORDER BY a.tgl DESC
          LIMIT 1";

$result = mysqli_query($db, $query);

$articles = [];
while ($data = mysqli_fetch_array($result)) {
    $articles[] = [
        'id_pos' => $data['id_pos'],
        'judul' => $data['judul'],
        'gambar' => $data['gambar'],
        'tgl' => date("F d, Y", strtotime($data['tgl']))
    ];
}

echo json_encode($articles);
mysqli_close($db);
