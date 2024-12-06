<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="flex">
            <h1 class="logo">Admin Dashboard</h1>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </header>
    <section class="home-container">
        <div class="home">
            <h2>Welcome, <?= $_SESSION['admin_username']; ?>!</h2>
            <div class="category box-container">
                <div class="box">
                    <a href="manage_applicants.php">
                        <i class="fas fa-users"></i>
                        <h3>Manage Applicants</h3>
                    </a>
                </div>
                <div class="box">
                    <a href="manage_contacts.php">
                        <i class="fas fa-envelope"></i>
                        <h3>Manage Contacts</h3>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
