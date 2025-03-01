<?php
include('../includes/config.php');

if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $conn->query("UPDATE users SET reset_token='$token', reset_expires='$expires' WHERE email='$email'");
        echo "Reset link: <a href='reset_password.php?token=$token'>Reset Password</a>";
    } else {
        echo "Email not found";
    }
}
?>
<div class="container">
    <h1>Forgot Password</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="forgot_password">Submit</button>
    </form>
</div>
