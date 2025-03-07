<?php
// Memulai sesi dan menghubungkan ke database
session_start();
include "../../koneksi.php";

// Mengatur header untuk JSON
header('Content-Type: application/json');

// Mengecek apakah parameter GET `username` dan `password` tersedia
if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Menjalankan query untuk mencari username dan password yang cocok
    $stmt = $db->prepare("SELECT * FROM tbl_admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Mengecek hasil dari query
    if ($user) {
        $_SESSION['tbl_admin'] = $user;

        // Mengirimkan response sukses dalam format JSON
        echo json_encode([
            "success" => true,
            "message" => "Login Berhasil",
            "data" => $user
        ]);
    } else {
        // Jika login gagal
        echo json_encode([
            "success" => false,
            "message" => "Login Gagal. Username atau password salah"
        ]);
    }
} else {
    // Jika parameter GET tidak lengkap
    echo json_encode([
        "success" => false,
        "message" => "Username dan password harus diisi"
    ]);
}
?>