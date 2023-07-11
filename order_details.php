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
    .order-card {
        /* margin-top:10vw; */
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .order-card h3 {
        margin-top: 0;
    }

    .order-card p {
        margin-bottom: 5px;
    }
</style>

</head>
<body>
    

<?php
include 'admin_nav.php';
?>

<div class="order_container">
<?php
// Assuming you have already established a database connection
require_once 'db_connect.php';

// Retrieve the orders data with related information
$sql = "SELECT orders.*, users.*, user_address.*, products.*
        FROM orders
        INNER JOIN users ON orders.user_id = users.id
        INNER JOIN user_address ON orders.address_id = user_address.id
        INNER JOIN products ON orders.product_id = products.product_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $currentUserId = null;
    $orderCardOpened = false;

    while ($row = $result->fetch_assoc()) {
        $userId = $row['user_id'];

        // Check if the user ID has changed
        if ($userId !== $currentUserId) {
            // Close the previous order card if it's opened
            if ($orderCardOpened) {
                echo '</div>';
                $orderCardOpened = false;
            }

            // Open a new order card for the current user
            echo '<div class="order-card">';
            echo '<h3>ID: ' . $userId . '</h3>';
            echo '<p>User Name: ' . $row['name'] . '</p>';
            echo '<p>User Email: ' . $row['email'] . '</p>';
            $currentUserId = $userId;
            $orderCardOpened = true;
        }

        // Display the order details within the current order card
        echo '<div>';
        echo '<p>Order ID: ' . $row['order_id'] . '</p>';
        echo '<p>Order Date: ' . $row['order_date'] . '</p>';
        echo '<p>Product Name: ' . $row['product_name'] . '</p>';
        
        echo '<p>Price: ' . $row['price'] . '</p>';
        echo '</div>';
    }

    // Close the last order card if it's opened
    if ($orderCardOpened) {
        echo '</div>';
    }
} else {
    echo "No orders found.";
}



// Close the database connection
$conn->close();
?>
</div>
<script src = "js/jquery-3.6.0.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <!-- bootstrap js -->
    <script src = "bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <!-- custom js -->
    <script src = "js/script.js"></script>

</body></html>