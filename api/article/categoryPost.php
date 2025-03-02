<?php
// Koneksi Database
include "../koneksi.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($db, $_GET['kategori']);
    $query = "SELECT * FROM tbl_pos WHERE id_kategori='$kategori'";
} elseif (isset($_GET['select']) && !empty($_GET['select'])) {
    $cari = mysqli_real_escape_string($db, $_GET['select']);
    $query = "SELECT * FROM tbl_pos WHERE judul LIKE '%$cari%' ORDER BY tgl DESC";
} else {
    $query = "SELECT * FROM tbl_pos p JOIN tbl_kat_produk k ON p.id_kategori=k.id_kategori ORDER BY tgl DESC";
}

$response = [];

try {
    $qkat = "SELECT * FROM tbl_kat_produk";
    $reskat = mysqli_query($db, $qkat);
    if (!$reskat) {
        throw new Exception("Error fetching categories: " . mysqli_error($db));
    }

    $categories = [];
    while ($kat = mysqli_fetch_assoc($reskat)) {
        $categories[] = $kat;
    }

    $response['categories'] = $categories;

    $result = mysqli_query($db, $query);
    if (!$result) {
        throw new Exception("Error fetching posts: " . mysqli_error($db));
    }

    $posts = [];
    while ($pos = mysqli_fetch_assoc($result)) {
        $posts[] = [
            'id_pos' => $pos['id_pos'],
            'judul' => $pos['judul'],
            'isi' => $pos['isi'],
            'gambar' => $pos['gambar'],
            'tgl' => date('d-m-Y', strtotime($pos['tgl'])),
            'id_kategori' => $pos['id_kategori']
        ];
    }

    $response['posts'] = $posts;

    $response['status'] = 'success';
    $response['message'] = 'Data posts dan kategori berhasil diambil';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
