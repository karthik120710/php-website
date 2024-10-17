<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password_db = ""; 
$dbname = "users";

$data = mysqli_connect($host, $user, $password_db, $dbname);
if ($data == false) {
    die("Connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // print_r($_POST);
    // exit;
    $email = $_POST["email"]; 
    $password = $_POST["password"];

    // Hash Password using Md5
    $hashed_password = md5($password);

    $stmt = $data->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Compare the hashed password
        if ($hashed_password === $row["password"]) {
            echo "Login successful!";
            $_SESSION['firstname'] = $row["firstname"];
            $_SESSION['email'] = $row["email"]; 
            $_SESSION['role'] = $row["role"];

            //check session stored properly
            // var_dump($_SESSION); 
            // exit();

            header("Location: homepage.php"); 
            exit();
        } else {
            echo "Invalid email or password."; 
        }
    } else {
        echo "No user found with that email."; 
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
        <form action="index.php" method="post">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" required>
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
