<?php
header('Content-Type: application/json');
include('../../koneksi.php');

// Fungsi untuk menambahkan postingan
function addPost($judul, $isi, $kategori, $gambar, $db)
{
    $tgl = date('Y-m-d');
    $query = "INSERT INTO tbl_pos (judul, isi, gambar, id_kategori, tgl) VALUES ('$judul', '$isi', '$gambar', '$kategori', '$tgl')";
    return mysqli_query($db, $query);
}

// Menghandle request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengecek apakah file gambar di-upload
    if (isset($_FILES['gambar'])) {
        $kategori = $_POST['kategori'];
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];

        // Mendapatkan file gambar
        $nmGambar = $_FILES['gambar']['name'];
        $lokasi = $_FILES['gambar']['tmp_name'];

        // Validasi kategori, judul, isi, dan gambar
        if (empty($kategori) || empty($judul) || empty($isi)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kategori, Judul, dan Isi harus diisi.'
            ]);
            exit();
        }

        if (!empty($lokasi)) {
            // Memindahkan gambar ke folder yang sesuai
            if (move_uploaded_file($lokasi, "assets/images/foto_pos/" . $nmGambar)) {
                // Menyimpan data postingan ke database
                if (addPost($judul, $isi, $kategori, $nmGambar, $db)) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Postingan berhasil ditambahkan.',
                        'data' => [
                            'judul' => $judul,
                            'isi' => $isi,
                            'kategori' => $kategori,
                            'gambar' => $nmGambar
                        ]
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data postingan.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Upload gambar gagal.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gambar harus di-upload.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gambar belum di-upload.'
        ]);
    }
}
?>