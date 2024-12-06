<?php
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

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$experience = $_POST['experience'];
$qualifications = $_POST['qualifications'];
$skills = $_POST['skills'];
$resume_path = $_POST['resume_path'];

$query = $conn->prepare("INSERT INTO applicants (name, email, phone, experience, qualifications, skills, resume_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
$query->execute([$name, $email, $phone, $experience, $qualifications, $skills, $resume_path]);

header('Location: manage_applicants.php');
?>
