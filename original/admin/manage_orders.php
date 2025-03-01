<?php
include('../includes/auth_session.php'); // Check if admin is logged in
include('../includes/header.php');

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders");

?>
<div class="container">
    <h1>Manage Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $orders->fetch_assoc()) { ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_id'] ?></td>
                    <td><?= $order['total_amount'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="status">
                                <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" name="update_order">Update</button>
                            <button type="submit" name="delete_order">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
// Update order status
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id='$order_id'");
    header('Location: manage_orders.php');
}

// Delete an order
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $conn->query("DELETE FROM orders WHERE id='$order_id'");
    header('Location: manage_orders.php');
}

include('../includes/footer.php');
?>
