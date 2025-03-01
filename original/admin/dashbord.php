<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];
$result = $conn->query("SELECT * FROM admin_users WHERE id='$admin_id'");
$admin = $result->fetch_assoc();
?>
<div class="container">
    <h1>Welcome, <?= $admin['email'] ?>!</h1>
    <nav>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>
