<?php
// Database credentials
require_once 'db_connect.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert product data into the Products table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST["product_name"];
    $categoryId = $_POST["category_id"];
    $price = $_POST["price"];
    $stockQuantity = $_POST["stock_quantity"];
    $description = $_POST["description"];

    // Handle multiple image uploads
    $imagePaths = [];
    $targetDirectory = "uploads/";

    // Iterate over each uploaded file
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmpName) {
        $imageName = $_FILES["images"]["name"][$key];
        $targetPath = $targetDirectory . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpName, $targetPath)) {
            // Store the image path in the array
            $imagePaths[] = $targetPath;
        }
    }

    // Convert the array of image paths to a comma-separated string
    $imagePathsString = implode(",", $imagePaths);

    // Insert data into the Products table
    $sql = "INSERT INTO products (product_name, category_id, price, stock_quantity, description, image_paths)
            VALUES ('$productName', $categoryId, $price, $stockQuantity, '$description', '$imagePathsString')";

    if ($conn->query($sql) === TRUE) {
        header("Location: add_product.php");
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
