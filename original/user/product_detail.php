<?php include('../includes/header.php'); ?>
<?php
$product_id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id='$product_id'");
$product = $result->fetch_assoc();
?>
<div class="container">
    <h1><?= $product['name'] ?></h1>
    <img src="../images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    <p><?= $product['description'] ?></p>
    <p>Price: $<?= $product['price'] ?></p>
    <form action="cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" value="1">
        <button type="submit" class="btn">Add to Cart</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>
