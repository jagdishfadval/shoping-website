<?php
session_start();
require_once 'db_connect.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    // Validate and sanitize the form data (you can add your own validation logic)

    // Insert the new address into the database
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO user_address (user_id, address_line1, address_line2, city, state, postal_code, country)
            VALUES ('$user_id', '$address_line1', '$address_line2', '$city', '$state', '$postal_code', '$country')";
    if ($conn->query($sql) === TRUE) {
        // Address added successfully
        header('Location: checkout.php'); // Redirect to the checkout page
        exit;
    } else {
        // Error occurred while adding the address
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
