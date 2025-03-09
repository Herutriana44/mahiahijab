<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require "../../koneksi.php";

// Fungsi untuk membuat produk baru
function create_product($db, $data)
{
    $kategori = $data['id_kategori'];
    $nmProduk = $data['nama'];
    $berat = $data['berat'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $deskripsi = $data['deskripsi'];
    $gambar = $data['img']['data']; // Base64 image
    $namaFile = $data['img']['name'];

    if (!empty($gambar)) {
        // Direktori penyimpanan gambar
        $folder = "../../../fe/src/assets/admin/assets/images/foto_produk/";
        $filename = time() . "_" . $namaFile;
        $path = $folder . $filename;

        // Decode Base64 ke file gambar
        $decodedImage = base64_decode($gambar);
        if (file_put_contents($path, $decodedImage)) {
            // Simpan data produk ke database
            $query = "INSERT INTO tbl_produk (id_kategori, nm_produk, berat, harga, stok, gambar, deskripsi) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "isssiss", $kategori, $nmProduk, $berat, $harga, $stok, $filename, $deskripsi);
            $exec = mysqli_stmt_execute($stmt);

            if ($exec) {
                echo json_encode(["status" => "success", "message" => "Produk berhasil ditambahkan"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal menambahkan produk"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan gambar"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Gambar diperlukan"]);
    }
}

// Fungsi untuk memperbarui produk
function update_product($db, $id, $data)
{
    $kategori = $data['id_kategori'];
    $nmProduk = $data['nama'];
    $berat = $data['berat'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $deskripsi = $data['deskripsi'];
    $gambar = isset($data['img']['data']) ? $data['img']['data'] : null;
    $namaFile = isset($data['img']['name']) ? $data['img']['name'] : null;

    if ($gambar) {
        // Simpan gambar baru
        $folder = "../../../fe/src/assets/admin/assets/images/foto_produk/";
        $filename = time() . "_" . $namaFile;
        $path = $folder . $filename;
        file_put_contents($path, base64_decode($gambar));

        // Update database dengan gambar baru
        $query = "UPDATE tbl_produk SET id_kategori=?, nm_produk=?, berat=?, harga=?, stok=?, gambar=?, deskripsi=? WHERE id_produk=?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "isssissi", $kategori, $nmProduk, $berat, $harga, $stok, $filename, $deskripsi, $id);
    } else {
        // Update database tanpa mengubah gambar
        $query = "UPDATE tbl_produk SET id_kategori=?, nm_produk=?, berat=?, harga=?, stok=?, deskripsi=? WHERE id_produk=?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "isssisi", $kategori, $nmProduk, $berat, $harga, $stok, $deskripsi, $id);
    }

    $exec = mysqli_stmt_execute($stmt);

    if ($exec) {
        echo json_encode(["status" => "success", "message" => "Produk berhasil diperbarui"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal memperbarui produk"]);
    }
}

// Fungsi untuk menghapus produk
function delete_product($db, $id)
{
    // Ambil informasi gambar produk
    $query = "SELECT gambar FROM tbl_produk WHERE id_produk=?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produk = mysqli_fetch_assoc($result);

    if ($produk) {
        // Hapus gambar dari folder jika ada
        if (!empty($produk['gambar']) && file_exists($produk['gambar'])) {
            unlink($produk['gambar']);
        }

        // Hapus produk dari database
        $query = "DELETE FROM tbl_produk WHERE id_produk=?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $exec = mysqli_stmt_execute($stmt);

        if ($exec) {
            echo json_encode(["status" => "success", "message" => "Produk berhasil dihapus"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menghapus produk"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Produk tidak ditemukan"]);
    }
}

// Fungsi untuk mendapatkan semua produk
function get_all_products($db)
{
    $query = "SELECT * FROM tbl_produk";
    $result = mysqli_query($db, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($products) {
        echo json_encode(["status" => "success", "products" => $products]);
    } else {
        echo json_encode(["status" => "error", "message" => "Produk tidak ditemukan"]);
    }
}

// Fungsi untuk mendapatkan produk berdasarkan ID
function get_product($db, $id)
{
    $query = "SELECT * FROM tbl_produk WHERE id_produk=?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        echo json_encode(["status" => "success", "product" => $product]);
    } else {
        echo json_encode(["status" => "error", "message" => "Produk tidak ditemukan"]);
    }
}

// Menangani request
$request_method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        create_product($db, $data);
        break;

    case 'PUT':
        if ($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            update_product($db, $id, $data);
        } else {
            echo json_encode(["status" => "error", "message" => "ID produk diperlukan"]);
        }
        break;

    case 'DELETE':
        if ($id) {
            delete_product($db, $id);
        } else {
            echo json_encode(["status" => "error", "message" => "ID produk diperlukan"]);
        }
        break;

    case 'GET':
        if ($id) {
            get_product($db, $id);
        } else {
            get_all_products($db);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Metode request tidak valid"]);
        break;
}
?>