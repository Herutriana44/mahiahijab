<?php require "header.php"; ?>

<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        background-size: cover;
        background-position: center;
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
        padding: 70px 15px; /* Added horizontal padding */
        text-align: center;
    }

    .box a {
        color: #0066FF;
    }

    .box a:hover {
        text-decoration: none;
        color: rgb(6, 87, 209);
    }

    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .col-sm-8, .col-sm-4 {
        padding: 15px;
    }

    .col-sm-4 img {
        width: 100%;
        height: auto;
        border-radius: 8px; /* Optional: Add some border radius to the image */
    }

    @media (max-width: 768px) {
        .img .box {
            height: auto;
            padding: 50px 15px; /* Adjust padding for smaller screens */
        }

        .row {
            flex-direction: column;
        }

        .col-sm-8, .col-sm-4 {
            padding: 0;
        }

        .col-sm-4 img {
            height: auto;
        }
    }
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>ABOUT US</h3>
            <p>Home > <a href="#">About Us</a></p>
        </div>
    </div>
</div>

<div class="container bg-white rounded pt-4 pb-4">
    <div class="row">
        <div class="col-sm-8">
            <h4>About Us Mahiahijab</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit labore officia iste nemo placeat quo tempora dolorum magnam similique? Voluptas mollitia autem corrupti laudantium iure laborum quia doloremque enim facere.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit labore officia iste nemo placeat quo tempora dolorum magnam similique? Voluptas mollitia autem corrupti laudantium iure laborum quia doloremque enim facere. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit labore officia iste nemo placeat quo tempora dolorum magnam similique? Voluptas mollitia autem corrupti laudantium iure laborum quia doloremque enim facere.</p>
        </div>
        <div class="col-sm-4">
            <img src="assets/img/14.jpg" alt="Furniture Image">
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
