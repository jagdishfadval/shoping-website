<?php
require_once 'db_connect.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the address ID from the form
    $addressId = $_POST['address_id'];

    // Retrieve the updated address data from the form
    $addressLine1 = $_POST['address_line1'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postal_code'];
    $country = $_POST['country'];

    // Perform the database update query
    $sql = "UPDATE user_address SET address_line1 = '$addressLine1', city = '$city', state = '$state', postal_code = '$postalCode', country = '$country' WHERE id = '$addressId'";

    if ($conn->query($sql) === TRUE) {
        header('Location: checkout.php');
        // Address updated successfully
        // You can display a success message or redirect the user to a confirmation page
    } else {
        // Error updating address
        // You can display an error message or handle the error as needed
    }
}
?>
