<?php
// Start session
session_start();
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Include the navigation bar
include 'nav.php';

// Database connection details
require_once 'db_connect.php';

// Check if the user is logged in

// Retrieve the user's orders from the database
$userID = $_SESSION["user_id"];
$orderSql = "SELECT * FROM orders WHERE user_id = '$userID'";
$orderResult = $conn->query($orderSql);

?>

<!DOCTYPE html>
<html lang="en">
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
        .order_container
        {
            padding-top:10vw;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top:10vw;">
        <h1>My Orders</h1>
        <?php


// Retrieve the cart items from the database for the logged-in user
$user_id = $_SESSION['user_id'];
require_once 'db_connect.php';
// $sql = "SELECT orders.*, products.product_name, products.price
//         FROM orders
//         INNER JOIN products ON orders.product_id = products.product_id
//         WHERE orders.user_id = '$user_id'";

$sql = "SELECT orders.*,user_address.*, products.*
        FROM orders
        INNER JOIN user_address ON orders.address_id = user_address.id
        INNER JOIN products ON orders.product_id = products.product_id
        WHERE orders.user_id = '$user_id'";        
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<div class="product-summary">';
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Product Name</th>';
    echo '<th>Price</th>';
    echo '<th>Address</th>';
    echo '<th>city</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $product_name = $row['product_name'];
        $price = $row['price'];
        $line1 = $row['address_line1'];
        $city = $row['city'];
        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $price . '</td>';
        echo '<td>' . $line1 . '</td>';
        echo '<td>' . $city . '</td>';
        echo '<td><a href="remove_order.php?order_id=' . $row['order_id'] . '">Delete</a></td>';

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>'; // Close table-responsive

    echo '</div>'; // Close product-summary
} else {
    echo '<p>Your cart is empty.</p>';
}
?>
        <!-- Add any additional content or functionality here -->

    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
