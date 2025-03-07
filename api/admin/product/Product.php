<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, DELETE,PUT, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Include database connection
require "../../koneksi.php";

// Function to create a product
function create_product($db, $data)
{
    $kategori = $data['id_kategori'];
    $nmProduk = $data['nama'];
    $berat = $data['berat'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $deskripsi = $data['deskripsi'];
    $nmGambar = $data['img']['name'];
    $lokasi = $data['img']['tmp_name'];

    if (!empty($lokasi)) {
        // Move uploaded image to a specific folder
        if (move_uploaded_file($lokasi, "assets/images/foto_produk/" . $nmGambar)) {
            // Insert product data into the database
            $query_add = "INSERT INTO tbl_produk (id_kategori, nm_produk, berat, harga, stok, gambar, deskripsi) 
                          VALUES ('$kategori', '$nmProduk', '$berat', '$harga', '$stok', '$nmGambar', '$deskripsi')";
            $exec_add = mysqli_query($db, $query_add);

            if ($exec_add) {
                echo json_encode(["message" => "Product added successfully"]);
            } else {
                echo json_encode(["message" => "Failed to add product"]);
            }
        } else {
            echo json_encode(["message" => "Image upload failed"]);
        }
    } else {
        echo json_encode(["message" => "Image file is required"]);
    }
}

// Function to update a product
function update_product($db, $id, $data)
{
    $kategori = $data['id_kategori'];
    $nmProduk = $data['nama'];
    $berat = $data['berat'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $deskripsi = $data['deskripsi'];
    $nmGambar = isset($data['img']) ? $data['img']['name'] : null;
    $lokasi = isset($data['img']) ? $data['img']['tmp_name'] : null;

    // Handle image upload if new image is provided
    if ($lokasi && !empty($lokasi)) {
        // move_uploaded_file($lokasi, "assets/images/foto_produk/$nmGambar");
        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', gambar='$nmGambar', deskripsi='$deskripsi' WHERE id_produk='$id'";
    } else {
        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id_produk='$id'";
    }

    $resultEdit = mysqli_query($db, $queryEdit);

    if ($resultEdit) {
        echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update product"]);
    }
}

// Function to delete a product
// Hapus produk berdasarkan ID
function delete_product($db, $id)
{
    // Cek apakah produk memiliki relasi di tabel lain
    $queryCheck = "SELECT COUNT(*) as count FROM tbl_detail_order WHERE id_produk = '$id'";
    $resultCheck = mysqli_query($db, $queryCheck);
    $row = mysqli_fetch_assoc($resultCheck);

    if ($row['count'] > 0) {
        // Hapus terlebih dahulu data di tabel relasi
        $queryDeleteDetail = "DELETE FROM tbl_detail_order WHERE id_produk = '$id'";
        mysqli_query($db, $queryDeleteDetail);
    }

    // Ambil informasi produk untuk menghapus gambar
    $querySelect = "SELECT gambar FROM tbl_produk WHERE id_produk = '$id'";
    $execSelect = mysqli_query($db, $querySelect);
    $produk = mysqli_fetch_assoc($execSelect);

    // Hapus gambar dari folder jika ada
    if (!empty($produk['gambar']) && file_exists("../assets/images/foto_produk/" . $produk['gambar'])) {
        unlink("../assets/images/foto_produk/" . $produk['gambar']);
    }

    // Hapus produk dari tabel `tbl_produk`
    $queryDelete = "DELETE FROM tbl_produk WHERE id_produk = '$id'";
    $execDelete = mysqli_query($db, $queryDelete);

    if ($execDelete) {
        echo json_encode(["status" => "success", "message" => "Produk berhasil dihapus"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menghapus produk"]);
    }
}


// Function to get all products
function get_all_products($db)
{
    $query = "SELECT * FROM tbl_produk";
    $result = mysqli_query($db, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($products) {
        echo json_encode(["products" => $products]);
    } else {
        echo json_encode(["message" => "No products found"]);
    }
}

// Function to get a product by ID
function get_product($db, $id)
{
    $query = "SELECT * FROM tbl_produk WHERE id_produk = '$id'";
    $result = mysqli_query($db, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(["message" => "Product not found"]);
    }
}

// Route handling
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($request_method) {
    case 'POST':
        // Handle create product
        $data = json_decode(file_get_contents('php://input'), true);
        create_product($db, $data);
        break;

    case 'PUT':
        // Handle update product
        if ($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            update_product($db, $id, $data);
        } else {
            echo json_encode(["message" => "Product ID is required for update"]);
        }
        break;

    case 'DELETE':
        // Handle delete product
        if ($id) {
            delete_product($db, $id);
        } else {
            echo json_encode(["message" => "Product ID is required for deletion"]);
        }
        break;

    case 'GET':
        if ($id) {
            // Get product by ID
            get_product($db, $id);
        } else {
            // Get all products
            get_all_products($db);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
}
?>