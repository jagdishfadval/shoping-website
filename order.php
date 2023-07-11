<?php
session_start();
require_once 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or display an error message
    header("Location: login.php");
    exit;
}

// Retrieve the user's address
if (isset($_POST['address_id'])) {
    $addressId = $_POST['address_id'];
    $sql = "SELECT * FROM user_address WHERE id = '$addressId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $address = $result->fetch_assoc();

        // Retrieve the user's cart items
        $userId = $_SESSION['user_id'];
        $sql = "SELECT cart.*, products.*
                FROM cart
                INNER JOIN products ON cart.product_id = products.product_id
                WHERE cart.user_id = '$userId'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Calculate the total amount of the order
            $totalAmount = 0;
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $totalAmount = $quantity * $price;
                $adminId = 1; // Replace with the actual admin ID
                $sql = "INSERT INTO orders (user_id, admin_id, address_id, product_id, total_amount)
                        VALUES ('$userId', '$adminId', '$addressId','$productId', '$totalAmount')";
                $conn->query($sql);
    
            }

            // Insert the order into the orders table
            // $adminId = 1; // Replace with the actual admin ID
            // $sql = "INSERT INTO orders (user_id, admin_id, address_id, total_amount)
            //         VALUES ('$userId', '$adminId', '$addressId', '$totalAmount')";
            // $conn->query($sql);

            // Retrieve the order ID
            $orderId = $conn->insert_id;

            // Insert the order items into the order_items table
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                        VALUES ('$orderId', '$productId', '$quantity', '$price')";
                $conn->query($sql);
            }

            // Clear the user's cart
            $sql = "DELETE FROM cart WHERE user_id = '$userId'";
            $conn->query($sql);

            // Redirect the user to the order confirmation page or display a success message
            header("Location: index.php");
            exit;
        } else {
            // Redirect the user to the cart page or display an error message
            header("Location: cart.php");
            exit;
        }
    } else {
        // Redirect the user to the address page or display an error message
        header("Location: checkout.php");
        exit;
    }
} else {
    // Redirect the user to the address page or display an error message
    header("Location: checkout.php");
    exit;
}
