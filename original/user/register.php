<?php
include('../includes/config.php');

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];

    $conn->query("INSERT INTO users (full_name, email, password, phone_number, address, date_of_birth)
                  VALUES ('$full_name', '$email', '$password', '$phone_number', '$address', '$date_of_birth')");

    header('Location: login.php');
}
?>
<div class="container">
    <h1>Register</h1>
    <form method="POST" action="">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone_number" placeholder="Phone Number" required>
        <textarea name="address" placeholder="Address" required></textarea>
        <input type="date" name="date_of_birth" required>
        <button type="submit" name="register">Register</button>
    </form>
</div>
