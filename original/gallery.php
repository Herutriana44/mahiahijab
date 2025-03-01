<?php require "header.php"; ?>
<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        background-size: cover; /* Ensure the background image covers the container */
        background-position: center; /* Center the background image */
        padding: 0px;
        margin: 0px;
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

    .container.bg-white.rounded {
        padding: 15px;
    }

    .row {
        margin: 0;
    }

    .col-md-4 {
        padding: 15px;
        display: flex;
        justify-content: center;
    }

    #box {
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border-radius: 15px; /* Rounded corners */
    }

    #box img {
        border-radius: 15px; /* Rounded corners for images */
        width: 100%;
        height: auto; /* Maintain aspect ratio */
        display: block;
    }

    #box::after {
        background-color: black;
        opacity: 0.8;
        position: absolute;
        overflow: hidden;
        top: 100%;
        bottom: 0;
        left: 3px;
        right: 3px;
        padding: 23px;
        content: attr(data-text);
        text-align: center;
        font-size: 14px;
        color: white;
        transition: 0.9s ease;
    }

    #box:hover::after {
        top: 75%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 10px;
        }
    }
</style>
<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>GALLERY</h3>
            <p>Home > <a href="gallery.php" class="text-primary">Gallery</a></p>
        </div>
    </div>
</div>

<div class="container bg-white rounded">
    <div class="row">
        <?php
                $query="SELECT * FROM tbl_produk ORDER BY id_produk desc";
                $result=mysqli_query($db,$query);
                while ($data = mysqli_fetch_array($result)) {
            ?>
        <div class="col-md-4" id="box" data-text="<?php echo $data['nm_produk']; ?>">
            <a href="detail-produk.php?id=<?php echo $data['id_produk'] ?>">
                <img src="admin/assets/images/foto_produk/<?php echo $data['gambar'];?>" alt="">
            </a>
        </div>
        <?php } ?>
    </div>
</div>
<?php require "footer.php"; ?>
