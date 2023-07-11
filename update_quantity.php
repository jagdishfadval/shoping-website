<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the quantity, product_id, and action from the AJAX request
    $quantity = $_POST["quantity"];
    $product_id = $_POST["product_id"];
    $action = $_POST["action"];

    // Find the product in the cart and update the quantity
    if (!empty($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as &$cart_item) {
            if ($cart_item["product_id"] === $product_id) {
                if ($action === "increment") {
                    $cart_item["quantity"] = $quantity;
                } elseif ($action === "decrement") {
                    if ($quantity >= 0) {
                        $cart_item["quantity"] = $quantity;
                    }
                }
                break;
            }
        }
    }
}
?>
