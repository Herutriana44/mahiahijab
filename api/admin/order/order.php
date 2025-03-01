<?php
// Memulai sesi dan menghubungkan ke database
session_start();
header('Content-Type: application/json');

// Membuat koneksi ke database
include('../includes/config.php'); // Pastikan Anda sudah memiliki koneksi yang benar

// Fungsi untuk menghitung jumlah status tertentu
function getStatusCount($status, $conn)
{
    $query = "SELECT COUNT(*) AS jml FROM tbl_order WHERE status = '$status'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($result);
    return $data['jml'];
}

// Mendapatkan total order dan status yang berbeda
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mengambil total order berdasarkan status
    $totalOrder = getStatusCount('Belum Dibayar', $conn);
    $blmDibayar = getStatusCount('Belum Dibayar', $conn);
    $sudahDibayar = getStatusCount('Sudah Dibayar', $conn);
    $menyiapkanProduk = getStatusCount('Menyiapkan Produk', $conn);
    $produkDikirm = getStatusCount('Produk Dikirim', $conn);
    $diterima = getStatusCount('Produk Diterima', $conn);

    // Mengambil daftar order
    $ordersQuery = "SELECT * FROM tbl_order";
    $ordersResult = mysqli_query($conn, $ordersQuery);
    $orders = [];
    while ($data = mysqli_fetch_assoc($ordersResult)) {
        $orders[] = [
            'id' => $data['id_order'],
            'nm_penerima' => $data['nm_penerima'],
            'tgl_order' => date("d/m/Y", strtotime($data['tgl_order'])),
            'status' => $data['status'],
            'total_order' => $data['total_order'],
            'status_label' => getStatusLabel($data['status']),
        ];
    }

    // Menyusun response JSON
    echo json_encode([
        'status_counts' => [
            'total_order' => $totalOrder,
            'blm_dibayar' => $blmDibayar,
            'sudah_dibayar' => $sudahDibayar,
            'menyiapkan_produk' => $menyiapkanProduk,
            'produk_dikirim' => $produkDikirm,
            'produk_diterima' => $diterima,
        ],
        'orders' => $orders,
    ]);
}

// Fungsi untuk mendapatkan label status
function getStatusLabel($status)
{
    switch ($status) {
        case 'Belum Dibayar':
            return 'badge-warning';
        case 'Sudah Dibayar':
            return 'badge-secondary';
        case 'Menyiapkan Produk':
            return 'badge-info';
        case 'Produk Dikirim':
            return 'badge-danger';
        case 'Produk Diterima':
            return 'badge-success';
        default:
            return 'badge-default';
    }
}
?>