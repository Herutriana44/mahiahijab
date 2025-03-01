<?php
// Include file koneksi ke database
require_once "../koneksi.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Mengizinkan akses dari semua domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Izinkan metode GET dan POST
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Izinkan header tertentu

// Menyiapkan response array
$response = array();

// Ambil ID order dari URL
$id = $_POST['id'];

// Query untuk mengambil total_order berdasarkan id_order
$query = "SELECT total_order FROM tbl_order WHERE id_order='$id'";
$result = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($result);

// Proses konfirmasi pembayaran

$nama = $_POST['nama'];
$bank = $_POST['nmBank'];
$jml = $_POST['jml_transfer'];
$tgl = date('Y-m-d');

// Pastikan gambar Base64 ada
if (isset($_POST['gambar']) && !empty($_POST['gambar'])) {
    $gambarBase64 = $_POST['gambar'];  // Gambar yang diterima dalam format Base64

    // Validasi jumlah pembayaran
    if ($jml != $data['total_order']) {
        // Mengirimkan respon gagal jika jumlah pembayaran tidak sesuai
        $response['status'] = 'error';
        $response['message'] = 'Jumlah Yang Anda Bayarkan Tidak Sesuai';
    } else {
        // Mengonversi Base64 ke file gambar
        $fileName = uniqid() . '.png';  // Nama file gambar yang unik
        $uploadDir = "../assets/img/bukti-transfer/";
        $filePath = $uploadDir . $fileName;

        // Menghapus prefix 'data:image/png;base64,' jika ada
        if (preg_match('/^data:image\/(\w+);base64,/', $gambarBase64, $type)) {
            $gambarBase64 = substr($gambarBase64, strpos($gambarBase64, ',') + 1);
        }

        // Mengubah Base64 menjadi file gambar
        if (file_put_contents($filePath, base64_decode($gambarBase64))) {
            // Menyimpan data pembayaran ke tabel tbl_pembayaran
            $queryInsert = "INSERT INTO tbl_pembayaran (id_order, nm_pembayar, nm_bank, jml_pembayaran, tgl_bayar, bukti_transfer)
                                VALUES ('$id', '$nama', '$bank', '$jml', '$tgl', '$fileName')";
            $exec = mysqli_query($db, $queryInsert);

            if ($exec) {
                // Mengubah status order menjadi 'Sudah Dibayar'
                $queryUpdate = "UPDATE tbl_order SET status='Sudah Dibayar' WHERE id_order='$id'";
                mysqli_query($db, $queryUpdate);

                // Mengirimkan respon sukses
                $response['status'] = 'success';
                $response['message'] = 'Produk Segera Kami Persiapkan Untuk Dikirim';
            } else {
                // Jika insert pembayaran gagal
                $response['status'] = 'error';
                $response['message'] = 'Terjadi kesalahan saat memproses pembayaran.';
            }
        } else {
            // Jika Base64 gagal dikonversi ke file
            $response['status'] = 'error';
            $response['message'] = 'Gagal menyimpan gambar bukti transfer.';
        }
    }
} else {
    // Jika gambar Base64 tidak ditemukan
    $response['status'] = 'error';
    $response['message'] = 'Gambar bukti transfer tidak ditemukan.';
}


// Menutup koneksi database
mysqli_close($db);

// Mengirimkan respon dalam format JSON
echo json_encode($response);
?>