<?php
// Database connection details

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername="localhost";
$username="root";
$password="";
$dbname="users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Only process the form if it has been submitted
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    // Validate that fields are not null
    if ($firstname && $lastname && $email && $password && $role) {
        // Hash the password using MD5 (consider using a stronger method in production)
        $password = md5($password);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="./mystyle.css">
</head>
<body>
<div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" value="Register">
        </form>
        <div class="back-link">
            <p><a href="index.html">Back to Home</a></p>
        </div>
    </div>
</body>
</html>
