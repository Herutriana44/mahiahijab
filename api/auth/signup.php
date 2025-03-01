<?php
session_start();
include "../koneksi.php";

header('Content-Type: application/json');

// Menangkap data input dari form
$nama = mysqli_real_escape_string($db, $_POST['nama']);
$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password = mysqli_real_escape_string($db, $_POST['password']);

// Hash password untuk keamanan
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
$hashed_password = $password;

// Query untuk mengecek apakah username atau email sudah terdaftar
$checkQuery = "SELECT * FROM tbl_pelanggan WHERE username = '$username' OR email = '$email'";
$checkResult = mysqli_query($db, $checkQuery);

// Jika username atau email sudah ada
if (mysqli_num_rows($checkResult) > 0) {
    $response = [
        'status' => 'error',
        'message' => 'Username atau Email sudah terdaftar!'
    ];
    echo json_encode($response);
    exit();
}

// Query untuk insert data pelanggan baru
$query = "INSERT INTO tbl_pelanggan (nm_pelanggan, username, email, password) 
            VALUES (?, ?, ?, ?)";

// Prepare statement untuk mencegah SQL injection
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, 'ssss', $nama, $username, $email, $hashed_password);

// Eksekusi query
if (mysqli_stmt_execute($stmt)) {
    $response = [
        'status' => 'success',
        'message' => 'Pendaftaran berhasil! Silakan login.'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan. Silakan coba lagi.'
    ];
}

// Kembalikan respons JSON
echo json_encode($response);

// Menutup statement dan koneksi
// mysqli_stmt_close($stmt);
mysqli_close($db);
exit();

?>