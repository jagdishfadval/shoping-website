<?php
// Start the session
session_start();

include 'db_connect.php';
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the order ID is provided in the URL
if (!isset($_GET["order_id"])) {
    // Redirect back to the orders page if the order ID is not provided
    header("Location: orders.php");
    exit();
}

// Get the order ID from the URL
$order_id = $_GET["order_id"];

// Database connection details


// Prepare the SQL statement to delete the order
$sql = "DELETE FROM orders WHERE order_id = '$order_id'";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
    // Order deleted successfully
    header("Location: my_orders.php");
    exit();
} else {
    // Error occurred while deleting the order
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
