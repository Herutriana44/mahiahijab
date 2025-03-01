<?php
include('../includes/auth_session.php'); // Check if admin is logged in
include('../includes/header.php');

// Fetch all products
$products = $conn->query("SELECT * FROM products");

?>
<div class="container">
    <h1>Manage Products</h1>
    <a href="add_product.php" class="btn">Add New Product</a>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()) { ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn">Edit</a>
                        <form method="POST" action="" style="display:inline-block;">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" name="delete_product" class="btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
// Delete a product
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $conn->query("DELETE FROM products WHERE id='$product_id'");
    header('Location: manage_products.php');
}

include('../includes/footer.php');
?>
