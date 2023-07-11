<?php
session_start();

require_once 'db_connect.php';

if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}


// Check if the product ID is provided
// Retrieve the product ID from the form submission
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Query the database to fetch the product details
    $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $name = $product['product_name'];
        $price = $product['price'];

        // Assuming you have the user ID stored in a session variable
        $user_id = $_SESSION['user_id'];

        // Store the product in the cart table
        $insertSql = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES ('$user_id', '$product_id', 1, '$price')";
        if ($conn->query($insertSql) === TRUE) {
            header("Location: cart.php");
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();


?>