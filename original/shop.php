<?php require "header.php"; ?>

<style>
    .banner .img {
        width: 100%;
        height: auto;
        background-image: url('assets/img/4.jpg');
        background-size: cover;
        background-position: center;
    }

    .img .box {
        height: auto;
        background-color: rgba(41, 41, 41, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: white;
        padding: 30px 0;
    }

    .box a {
        color: #0066FF;
    }

    .box a:hover {
        text-decoration: none;
        color: rgb(6, 87, 209);
    }

    .atas .card {
        padding: 1px;
        border: 1px solid silver;
    }

    .atas .card:hover {
        border: none;
    }

    .item {
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .item:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.4);
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 10px;
    }

    .thumnail {
        position: relative;
        height: 200px; /* Fixed height for image container */
        overflow: hidden;
    }

    .thumnail img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Crop and cover the image container */
    }

    .star-rating {
        position: absolute; 
        top: 7px; 
        right: 10px; 
        font-size: 10px;
    }

    @media (max-width: 768px) {
        .img .box {
            padding-top: 50px;
        }

        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .card-body {
            padding-bottom: 10px;
        }

        .text-secondary {
            font-size: 14px;
        }

        .star-rating {
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .banner .img {
            height: 150px;
        }

        .img .box {
            padding-top: 20px;
        }

        .col-md-12, .col-lg-4, .col-lg-8, .col-xl-3, .col-xl-9 {
            padding: 0;
        }

        .card-body {
            padding-bottom: 5px;
        }

        .text-secondary {
            font-size: 12px;
        }
    }
</style>

<div class="banner mb-5">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>SHOP</h3>
            <p>Home > <a href="#">Shop</a></p>
        </div>
    </div>
</div>

<div class="container">
    <?php 
    if (isset($_GET['kategori'])) {
        $kategori = $_GET['kategori'];
        $query = "SELECT * FROM tbl_produk WHERE id_kategori='$kategori'";
    } elseif (isset($_GET['select'])) {
        $cari = $_GET['select'];
        $query="SELECT * FROM tbl_produk WHERE nm_produk LIKE '%".$cari."%' ORDER BY id_produk ASC";
    } else {
        $query = "SELECT * FROM tbl_produk p JOIN tbl_kat_produk k ON p.id_kategori=k.id_kategori ORDER BY id_produk ASC";
    }
    ?>

    <div class="row">
        <div class="col-md-12 col-lg-4 col-xl-3">
            <div class="card pb-3">
                <div class="card-body" style="padding-bottom: 3px;">
                    <form class="form-group">
                        <h5>Cari:</h5>
                        <input class="form-control" type="search" name="select" placeholder="Search">
                    </form>
                    <hr class="text-center" width="80%">
                    <h5>Kategori:</h5>
                    <?php
                        $qkat = "SELECT * FROM tbl_kat_produk";
                        $reskat = mysqli_query($db, $qkat);
                        while ($dat = mysqli_fetch_assoc($reskat)) {
                    ?>
                    <a href="shop.php?kategori=<?php echo $dat['id_kategori'] ?>" class="text-secondary ml-3" name="kategori"><?php echo $dat['nm_kategori'] ?></a><br>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8 col-xl-9">
            <div class="row">
                <div class="col-md-12 pl-5 text-secondary">
                    <?php 
                    if (isset($_GET['select'])) {
                        $cari = $_GET['select'];
                        echo "<h4><i>Hasil pencarian : ".$cari."</i></h4>";
                    } elseif (isset($_GET['kategori'])) {
                        $cari = $_GET['kategori'];
                        $query2 = "SELECT * FROM tbl_kat_produk WHERE id_kategori='$cari'";
                        $results = mysqli_query($db, $query2);
                        $data = mysqli_fetch_assoc($results);
                        echo "<h4><i>Kategori : ".$data['nm_kategori']."</i></h4>";
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <?php
                $result = mysqli_query($db, $query);
                while ($produk = mysqli_fetch_assoc($result)) {
                ?>
                <div class="mb-0 p-1 col-md-6 col-lg-4 col-xl-3">
                    <div class="item card">
                        <div class="thumnail">
                            <img src="admin/assets/images/foto_produk/<?php echo $produk['gambar'];?>" alt="img" class="card-img-top">
                            <div class="star-rating">
                                <ul class="list-inline text-warning">
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star-o"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <strong><?php echo $produk['nm_produk']; ?></strong>
                            <h6 class="text-danger">Rp. <?php echo number_format($produk['harga']); ?></h6>
                            <a href="detail-produk.php?id=<?php echo $produk['id_produk']; ?>" class="btn btn-primary btn-sm btn-block mt-auto">Lihat Produk</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
