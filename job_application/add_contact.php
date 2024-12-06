<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

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

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$role = $_POST['role'];
$message = $_POST['message'];

// Insert into database
$query = $conn->prepare("INSERT INTO contacts (name, email, phone_number, role, message) VALUES (?, ?, ?, ?, ?)");
$query->execute([$name, $email, $phone_number, $role, $message]);

// Redirect to manage_contacts.php
header('Location: manage_contacts.php');
?>
