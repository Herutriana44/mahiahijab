<?php require "header.php"; ?>

<style>
    .carousel li {
        margin-bottom: 80px;
    }

    .carousel-caption {
        margin-bottom: 250px;
    }

    .filters {
        margin-top: -50px;
    }

    .filters .filter-box {
        width: 100%;
        height: auto;
        border-radius: 10px;
        background-color: rgb(231, 231, 231);
        box-shadow: 0 4px 8px 0 rgba(98, 98, 98, 0.8), 0 6px 20px 0 rgba(100, 100, 100, 0.6);
        position: relative;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row>[class^="col-"] {
        padding-left: 3px;
        padding-right: 3px;
        margin-bottom: 6px;
    }

    .banner .img {
        width: 100%;
        padding: 0px;
        margin: 0px;
    }

    .img .box {
        background-color: rgb(41, 41, 41, 0.7);
    }

    #box,
    #box-b {
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    #box::after {
        background-color: black;
        opacity: 0.8;
        position: absolute;
        top: 100%;
        bottom: 0;
        left: 3px;
        right: 3px;
        padding: 15px;
        content: attr(data-text);
        text-align: center;
        font-size: 14px;
        color: white;
        transition: 0.9s ease;
    }

    #box-b::after {
        background-color: black;
        opacity: 0.8;
        position: absolute;
        top: 100%;
        bottom: 0;
        left: 3px;
        right: 3px;
        padding: 25px;
        content: attr(data-text);
        text-align: center;
        font-size: 14px;
        color: white;
        transition: 0.9s ease;
    }

    #box:hover::after,
    #box-b:hover::after {
        top: 75%;
    }

    .item:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 3px 10px 0 rgba(0, 0, 0, 0.4);
    }

    .latest-articles-section {
        padding: 50px 0;
        background-color: #f8f9fa;
    }

    .article-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .article-card:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .article-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
    }

    .card-title {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 14px;
        color: #6c757d;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="assets/img/20.jpg" alt="First slide" height="615px">
            <div class="carousel-caption"></div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="assets/img/7.jpeg" alt="Second slide" height="615px">
            <div class="carousel-caption"></div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="assets/img/13.jpg" alt="Third slide" height="615px">
            <div class="carousel-caption"></div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="filters">
    <div class="container filter-box">
        <div class="row pt-4">
            <div class="col-12">
                <form action="">
                    <div class="input-group">
                        <input class="form-control" type="text" name="select" placeholder="Search" style="border-radius: 4px;">
                        <span class="input-group-btn ml-2">
                            <button class="btn btn-primary pl-5 pr-5" type="submit" name="cari" id="addressSearch">Cari</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <hr>
    </div>
</div>

<div class="container mt-5 bg-white rounded">
    <div class="atas">
        <div class="row mb-4">
            <div class="col-12 text-secondary">
                <?php 
                if (isset($_GET['select'])) {
                    $cari = $_GET['select'];
                    echo "<h4><i>Hasil pencarian : ".$cari."</i></h4>";
                }
                ?>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <?php
            if (isset($_GET['select'])) {
                $cari = $_GET['select'];
                $query = "SELECT * FROM tbl_pos WHERE judul LIKE '%".$cari."%' ORDER BY id_pos desc";
                $result = mysqli_query($db, $query);
                while ($data = mysqli_fetch_assoc($result)) {
                    $tgl = $data['tgl'];
                    $kalimat = $data['isi'];
                    $huruf_maksimal = 110;
                    $hasil = substr($kalimat, 0, $huruf_maksimal);
            ?>
            <div class="col-md-6 p-3">
                <div class="">
                    <img src="admin/assets/images/foto_pos/<?php echo $data['gambar']; ?>" height="320px" width="100%" alt="...">
                </div>
                <h5 class="mt-2">
                    <a href="detail-postingan.php?id=<?php echo $data['id_pos'] ?>" class="font-weight-bold text-dark" style="text-decoration: none;"><?php echo $data['judul']; ?></a>
                </h5>
                <hr alighn="left" class="mb-1" style="width: 20%;">
                <p class="font-weight-normal" style="font-size: 13px;"><i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($tgl)); ?></p>
                <div class="text-justify"><?php echo $hasil.' . . .'; ?></div>
            </div>
            <?php }} ?>
        </div>

        <!-- Latest Articles Section -->
        <div class="latest-articles-section">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h3><span class="text-primary">ARTIKEL </span>TERBARU</h3>
                        <p>"Hai, selamat datang di Mahiahijab! Yuk, belanja puas dan tampil kekinian. Kita selalu update tren terbaru buat kamu yang stylish."</p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $query = "SELECT * FROM tbl_pos ORDER BY id_pos desc LIMIT 8";
                    $result = mysqli_query($db, $query);
                    while ($data = mysqli_fetch_array($result)) {
                        $judul = $data['judul'];
                        $judul_maksimal = 30;
                        $hasil2 = substr($judul, 0, $judul_maksimal);
                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="article-card" id="box" data-text="<?php echo $hasil2.' . . .'; ?>">
                            <a href="detail-blog.php?id=<?php echo $data['id_pos'] ?>">
                                <img src="admin/assets/images/foto_pos/<?php echo $data['gambar']; ?>" alt="<?php echo $hasil2; ?>">
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
