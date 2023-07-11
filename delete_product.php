<?php
// Check if the product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Include the database connection file
    require_once 'db_connect.php';

    // Delete the product from the database
    $sql = "DELETE FROM products WHERE product_id = '$productId'";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid product ID";
}
?>
