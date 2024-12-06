<?php
// Database configuration
$host = 'localhost';
$dbname = 'job_applications'; // Database name
$username = 'root';           // Default MySQL username for XAMPP
$password = '';               // Default MySQL password (usually blank)

// Create a connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone_number = htmlspecialchars(trim($_POST['number']));
    $role = strtolower(htmlspecialchars(trim($_POST['role'])));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    $errors = [];
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($phone_number)) $errors[] = "Phone number is required.";
    if (empty($role) || !in_array($role, ['employee', 'employeer'])) $errors[] = "Role is invalid.";
    if (empty($message)) $errors[] = "Message is required.";

    // If no errors, insert data into the database
    if (empty($errors)) {
        try {
            // Prepare SQL statement
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone_number, role, message) 
                                   VALUES (:name, :email, :phone_number, :role, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':message', $message);

            // Execute the statement
            $stmt->execute();

            // Redirect to the thank-you page after successful submission
            header("Location: thank_you.html");
            exit();
        } catch (PDOException $e) {
            // Display database error
            echo "<div class='message-error'>Database error: " . $e->getMessage() . "</div>";
        }
    } else {
        // Display validation errors
        echo "<div class='message-error'><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
    }
} else {
    // Redirect to the contact form if accessed directly
    header("Location: contact.html");
    exit();
}
?>
