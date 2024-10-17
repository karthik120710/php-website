<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Database connection details
$servername="localhost";
$username="root";
$password="";
$dbname="users";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['firstname']) || !isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// session variables
$username = $_SESSION['firstname'];
$email = $_SESSION['email'];

//  delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $productIdToDelete = $_POST['delete'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productIdToDelete);
    $stmt->execute();
    $stmt->close();
}

//  edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $productIdToEdit = $_POST['edit'];
    $newDescription = $_POST['description'];
    $newCategory = $_POST['category'];

    $sql = "UPDATE products SET description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $newDescription, $newCategory, $productIdToEdit);
    $stmt->execute();
    $stmt->close();
}

// add request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $newDescription = $_POST['new_description'];
    $newCategory = $_POST['new_category'];

    $sql = "INSERT INTO products (description, category) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newDescription, $newCategory);
    $stmt->execute();
    $stmt->close();
}

// Fetch products from the database
$sql = "SELECT id, description, category FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="container">
        <h2>Product Management</h2>

        <form method="POST" action="homepage.php">
            <input type="text" name="new_description" placeholder="New description" required>
            <select name="new_category">
                <option value="Essentials">Essentials</option>
                <option value="Cosmetics">Cosmetics</option>
                <option value="Fashion">Fashion</option>
            </select>
            <input type="submit" name="add" value="Add Product">
        </form>

        <div class="products">
            <?php if (count($products) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['description']; ?></td>
                                <td><?php echo $product['category']; ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="edit" value="<?php echo $product['id']; ?>">
                                        <input type="text" name="description" placeholder="New description" required>
                                        <select name="category">
                                            <option value="Essentials">Essentials</option>
                                            <option value="Cosmetics">Cosmetics</option>
                                            <option value="Fashion">Fashion</option>
                                        </select>
                                        <button type="submit">Edit</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="delete" value="<?php echo $product['id']; ?>">
                                        <button type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <style>
       

body {

    font-family: Arial, sans-serif;

    margin: 0;

    padding: 0;

}

.header {

    background-color: #4CAF50;

    color: white;

    padding: 10px;

    display: flex;

    justify-content: space-between;

    align-items: center;

}

.logout-button {

    color: white;

    text-decoration: none;

    padding: 10px 15px;

    background-color: #f44336;

    border-radius: 5px;

}

.container {

    padding: 20px;

}

.todos {

    margin-top: 20px;

}

.todo {

    border: 1px solid #ccc;

    margin: 10px 0;

    padding: 10px;

    display: flex;

    justify-content: space-between;

    align-items: center;

}
        .products {
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</body>
</html>