<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu
header('Content-Type: application/json');
// session_start();
include "../koneksi.php";
session_start();

$username = $_POST['u'];
$password = $_POST['p'];
$ambil = $db->query("SELECT * FROM tbl_pelanggan WHERE username = '$username' AND password = '$password'");
$yangcocok = $ambil->num_rows;

// Menyiapkan response
$response = array();

if ($yangcocok == 1) {
    $akun = $ambil->fetch_assoc();
    $_SESSION['pelanggan'] = $akun;
    $_SESSION['email'] = $akun['email'];

    // Response sukses
    $response['status'] = 'success';
    $response['message'] = 'Anda Berhasil Login';
    $response['email'] = $akun['email'];
    $response['pelanggan'] = $akun;
} else {
    // Response error
    $response['status'] = 'error';
    $response['message'] = 'Username Dan Password Anda Salah';
}

// Kirimkan response dalam format JSON
echo json_encode($response);
?>