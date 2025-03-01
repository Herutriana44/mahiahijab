<?php include('../includes/header.php'); ?>
<div class="container">
    <h1>Products</h1>
    <?php
    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch_assoc()) { ?>
        <div class="product">
            <img src="../images/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
            <h2><?= $row['name'] ?></h2>
            <p>Price: $<?= $row['price'] ?></p>
            <p><?= $row['description'] ?></p>
            <a href="product_detail.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
        </div>
    <?php } ?>
</div>
<?php include('../includes/footer.php'); ?>
