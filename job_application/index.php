<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="home-container">
        <div class="home">
            <form action="login_process.php" method="POST">
                <h3>Admin Login</h3>
                <input type="text" name="username" placeholder="Username" required class="input">
                <input type="password" name="password" placeholder="Password" required class="input">
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </section>
</body>
</html>
