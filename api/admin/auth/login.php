<?php
// Memulai sesi dan menghubungkan ke database
session_start();
include "../../koneksi.php";

// Mengatur header untuk JSON
header('Content-Type: application/json');

// Mendapatkan data dari body request (dalam format JSON)
$data = json_decode(file_get_contents("php://input"));

// Mengecek jika data POST diterima
if (isset($data->username) && isset($data->password)) {
    $username = $data->username;
    $password = $data->password;

    // Menjalankan query untuk mencari username dan password yang cocok
    $ambil = $db->query("SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'");
    $yangcocok = $ambil->num_rows;

    // Mengecek hasil dari query
    if ($yangcocok == 1) {
        // Jika login berhasil, menyimpan data admin ke dalam session
        $_SESSION['tbl_admin'] = $ambil->fetch_assoc();

        print_r($_SESSION);

        // Mengirimkan response sukses dalam format JSON
        echo json_encode([
            "status" => "success",
            "message" => "Login Berhasil",
            "data" => $_SESSION['tbl_admin']
        ]);
    } else {
        // Jika login gagal
        echo json_encode([
            "status" => "failure",
            "message" => "Login Gagal. Username atau password salah"
        ]);
    }
} else {
    // Jika data tidak lengkap (username atau password tidak ada)
    echo json_encode([
        "status" => "failure",
        "message" => "Username dan password harus diisi"
    ]);
}
?>