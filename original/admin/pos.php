<?php require '../koneksi.php'; ?>

<!-- Lihat Data Produk -->
<?php
$query = "SELECT * FROM tbl_pos p JOIN tbl_kat_pos k ON p.id_kategori=k.id_kategori";
$result = mysqli_query($db, $query);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryHapus = "DELETE FROM tbl_pos WHERE id_pos='$id'";
    if (mysqli_query($db, $queryHapus)) {
        echo "<script>alert('Postingan sudah dihapus');</script>";
        echo "<script>location='index.php?pages=pos';</script>";
    }
}

if (isset($_GET['id_kategori'])) {
    $idKategori = $_GET['id_kategori'];
    $queryHapusKategori = "DELETE FROM tbl_kat_pos WHERE id_kategori='$idKategori'";
    if (mysqli_query($db, $queryHapusKategori)) {
        echo "<script>alert('Kategori sudah dihapus');</script>";
        echo "<script>location='index.php?pages=kategori-pos';</script>";
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tgl Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($data = mysqli_fetch_array($result)) : ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['judul']; ?></td>
                            <td><?php echo $data['nm_kategori']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($data['tgl'])); ?></td>
                            <td>
                                <a href="index.php?pages=ubah-pos&id=<?php echo $data['id_pos']; ?>" class="m-r-15 text-muted" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil font-18"></i></a>
                                <a href="index.php?pages=pos&id=<?php echo $data['id_pos']; ?>" class="text-muted" data-toggle="tooltip" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan tersebut?')"><i class="mdi mdi-close font-18"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


