<?php
session_start();
include('../includes/config.php');

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    
    if ($result) {
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: home.php');
            exit();
        } else {
            $error = "Invalid login credentials";
        }
    } else {
        $error = "Query failed: " . $conn->error;
    }
}
?>
<div class="container">
    <h1>User Login</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <a href="forgot_password.php">Forgot Password?</a>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</div>
