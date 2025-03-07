<?php
// Menetapkan header JSON
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, DELETE,PUT, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Memulai sesi dan menghubungkan ke database
session_start();
include('../includes/config.php');  // Pastikan Anda sudah menyiapkan koneksi ke DB dengan benar

// Fungsi untuk mendapatkan daftar pelanggan
function getAllCustomers($conn)
{
    $query = "SELECT * FROM tbl_pelanggan";
    $result = mysqli_query($conn, $query);
    $customers = [];

    while ($data = mysqli_fetch_assoc($result)) {
        $customers[] = $data;
    }

    return $customers;
}

// Fungsi untuk menghapus pelanggan berdasarkan id_pelanggan
function deleteCustomer($id, $conn)
{
    $query = "DELETE FROM tbl_pelanggan WHERE id_pelanggan='$id'";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

// Mengambil daftar pelanggan (GET request)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mendapatkan semua pelanggan
    $customers = getAllCustomers($conn);

    if (count($customers) > 0) {
        echo json_encode([
            'status' => 'success',
            'data' => $customers
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No customers found'
        ]);
    }
}

// Menghapus pelanggan (DELETE request)
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Mendapatkan id pelanggan dari URL parameter
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $deleteStatus = deleteCustomer($id, $conn);

        if ($deleteStatus) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Customer deleted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete customer'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Customer ID is required'
        ]);
    }
}
?>