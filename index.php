<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password_db = ""; // Database password
$dbname = "users";

$data = mysqli_connect($host, $user, $password_db, $dbname);
if ($data == false) {
    die("Connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the provided password using MD5
    $hashed_password = md5($password);

    $stmt = $data->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Compare the hashed password
        if ($hashed_password === $row["password"]) {
            // Successful login
            echo "Login successful!";
            // Redirect or perform actions based on user type
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="./style.css"> 
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="#" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="button-group">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="register-link">
            <p><a href="./register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>

