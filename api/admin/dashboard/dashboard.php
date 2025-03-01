<?php
// Memulai sesi dan menghubungkan ke database
session_start();
require "../../koneksi.php";

// Mengatur header untuk JSON
header('Content-Type: application/json');

// Query untuk total pendapatan
$q3 = "SELECT SUM(jml_pembayaran) as jml FROM tbl_pembayaran";
$res3 = mysqli_query($db, $q3);
$dta3 = mysqli_fetch_assoc($res3);

// Query untuk total member
$q4 = "SELECT COUNT(id_pelanggan) as jml FROM tbl_pelanggan";
$res4 = mysqli_query($db, $q4);
$dta4 = mysqli_fetch_assoc($res4);

// Query untuk total produk
$q5 = "SELECT SUM(stok) as jml FROM tbl_produk";
$res5 = mysqli_query($db, $q5);
$dta5 = mysqli_fetch_assoc($res5);

// Query untuk total artikel
$q6 = "SELECT COUNT(id_pos) as jml FROM tbl_pos";
$res6 = mysqli_query($db, $q6);
$dta6 = mysqli_fetch_assoc($res6);

// Query untuk kategori produk
$q = "SELECT * FROM tbl_produk a JOIN tbl_kat_produk b ON a.id_kategori=b.id_kategori GROUP BY nm_kategori";
$res = mysqli_query($db, $q);

// Query untuk stok per kategori produk
$q2 = "SELECT SUM(stok) as jml FROM tbl_produk p JOIN tbl_kat_produk t ON p.id_kategori = t.id_kategori GROUP BY nm_kategori";
$res2 = mysqli_query($db, $q2);

// Menyiapkan data yang akan dikirim dalam JSON
$data = array();

// Menambahkan informasi tentang total pendapatan
$data['total_pendapatan'] = "Rp. " . number_format($dta3['jml']);

// Menambahkan informasi tentang total member
$data['total_member'] = number_format($dta4['jml']) . " Orang";

// Menambahkan informasi tentang total produk
$data['total_produk'] = number_format($dta5['jml']) . " Unit";

// Menambahkan informasi tentang total artikel
$data['total_artikel'] = number_format($dta6['jml']) . " Artikel";

// Menyiapkan kategori dan stok untuk grafik
$categories = array();
$stocks = array();

while ($row = mysqli_fetch_array($res)) {
	$categories[] = $row['nm_kategori'];
}

while ($row = mysqli_fetch_array($res2)) {
	$stocks[] = $row['jml'];
}

// Menambahkan data kategori dan stok produk
$data['stok_per_kategori'] = array(
	'labels' => $categories,
	'data' => array(
		array(
			'label' => 'Stok Produk',
			'data' => $stocks,
			'backgroundColor' => array(
				'rgba(255, 99, 132, 0.8)',
				'rgba(54, 162, 235, 0.8)',
				'rgba(255, 206, 86, 0.8)',
				'rgba(75, 192, 192, 0.8)',
				'rgba(153, 102, 255, 0.8)',
				'rgba(255, 159, 64, 0.8)'
			),
			'borderColor' => array(
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
			),
			'borderWidth' => 3
		)
	)
);

// Mengirimkan data JSON ke client
echo json_encode($data);
?>