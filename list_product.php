<?php
// Database credentials
require_once 'db_connect.php';
// Fetch product data from the Products table
$sql = "SELECT product_name, image_paths FROM Products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row["product_name"];
        $imagePaths = explode(",", $row["image_paths"]);
        $firstImagePath = $imagePaths[0]; // Get the first image path

        // Display the product information
        echo '<div>';
        echo '<h3>' . $productName . '</h3>';
        echo '<img src="' . $firstImagePath . '" alt="' . $productName . '">';
        echo '</div>';
    }
} else {
    echo 'No products found.';
}

$conn->close();
?>
