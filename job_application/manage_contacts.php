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

// Fetch all contacts
$query = $conn->query("SELECT * FROM contact_messages");
$contacts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts</title>
    
</head>
<body>
    <header class="header">
        <div class="flex">
            <h1 class="logo">Manage Contacts</h1>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </header>
    <section class="home-container">
        <div class="home">
            <h2>Contacts</h2>
            
            <!-- Contacts Table -->
            <table border="1" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Message</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone_number'] ?></td>
                        <td><?= $row['role'] ?></td>
                        <td><?= $row['message'] ?></td>
                        <td><?= $row['submission_date'] ?></td>
                        <td>
                            <a href="edit_contact.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                            <a href="delete_contact.php?id=<?= $row['id'] ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Add Contact Form -->
            <h3>Add New Contact</h3>
            <form method="POST" action="add_contact.php" class="form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required class="input">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required class="input">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" required class="input">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" name="role" placeholder="Role" class="input">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Message" class="input"></textarea>
                </div>
                <button type="submit" class="btn">Add Contact</button>
            </form>
        </div>
    </section>
</body>
</html>
