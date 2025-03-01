<?php
header('Content-Type: application/json');
include('../../koneksi.php');

// Fungsi untuk mengedit postingan
function updatePost($id, $judul, $isi, $kategori, $gambar, $db)
{
    $tgl = date('Y-m-d');
    if ($gambar) {
        // Update dengan gambar
        $query = "UPDATE tbl_pos SET id_kategori='$kategori', judul='$judul', isi='$isi', gambar='$gambar', tgl='$tgl' WHERE id_pos='$id'";
    } else {
        // Update tanpa gambar
        $query = "UPDATE tbl_pos SET id_kategori='$kategori', judul='$judul', isi='$isi', tgl='$tgl' WHERE id_pos='$id'";
    }

    return mysqli_query($db, $query);
}

// Mengecek jika ada ID di request (untuk mengetahui pos yang akan diubah)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id']; // ID dari pos yang akan diubah
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];

    // Mengecek apakah ada gambar yang di-upload
    if (isset($_FILES['gambar'])) {
        $nmGambar = $_FILES['gambar']['name'];
        $lokasi = $_FILES['gambar']['tmp_name'];

        if (!empty($lokasi)) {
            // Pindahkan file gambar ke folder yang sesuai
            if (move_uploaded_file($lokasi, "assets/images/foto_pos/$nmGambar")) {
                // Melakukan update dengan gambar baru
                $result = updatePost($id, $judul, $isi, $kategori, $nmGambar, $db);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal meng-upload gambar.'
                ]);
                exit();
            }
        }
    } else {
        // Melakukan update tanpa gambar
        $result = updatePost($id, $judul, $isi, $kategori, null, $db);
    }

    // Mengecek apakah query berhasil
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Pos berhasil diubah.',
            'data' => [
                'id' => $id,
                'judul' => $judul,
                'isi' => $isi,
                'kategori' => $kategori,
                'gambar' => isset($nmGambar) ? $nmGambar : null
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mengubah pos.'
        ]);
    }
}
?>