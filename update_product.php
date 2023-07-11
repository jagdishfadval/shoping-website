<?php
session_start();
require_once 'db_connect.php';

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // Redirect the user to the login page or display an error message
//     header("Location: login.php");
//     exit();
// }

// // Check if the product ID is provided in the query string
// if (!isset($_GET['id'])) {
//     // Redirect the user to the product list page or display an error message
//     header("Location: product_list.php");
//     exit();
// }

// Retrieve the product ID from the query string
$product_id = $_GET['id'];

// Check if the product exists in the database
$sql = "SELECT * FROM products WHERE product_id = '$product_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Product found, fetch its details
    $product = $result->fetch_assoc();
} else {
    // Product not found, redirect the user to the product list page or display an error message
    header("Location: product_list.php");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated product details from the form
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];

    // Update the product in the database
    $sql = "UPDATE products SET
                product_name = '$product_name',
                category_id = '$category_id',
                price = '$price',
                stock_quantity = '$stock_quantity',
                description = '$description'
            WHERE product_id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        // Product updated successfully
        echo "Product updated successfully.";
    } else {
        // Error occurred while updating the product
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>

    <form action="" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" value="<?php echo $product['product_name']; ?>" required><br>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
<?php
// Fetch categories from the categories table
require_once 'db_connect.php';
$sql = "SELECT category_id, category_name FROM categories";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($categories as $category) {
        $categoryId = $category['category_id'];
        $categoryName = $category['category_name'];
        echo "<option value=\"$categoryId\">$categoryName</option>";
    }
} else {
    echo '<option value="">No categories found</option>';
}
$conn->close();
?>
</select><br>

                </select><br>
            <label for="price">Price:</label>
    <input type="number" name="price" id="price" value="<?php echo $product['price']; ?>" required><br>

    <label for="stock_quantity">Stock Quantity:</label>
    <input type="number" name="stock_quantity" id="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?php echo $product['description']; ?></textarea><br>

    <input type="submit" value="Update">
</form>
