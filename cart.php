<?php
session_start();
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
</head>
<body>
<?php
// Include the navigation bar
include 'nav.php';
?>
<div class="all_container">
<div class="cart_container">
<?php
// session_start();
// cart.php
require_once 'db_connect.php';
// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the cart items for the user
$sql = "SELECT cart.*, products.product_name, products.price,products.image_paths FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = '$user_id'";

$result = $conn->query($sql);
$final_price = 0;
$counter = 0;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_id = $row['cart_id'];
        // $product_name = $row['product_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $total_price = $quantity * $price;
        $imagePaths = explode(',', $row['image_paths']);
        $firstImagePath = $imagePaths[0];
        $final_price = $final_price + $total_price;
        $counter++;
        echo "<div class='cart-item'>";
        echo "<div class='cart-image'>";
        echo '<img src="' . $firstImagePath . '" alt="Product Image" class="product_image">';
        echo "</div>";
        echo "<div class='cart-desc'>";
        echo "<span class='product-name'>".$row['product_name']."</span>";
        echo "<span class='price'>Price: $price</span>";
        echo "<span class='total-price'>Total Price: $total_price</span>";
        echo "<div class='cart-quant'>";
        echo "<a href='update_cart.php?action=decrease&cart_id=$cart_id'>- </a>";
        echo "<span class='quantity'>&nbsp; $quantity &nbsp;</span>";
        echo "<a href='update_cart.php?action=increase&cart_id=$cart_id'>+ </a>";
        echo "</div>";
        echo "<a href='update_cart.php?action=remove&cart_id=$cart_id'>Remove</a>";
        echo "</div>";
        echo "</div>";
        
    }
    $_SESSION['total_amount'] = $final_price;
    echo "<div class='place_order'>";
    echo "<a href='checkout.php'><button>Place order</button></a>";
    echo "</div>";
    echo "</div>";
    echo "<div class='subtotal'>";
    echo "<p>Price Detail</p>";
    echo "<hr>";
    echo "<div class='total_item'>";
    echo "<p>Items (".   $counter  .")</p>";  
    echo "<p>$final_price</p>";
    echo "</div>";
    echo "<div class='total_item'>";
    echo "<p>Discount</p>";  
    echo "<p>0</p>";
    echo "</div>";
    echo "<div class='total_item'>";
    echo "<p>Dilivery Charge</p>";  
    echo "<p class='del'>Free</p>";
    echo "</div>";
    echo "<hr>";    
    echo "<div class='total_item'>";
    echo "<p>Total Price</p>";  
    echo "<p>$final_price</p>";
    echo "</div>";
    echo "<div class='total_item'>";
    echo "<p>Payment Mode</p>";  
    echo "<p>ONLY CASE ON DELIVERY</p>";
    echo "</div>";
} else {
    echo "Cart is empty.";
}

// Close the database connection
$conn->close();

?>

</div>
    
</body>
</html>