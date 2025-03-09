<?php
header('Content-Type: application/json');
include('../../koneksi.php');

header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS"); // Izinkan metode GET, POST, DELETE, PUT
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Fungsi untuk menambahkan postingan
function addPost($judul, $isi, $kategori, $gambarBase64, $db)
{
    $tgl = date('Y-m-d');
    $query = "INSERT INTO tbl_pos (judul, isi, gambar, id_kategori, tgl) VALUES ('$judul', '$isi', '$gambarBase64', '$kategori', '$tgl')";
    return mysqli_query($db, $query);
}

// Menghandle request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil input dari JSON
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);

    // Validasi input
    if (!isset($input['judul']) || !isset($input['isi']) || !isset($input['kategori']) || !isset($input['gambar'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kategori, Judul, Isi, dan Gambar harus diisi.'
        ]);
        exit();
    }

    $judul = $input['judul'];
    $isi = $input['isi'];
    $kategori = $input['kategori'];
    $gambarBase64 = $input['gambar']; // Base64 image langsung disimpan di database

    // Menyimpan data ke database
    if (addPost($judul, $isi, $kategori, $gambarBase64, $db)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Postingan berhasil ditambahkan.',
            'data' => [
                'judul' => $judul,
                'isi' => $isi,
                'kategori' => $kategori,
                'gambar' => 'Base64 image disimpan'
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan data postingan.'
        ]);
    }
}
?>