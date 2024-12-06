<?php
// Retrieve user data from the query parameters
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'User';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : 'your email';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add the same styles here as before */
    </style>
</head>
<body>
    <div class="container">
        <h1>Application submitted successfully!</h1>
        <p>Thank you, <span><?php echo strtoupper($name); ?></span>, for applying. We will review your application and contact you at <span><?php echo $email; ?></span>.</p>
        <a href="job_application_form.html">Back to Job Application</a>
    </div>
</body>
</html>
