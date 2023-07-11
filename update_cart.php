<?php
// Establish a database connection
include 'db_connect.php';

// Retrieve the action and cart ID from the URL parameters
$action = $_GET['action'];
$cart_id = $_GET['cart_id'];

// Perform the action based on the provided value
if ($action === 'increase') {
    // Increase the quantity by 1
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = '$cart_id'";
    $conn->query($sql);
} elseif ($action === 'decrease') {
    // Decrease the quantity by 1 if it's greater than 0
    $sql = "UPDATE cart SET quantity = GREATEST(quantity - 1, 0) WHERE cart_id = '$cart_id'";
    $conn->query($sql);
} elseif ($action === 'remove') {
    // Remove the product from the cart
    $sql = "DELETE FROM cart WHERE cart_id = '$cart_id'";
    $conn->query($sql);
}

header("Location: cart.php");
exit();
// Close the database connection
$conn->close();

// Redirect back to the cart page
?>