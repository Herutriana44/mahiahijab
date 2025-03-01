<?php
include('../includes/auth_session.php');
include('../includes/header.php');

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $conn->query("INSERT INTO products (name, price, stock, description) VALUES ('$name', '$price', '$stock', '$description')");
    header('Location: manage_products.php');
}

?>
<div class="container">
    <h1>Add New Product</h1>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit" name="add_product">Add Product</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
