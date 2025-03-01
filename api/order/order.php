<?php
// order.php
require "../koneksi.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Mendapatkan data JSON yang dikirim dari client
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Ambil data dari request (bukan list kecuali id_produk dan jumlah)
$id_pelanggan = $data['id_pelanggan'] ?? '';
$no_telp = $data['no_telp'] ?? '';
$provinsi = $data['province_destination'] ?? '';
$kota = $data['city_destination'] ?? '';
$kdPos = $data['kodePos'] ?? '';
$alamat = $data['alamat'] ?? '';
$catatan = $data['catatan'] ?? '';
$ongkir = $data['ongkir'] ?? 0;
$subtotal = $data['subtotal'] ?? 0;
$id_produk_list = $data['id_produk'] ?? [];
$jumlah_list = $data['jumlah'] ?? [];

if (empty($id_pelanggan) || empty($no_telp) || empty($provinsi) || empty($kota) || empty($kdPos) || empty($alamat) || empty($id_produk_list) || empty($jumlah_list)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Ambil nama pelanggan dari tbl_pelanggan
$query = "SELECT nm_pelanggan FROM tbl_pelanggan WHERE id_pelanggan='$id_pelanggan'";
$result = mysqli_query($db, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Customer not found']);
    exit;
}

$pelanggan = mysqli_fetch_array($result);
$nmPenerima = $pelanggan['nm_pelanggan']; // Nama penerima

$tgl_order = date('Y-m-d');

// Insert ke tbl_order
$query2 = "INSERT INTO tbl_order (id_pelanggan, nm_penerima, telp, provinsi, kota, kode_pos, alamat_pengiriman, catatan, tgl_order, ongkir, total_order) 
           VALUES ('$id_pelanggan', '$nmPenerima', '$no_telp', '$provinsi', '$kota', '$kdPos', '$alamat', '$catatan', '$tgl_order', '$ongkir', '$subtotal')";

if (!mysqli_query($db, $query2)) {
    echo json_encode(['status' => 'error', 'message' => 'Error inserting order']);
    exit;
}

// Ambil ID order terakhir
$id_order_barusan = mysqli_insert_id($db);

// Iterasi untuk insert ke tbl_detail_order
foreach ($id_produk_list as $index => $id_produk) {
    $jumlah = $jumlah_list[$index] ?? 0;
    if ($jumlah <= 0)
        continue;

    // Ambil data produk
    $query3 = "SELECT * FROM tbl_produk WHERE id_produk='$id_produk'";
    $result3 = mysqli_query($db, $query3);
    if (!$result3 || mysqli_num_rows($result3) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found for ID: ' . $id_produk]);
        exit;
    }

    $produk = mysqli_fetch_array($result3);
    $nmProduk = $produk['nm_produk'];
    $harga = $produk['harga'];
    $berat = $produk['berat'];
    $subberat = $berat * $jumlah;
    $subharga = $harga * $jumlah;

    // Insert ke tbl_detail_order
    $query4 = "INSERT INTO tbl_detail_order (id_order, id_produk, nm_produk, harga, jml_order, berat, subberat, subharga) 
               VALUES ('$id_order_barusan', '$id_produk', '$nmProduk', '$harga', '$jumlah', '$berat', '$subberat', '$subharga')";

    if (!mysqli_query($db, $query4)) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting detail for product ID: ' . $id_produk]);
        exit;
    }

    // Update stok produk
    $query5 = "UPDATE tbl_produk SET stok = stok - $jumlah WHERE id_produk='$id_produk'";
    if (!mysqli_query($db, $query5)) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating stock for product ID: ' . $id_produk]);
        exit;
    }
}

// Berhasil
echo json_encode([
    'status' => 'success',
    'message' => 'Order successfully placed',
    'order_id' => $id_order_barusan
]);
?>