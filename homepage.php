<?php
session_start(); 

// Check if the user is logged in by verifying if the session variables are set
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

// Accessing session variables
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Sample product data (this would normally come from a database)
$products = [
    [
        'name' => 'Product 1',
        'price' => '19.99',
        'image' => 'images/product1.jpg'
    ],
    [
        'name' => 'Product 2',
        'price' => '29.99',
        'image' => 'images/product2.jpg'
    ],
    [
        'name' => 'Product 3',
        'price' => '39.99',
        'image' => 'images/product3.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="container">
        <h2>Your Products</h2>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                </div>
            <?php endforeach; ?>
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
        .products {
            display: flex;
            flex-wrap: wrap;
        }
        .product {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            width: calc(33.333% - 40px); /* Three products per row */
            box-sizing: border-box;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</body>
</html>
