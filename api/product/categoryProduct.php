<?php
// Inisialisasi koneksi database
include "../koneksi.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Cek apakah ada parameter untuk kategori atau pencarian
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $query = "SELECT * FROM tbl_produk WHERE id_kategori='$kategori'";
} elseif (isset($_GET['select']) && !empty($_GET['select'])) {
    $cari = $_GET['select'];
    $query = "SELECT * FROM tbl_produk WHERE nm_produk LIKE '%" . mysqli_real_escape_string($db, $cari) . "%' ORDER BY id_produk ASC";
} else {
    $query = "SELECT * FROM tbl_produk p JOIN tbl_kat_produk k ON p.id_kategori=k.id_kategori ORDER BY id_produk ASC";
}

$response = []; // Menyiapkan array untuk response JSON

try {
    // Menyiapkan query untuk menampilkan kategori
    $qkat = "SELECT * FROM tbl_kat_produk";
    $reskat = mysqli_query($db, $qkat);

    if (!$reskat) {
        throw new Exception("Error fetching categories: " . mysqli_error($db));
    }

    // Kategori Produk
    $categories = [];
    while ($dat = mysqli_fetch_assoc($reskat)) {
        $categories[] = $dat;
    }

    // Menampilkan kategori di sidebar (untuk JSON response)
    $response['categories'] = $categories;

    // Menampilkan produk berdasarkan query kategori atau pencarian
    $result = mysqli_query($db, $query);
    if (!$result) {
        throw new Exception("Error fetching products: " . mysqli_error($db));
    }

    $products = [];
    while ($produk = mysqli_fetch_assoc($result)) {
        $products[] = [
            'id_produk' => $produk['id_produk'],
            'nm_produk' => $produk['nm_produk'],
            'harga' => number_format($produk['harga']),
            'gambar' => $produk['gambar'],
            'id_kategori' => $produk['id_kategori']
        ];
    }

    $response['products'] = $products;

    // Menambahkan status sukses dan pesan
    $response['status'] = 'success';
    $response['message'] = 'Data produk dan kategori berhasil diambil';

} catch (Exception $e) {
    // Mengirim respons error jika terjadi masalah
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

// Mengirimkan data dalam format JSON
echo json_encode($response);
?>