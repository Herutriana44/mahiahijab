<?php
include('../includes/config.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT * FROM users WHERE reset_token='$token' AND reset_expires > NOW()");
    $user = $result->fetch_assoc();

    if ($user) {
        if (isset($_POST['reset_password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET password='$password', reset_token=NULL, reset_expires=NULL WHERE reset_token='$token'");
            header('Location: login.php');
        }
    } else {
        echo "Invalid or expired token";
    }
}
?>
<div class="container">
    <h1>Reset Password</h1>
    <form method="POST" action="">
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</div>
