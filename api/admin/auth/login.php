<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include "../../koneksi.php";

$username = $_POST['u'] ?? '';
$password = $_POST['p'] ?? '';

$response = [];

$ambil = $db->prepare("SELECT * FROM tbl_admin WHERE username = ? AND password = ?");
$ambil->bind_param("ss", $username, $password);
$ambil->execute();
$result = $ambil->get_result();

if ($result->num_rows === 1) {
    $akun = $result->fetch_assoc();
    $_SESSION['admin'] = $akun['username'];
    $_SESSION['email'] = $akun['email'];

    $response = [
        'status' => 'success',
        'message' => 'Login berhasil!',
        'admin' => $akun['username'],
        'email' => $akun['email']
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Username atau password salah!'
    ];
}

echo json_encode($response);
?>
