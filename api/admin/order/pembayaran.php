<?php
// Menetapkan header JSON
header('Content-Type: application/json');

// Memulai sesi dan menghubungkan ke database
session_start();

// Fungsi untuk mendapatkan data pembayaran berdasarkan id_order
function getPaymentDetails($id_order, $conn)
{
    $query = "SELECT * FROM tbl_pembayaran WHERE id_order='$id_order'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

// Fungsi untuk mengubah status order dan nomor resi
function updateOrderStatus($id_order, $status, $resi, $conn)
{
    $query = "UPDATE tbl_order SET status='$status', no_resi='$resi' WHERE id_order='$id_order'";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

// Mengambil id_order dari URL parameter
if (isset($_GET['id'])) {
    $id_order = $_GET['id'];

    // Mendapatkan data pembayaran
    $paymentDetails = getPaymentDetails($id_order, $conn);
    if ($paymentDetails) {
        // Mendapatkan tanggal pembayaran
        $tgl_bayar = date("d/m/Y", strtotime($paymentDetails['tgl_bayar']));

        // Menyusun respons data pembayaran dalam format JSON
        $response = [
            'status' => 'success',
            'payment_details' => [
                'bukti_transfer' => $paymentDetails['bukti_transfer'],
                'nm_pembayar' => $paymentDetails['nm_pembayar'],
                'nm_bank' => $paymentDetails['nm_bank'],
                'tgl_bayar' => $tgl_bayar,
                'jml_pembayaran' => number_format($paymentDetails['jml_pembayaran'])
            ]
        ];
        echo json_encode($response);
    } else {
        // Jika tidak ditemukan data pembayaran
        echo json_encode([
            'status' => 'error',
            'message' => 'Payment details not found for the given order ID'
        ]);
    }
}

// Mengubah status order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Memastikan parameter yang dibutuhkan ada
    if (isset($_POST['id_order']) && isset($_POST['status']) && isset($_POST['resi'])) {
        $id_order = $_POST['id_order'];
        $status = $_POST['status'];
        $resi = $_POST['resi'];

        // Memperbarui status order dan nomor resi
        $updateStatus = updateOrderStatus($id_order, $status, $resi, $conn);

        if ($updateStatus) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Order status updated successfully',
                'data' => [
                    'id_order' => $id_order,
                    'status' => $status,
                    'resi' => $resi
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update order status'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required parameters'
        ]);
    }
}
?>