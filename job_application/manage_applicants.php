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

$query = $conn->query("SELECT * FROM applications");
$applicants = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Experience</th>
            <th>Qualifications</th>
            <th>Skills</th>
            <th>Resume</th>
            <th>Submission Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applicants as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['experience'] ?></td>
            <td><?= $row['qualifications'] ?></td>
            <td><?= $row['skills'] ?></td>
            <td><a href="<?= $row['resume_path'] ?>">View</a></td>
            <td><?= $row['submission_date'] ?></td>
            <td>
                <a href="edit_applicant.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_applicant.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<form method="POST" action="add_applicant.php">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="text" name="experience" placeholder="Experience">
    <input type="text" name="qualifications" placeholder="Qualifications">
    <input type="text" name="skills" placeholder="Skills">
    <input type="text" name="resume_path" placeholder="Resume Path">
    <button type="submit">Add Applicant</button>
</form>


