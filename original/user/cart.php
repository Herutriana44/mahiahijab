<?php include('../includes/header.php'); ?>
<div class="container">
    <h1>Your Cart</h1>
    <?php
    if (!isset($_SESSION['cart'])) {
        echo "Your cart is empty.";
    } else {
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $result = $conn->query("SELECT * FROM products WHERE id='$id'");
            $product = $result->fetch_assoc();
            $total += $product['price'] * $quantity;
            ?>
            <div class="product">
                <h2><?= $product['name'] ?></h2>
                <p>Quantity: <?= $quantity ?></p>
                <p>Price: $<?= $product['price'] ?></p>
            </div>
        <?php } ?>
        <h2>Total: $<?= $total ?></h2>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    <?php } ?>
</div>
<?php include('../includes/footer.php'); ?>
