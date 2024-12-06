<?php
session_start();
$host = 'localhost';
$db = 'job_applications';
$user = 'root'; // Replace with your DB username
$pass = ''; // Replace with your DB password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
$username = $_POST['username'];
$password = md5($_POST['password']); // Use MD5 for now, replace with a secure method like bcrypt in production.

$query = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
$query->execute([$username, $password]);

$admin = $query->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    header('Location: dashboard.php');
} else {
    echo "<script>alert('Invalid credentials'); window.location.href='index.php';</script>";
}
?>
