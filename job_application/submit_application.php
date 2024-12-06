<?php
// Database configuration for XAMPP
$host = 'localhost';
$dbname = 'job_applications';  // The name of the database you created
$username = 'root';             // Default XAMPP MySQL username
$password = '';                 // Default XAMPP MySQL password (usually blank)

// Create a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $experience = intval($_POST['experience']);
    $qualifications = htmlspecialchars(trim($_POST['qualifications']));
    $skills = htmlspecialchars(trim($_POST['skills']));
    $resume = $_FILES['resume'];
    
    // Validate required fields
    $errors = [];
    if (empty($name)) $errors[] = "Full Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid Email is required.";
    if (empty($phone)) $errors[] = "Phone Number is required.";
    if (empty($experience) || $experience < 0) $errors[] = "Experience is required and must be a non-negative number.";
    if (empty($qualifications)) $errors[] = "Qualifications are required.";
    if (empty($skills)) $errors[] = "Skills are required.";
    if (empty($resume['name'])) $errors[] = "Resume is required.";

    // Process resume upload
    $file_path = '';
    if ($resume['error'] == 0) {
        $allowed_types = ['pdf', 'doc', 'docx'];
        $file_ext = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));

        // Check file extension
        if (!in_array($file_ext, $allowed_types)) {
            $errors[] = "Only PDF, DOC, and DOCX files are allowed.";
        } else {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create uploads directory if it doesn't exist
            }
            $file_path = $upload_dir . basename($resume['name']);
            if (!move_uploaded_file($resume['tmp_name'], $file_path)) {
                $errors[] = "Failed to upload resume.";
            }
        }
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        try {
            // Prepare an SQL statement
            $stmt = $pdo->prepare("INSERT INTO applications (name, email, phone, experience, qualifications, skills, resume_path) 
                                   VALUES (:name, :email, :phone, :experience, :qualifications, :skills, :resume_path)");
            // Bind parameters to the SQL query
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':qualifications', $qualifications);
            $stmt->bindParam(':skills', $skills);
            $stmt->bindParam(':resume_path', $file_path);

            // Execute the statement
            $stmt->execute();

            // Success message
            echo "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>
                    <h2 style='color: green;'>Application submitted successfully!</h2>
                    <p style='font-size: 16px;'>Thank you, <strong>$name</strong>, for applying. We will review your application and contact you at <strong>$email</strong>.</p>
                    <a href='apply_job.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Back to Job Application</a>
                  </div>";
        } catch (PDOException $e) {
            echo "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>
                    <h2 style='color: red;'>Error: Could not submit your application</h2>
                    <p style='font-size: 16px;'>An error occurred: " . $e->getMessage() . "</p>
                    <a href='apply_job.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Back to Job Application</a>
                  </div>";
        }
    } else {
        // Display errors
        echo "<div style='text-align: center; margin: 20px; font-family: Arial, sans-serif;'>
                <h2 style='color: red;'>There were errors with your submission:</h2>
                <ul style='color: red; text-align: left; display: inline-block;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "  </ul>
                <a href='apply_job.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Back to Job Application</a>
              </div>";
    }
} else {
    // Redirect to the form if accessed directly
    header("Location: apply_job.html");
    exit();
}
?>
