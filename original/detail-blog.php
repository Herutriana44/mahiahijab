<?php require "header.php"; ?>

<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        padding: 0;
        margin: 0;
    }

    .img .box {
        height: 250px;
        background-color: rgba(41, 41, 41, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: white;
        padding-top: 70px;
    }

    .sosmed {
        display: flex;
        justify-content: center;
        padding: 0;
    }

    .sosmed-items {
        color: #fff;
        width: 120px;
        height: 120px;
        font-size: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin: 0;
    }

    .follower {
        margin-top: 20px;
        font-size: 13px;
    }

    .status {
        font-weight: bold;
        font-size: 17px;
    }

    .sosmed-items:hover {
        background-color: black;
    }

    .bg1 {
        background-color: #3b5998;
    }

    .bg1:hover {
        color: #3b5998;
    }

    .bg2 {
        background-color: #1da1f2;
    }

    .bg2:hover {
        color: #1da1f2;
    }

    .bg3 {
        background-color: #ea4335;
    }

    .bg3:hover {
        color: #ea4335;
    }

    .list-group li {
        border: none;
        padding: 0;
    }
</style>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM tbl_pos WHERE id_pos='$id'";
$result = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($result);
$tgl = $data['tgl'];
?>

<div class="banner mb-5">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>BLOG</h3>
            <p>Home > <a href="blog.php" style="text-decoration: none; color: white;">Blog</a> > 
                <a href="" class="text-primary" style="text-decoration: none;"><?php echo $data['judul']; ?></a> 
            </p>
        </div>
    </div>
</div>

<div class="contain">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="judul">
                    <h2><?php echo $data['judul']; ?></h2>
                </div>
                <hr width="20%" align="left">
                <div class="sub mb-3">
                    Penulis: <span class="text-primary">Admin</span> | 
                    <i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($tgl)); ?>
                </div>
                <div class="gambar mb-4">
                    <img src="admin/assets/images/foto_pos/<?php echo $data['gambar']; ?>" alt="" width="100%" height="430px">
                </div>
                <div class="isi text-justify">
                    <?php echo $data['isi']; ?>
                </div>
            </div>

            <div class="col-md-4 mt-5">
                <div class="row mt-5">
                    <div class="col">
                        <h5>IKUTI KAMI</h5>
                        <hr align="left" width="20%">
                        <div class="sosmed mb-5">
                            <div class="sosmed-items bg1">
                                <i class="fa fa-facebook"></i>
                                <div class="follower">56 K</div>
                                <div class="status">FANS</div>
                            </div>
                            <div class="sosmed-items bg2">
                                <i class="fa fa-twitter"></i>
                                <div class="follower">1.5 M</div>
                                <div class="status">FOLLOWER</div>
                            </div>
                            <div class="sosmed-items bg3">
                                <i class="fa fa-google"></i>
                                <div class="follower">13 K</div>
                                <div class="status">FOLLOWER</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
