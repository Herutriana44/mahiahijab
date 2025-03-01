<?php
header('Content-Type: application/json');

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
        move_uploaded_file($lokasi, "assets/images/foto_produk/$nmGambar");
        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', gambar='$nmGambar', deskripsi='$deskripsi' WHERE id_produk='$id'";
    } else {
        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id_produk='$id'";
    }

    $resultEdit = mysqli_query($db, $queryEdit);

    if ($resultEdit) {
        echo json_encode(["message" => "Product updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update product"]);
    }
}

// Function to delete a product
function delete_product($db, $id)
{
    $query = "SELECT * FROM tbl_produk WHERE id_produk = '$id'";
    $exec = mysqli_query($db, $query);
    $product = mysqli_fetch_array($exec);

    // Delete the image from the server
    if (file_exists("assets/images/foto_produk/" . $product['gambar'])) {
        unlink("assets/images/foto_produk/" . $product['gambar']);
    }

    // Delete the product from the database
    $query_delete = "DELETE FROM tbl_produk WHERE id_produk = '$id'";
    $exec_delete = mysqli_query($db, $query_delete);

    if ($exec_delete) {
        echo json_encode(["message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete product"]);
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