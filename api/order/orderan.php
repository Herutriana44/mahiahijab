<?php
// Include header untuk koneksi database
require_once "../koneksi.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Ambil id_pelanggan dari request API (GET atau POST)
$id = isset($_GET['id_pelanggan']) ? intval($_GET['id_pelanggan']) : (isset($_POST['id_pelanggan']) ? intval($_POST['id_pelanggan']) : null);

// Cek apakah id_pelanggan diberikan
if (!$id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID pelanggan diperlukan!'
    ]);
    exit();
}

// Query untuk mengambil data orderan berdasarkan id_pelanggan
$query = "SELECT * FROM tbl_order WHERE id_pelanggan='$id'";
$result = mysqli_query($db, $query);

$response = [];

// Cek apakah ada data orderan
if (mysqli_num_rows($result) > 0) {
    $orders = [];

    while ($data = mysqli_fetch_assoc($result)) {
        $id_order = $data['id_order'];
        $tgl = $data['tgl_order'];
        $status = $data['status'];

        // Mengambil jumlah produk dalam setiap order
        $query2 = "SELECT SUM(jml_order) AS jml FROM tbl_detail_order WHERE id_order='$id_order'";
        $result2 = mysqli_query($db, $query2);
        $data2 = mysqli_fetch_assoc($result2);

        // Menyusun data order untuk dikembalikan dalam response
        $orders[] = [
            'id_order' => $id_order,
            'tanggal' => date("F d, Y", strtotime($tgl)),
            'jumlah_produk' => $data2['jml'],
            'status' => $status,
            'total_harga' => $data['total_order'],
            'action_url' => getActionUrl($status, $id_order) // Menentukan action URL
        ];
    }

    // Menambahkan data orders ke response
    $response = [
        'status' => 'success',
        'message' => 'Data orderan ditemukan',
        'data' => $orders
    ];
} else {
    // Jika tidak ada orderan
    $response = [
        'status' => 'error',
        'message' => 'Orderan Kosong, Silahkan Melakukan Pembelian Dulu!'
    ];
}

// Mengembalikan response JSON
echo json_encode($response);

// Fungsi untuk menentukan action URL berdasarkan status
function getActionUrl($status, $id_order)
{
    switch ($status) {
        case 'Belum Dibayar':
            return "konfirmasi-pembayaran.php?id=$id_order";
        case 'Sudah Dibayar':
        case 'Menyiapkan Produk':
        case 'Produk Dikirim':
        case 'Produk Diterima':
            return "nota-order.php?id=$id_order";
        default:
            return "#";
    }
}

// Handle deletion (hapus order)
if (isset($_GET['delete'])) {
    $orderId = intval($_GET['delete']);

    // Cek apakah order ID valid dan sesuai dengan id_pelanggan
    $queryDelete = "SELECT * FROM tbl_order WHERE id_order='$orderId' AND id_pelanggan='$id'";
    $resultDelete = mysqli_query($db, $queryDelete);

    if (mysqli_num_rows($resultDelete) > 0) {
        $deleteQuery = "DELETE FROM tbl_order WHERE id_order = $orderId";
        $deleteResult = mysqli_query($db, $deleteQuery);

        if ($deleteResult) {
            $response = [
                'status' => 'success',
                'message' => 'Order berhasil dihapus'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus order'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Order tidak ditemukan atau tidak dapat dihapus'
        ];
    }

    echo json_encode($response);
    exit();
}
?>
