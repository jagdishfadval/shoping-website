<?php
session_start(); // Make sure to call this at the beginning of each page that requires access control

if (!isset($_SESSION["admin_login"])) {
    // Redirect the user or display an error message
    header("Location: index.php");
    exit();
}
// if ($_SESSION['role'] !== 'admin') {
//     // Redirect the user or display an error message
//     header("Location: unauthorized.php");
//     exit();
// }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attire Home</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link rel = "stylesheet" href = "bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel = "stylesheet" href = "css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }
        .pro_container{
            margin-top:10vw;
        }

        .product-item {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .product-item h3 {
            margin-top: 0;
        }

        .product-item p {
            margin: 0;
        }

        .product-actions {
            margin-top: 10px;
        }

        .product-actions a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }

        .product-actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="pro_container">
 <?php
// Include the navigation bar
include 'admin_nav.php';
?> 

<?php

require_once 'db_connect.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h2>Product List</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item'>";
        echo "<h3>".$row['product_name']."</h3>";
        echo "<p>Price: ".$row['price']."</p>";
        echo "<p>Stock Quantity: ".$row['stock_quantity']."</p>";
        echo "<p>Description: ".$row['description']."</p>";
        echo "<div class='product-actions'>";
        echo "<a href='update_product.php?id=".$row['product_id']."&category_id=".$row['category_id']."'>Edit</a>";
        echo "<a href='delete_product.php?id=".$row['product_id']."'>Delete</a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No products found.</p>";
}

$conn->close();
?>
</body>
</html>
