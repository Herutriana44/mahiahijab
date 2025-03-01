<?php require "header.php"; ?>
<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        background-size: cover; /* Ensure the background image covers the container */
        background-position: center; /* Center the background image */
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
        text-align: center; /* Center text */
    }

    .box .titleBanner:hover {
        text-decoration: none;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row a {
        color: black;
    }

    .row a:hover {
        color: rgb(97, 97, 97);
        text-decoration: none;
    }

    hr {
        width: 100px;
        margin: 20px auto;
    }

    .sosmed {
        height: auto;
        display: flex;
        flex-direction: row;
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .sosmed-items {
        color: #fff;
        width: 120px;
        height: 120px;
        font-size: 30px;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .follower {
        margin-top: 20px;
        font-weight: normal;
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
        padding-left: 0;
        padding-right: 0;
    }

    /* Style for images with rounded corners */
    .imgup {
        overflow: hidden;
        border-radius: 15px; /* Rounded corners */
        height: 280px; /* Fixed height */
        width: 100%; /* Full width */
    }

    .imgup img {
        border-radius: 15px; /* Rounded corners for images */
        width: 100%;
        height: 100%; /* Cover the container */
        object-fit: cover; /* Maintain aspect ratio */
    }

    /* Article content styling */
    .article-content {
        text-align: center;
    }

    .article-title {
        font-weight: bold;
        margin-top: 10px;
    }

    .article-date {
        font-size: 13px;
        color: #777;
        margin-top: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-md-4, .col-md-8 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 10px;
        }

        .imgup {
            height: auto; /* Adjust image height for smaller screens */
        }
    }
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>BLOG</h3>
            <p>Home > <a href="#" class="text-primary">Blog</a></p>
        </div>
    </div>
</div>

<div class="container bg-white rounded pt-4">
    <!-- Atas -->
    <div class="row text-center mb-5">
        <?php
            $query="SELECT * FROM tbl_pos ORDER BY judul asc LIMIT 3";
            $result=mysqli_query($db,$query);
            while ($data = mysqli_fetch_array($result)) {
                $tgl = $data['tgl'];
        ?>
        <div class="col-md-4 col-sm-12">
            <div class="imgup mb-2">
                <img src="admin/assets/images/foto_pos/<?php echo $data['gambar'];?>" alt="...">
            </div>
            <div class="article-content">
                <h5 class="article-title">
                    <a href="detail-blog.php?id=<?php echo $data['id_pos'] ?>" class="font-weight-bold"><?php echo $data['judul']; ?></a>
                </h5>
                <hr>
                <p class="article-date"><i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($tgl)); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
    <!-- Tengah -->
    <div class="row text-left mb-5">
        <?php
            $query="SELECT * FROM tbl_pos a JOIN tbl_kat_pos m ON a.id_kategori=m.id_kategori WHERE nm_kategori='Desain Ruang Tamu' ORDER BY Gambar asc LIMIT 1";
            $result=mysqli_query($db,$query);
            while ($data = mysqli_fetch_array($result)) {
                $tgl = $data['tgl'];
        ?>
        <div class="col-md-8 col-sm-12">
            <h4 class="font-weight-bold"><span class="text-success">ARTIKEL</span> FAVORIT</h4>
            <hr alighn="left">
            <div class="imgup mb-2">
                <img src="admin/assets/images/foto_pos/<?php echo $data['gambar'];?>" alt="...">
            </div>
            <div class="article-content">
                <h5 class="article-title">
                    <a href="detail-blog.php?id=<?php echo $data['id_pos'] ?>" class="font-weight-bold"><?php echo $data['judul']; ?></a>
                </h5>
                <hr alighn="left">
                <p class="article-date"><i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($tgl)); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php require "footer.php"; ?>
