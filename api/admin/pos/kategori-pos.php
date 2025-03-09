<?php
// Menetapkan header JSON
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, DELETE,PUT, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Memulai sesi dan menghubungkan ke database
session_start();

// Fungsi untuk mendapatkan daftar kategori
function getAllCategories($conn)
{
    $query = "SELECT * FROM tbl_kat_pos";
    $result = mysqli_query($conn, $query);
    $categories = [];

    while ($data = mysqli_fetch_assoc($result)) {
        $categories[] = $data;
    }

    return $categories;
}

// Fungsi untuk menambahkan kategori
function addCategory($name, $conn)
{
    $query = "INSERT INTO tbl_kat_pos (nm_kategori) VALUES ('$name')";
    return mysqli_query($conn, $query);
}

// Fungsi untuk menghapus kategori berdasarkan id_kategori
function deleteCategory($id, $conn)
{
    $query = "DELETE FROM tbl_kat_pos WHERE id_kategori='$id'";
    return mysqli_query($conn, $query);
}

// Mengambil daftar kategori (GET request)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mendapatkan semua kategori
    $categories = getAllCategories($conn);

    if (count($categories) > 0) {
        echo json_encode([
            'status' => 'success',
            'data' => $categories
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No categories found'
        ]);
    }
}

// Menambahkan kategori baru (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nama'])) {
        $name = $data['nama'];
        $result = addCategory($name, $conn);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Category added successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add category'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Category name is required'
        ]);
    }
}

// Menghapus kategori (DELETE request)
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Mengambil id kategori dari URL parameter
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $result = deleteCategory($id, $conn);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete category'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Category ID is required'
        ]);
    }
}
?>