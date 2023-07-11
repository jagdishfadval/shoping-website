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
</head>
<body>

<?php
// Include the navigation bar
include 'admin_nav.php';
?>

<div class="product_form">
    <form action="insert_product.php" method="post" enctype="multipart/form-data" class="form_product">
        <h2>Insert Product</h2>
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required><br>


        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
        <?php
    // Database credentials
 
    // Include the database connection file
    require_once 'db_connect.php';
    
    // Fetch categories from the categories table
    $sql = "SELECT category_id, category_name FROM categories";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
        }
    } else {
        echo '<option value="">No categories found</option>';
    }
    $conn->close();
    ?>
</select><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" name="stock_quantity" id="stock_quantity" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="images">Images:</label>
        <input type="file" name="images[]" id="images" multiple><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
