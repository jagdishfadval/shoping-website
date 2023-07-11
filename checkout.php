<?php
session_start();
include 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
     <!-- jquery -->
    <script src = "js/jquery-3.6.0.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <!-- bootstrap js -->
    <script src = "bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <!-- custom js -->
    <script src = "js/script.js"></script>
<style>
    .product-summary {
  margin-top: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table th {
  background-color: #f2f2f2;
}

.table-responsive {
  overflow-x: auto;
  max-width: 100%;
}

@media (max-width: 767px) {
  .table-responsive {
    width: 100%;
    overflow-y: hidden;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    -webkit-overflow-scrolling: touch;
  }
}
.checkout_contianer
{
    margin-top:10vw;
}
.existing-addresses {
  margin-top: 20px;
  display:flex;
  flex-direction:column;
}

.address-item {
  margin-bottom: 20px;
}

.edit-address-form {
  display: none;
  margin-top: 10px;
}

.edit-address-form input {
  margin-bottom: 10px;
}

@media (max-width: 767px) {
  .existing-addresses {
    overflow-x: auto;
  }

  .address-item {
    display: inline-block;
    margin-right: 10px;
    white-space: nowrap;
  }

  .edit-address-form {
    position: relative;
  }

  .edit-address-form input {
    width: 100%;
    margin-bottom: 10px;
  }
}
.new-addresses{
    display:flex;
    flex-direction: column;
}

</style>
</head>
<body>
    
<div class="checkout_contianer">

<?php
// session_start();
require_once 'db_connect.php';
// Check if the user is logged in and has an existing address
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the user has an existing address
    $sql = "SELECT * FROM user_address WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Display existing addresses
        echo '<div class="existing-addresses">';
        echo '<h2>Existing Addresses</h2>';
        echo '<form action="edit_address.php" method="post">';
        
        while ($row = $result->fetch_assoc()) {
            echo '<div class="address-item">';
            echo '<p>'.$row['address_line1'].', '.$row['city'].', '.$row['state'].', '.$row['postal_code'].', '.$row['country'].'</p>';
            echo '<a href="#" class="edit-address" data-address-id="'.$row['id'].'">Edit Address</a>';
            echo '<div class="edit-address-form" style="display: none;">';
            echo '<input type="text" name="address_line1" value="'.$row['address_line1'].'">';
            echo '<input type="hidden" name="address_id" value="'.$row['id'].'">';
            echo '<input type="text" name="city" value="'.$row['city'].'">';
            echo '<input type="text" name="state" value="'.$row['state'].'">';
            echo '<input type="text" name="postal_code" value="'.$row['postal_code'].'">';
            echo '<input type="text" name="country" value="'.$row['country'].'">';
            echo '<button type="submit" class="save-address" data-address-id="'.$row['id'].'">close</button>';
            echo "<input type='submit'>Save</input>";
            echo '</div>';
            echo '</div>';

            $_SESSION["address_id"] = $row['id'];
        }
        
        echo '</form>';
        echo '</div>'; // Close existing-addresses
    } else {
        echo '<div class="new-addresses">';
        echo '<h2>Add New Address</h2>';
        echo '<form action="add_address.php" method="post">';
        echo '<label for="address_line1">Address Line 1</label>';
        echo '<input type="text" name="address_line1" required>';

        echo '<label for="address_line2">Address Line 2</label>';
        echo '<input type="text" name="address_line2">';

        echo '<label for="city">City</label>';
        echo '<input type="text" name="city" required>';

        echo '<label for="state">State</label>';
        echo '<input type="text" name="state" required>';

        echo '<label for="postal_code">Postal Code</label>';
        echo '<input type="text" name="postal_code" required>';

        echo '<label for="country">Country</label>';
        echo '<input type="text" name="country" required>';

        echo '<button type="submit">Add Address</button>';
        echo '</form>';
        echo '</div>';
    }
}
?>
<?php


// Retrieve the cart items from the database for the logged-in user
$user_id = $_SESSION['user_id'];
require_once 'db_connect.php';
$sql = "SELECT cart.*, products.product_name, products.price
        FROM cart
        INNER JOIN products ON cart.product_id = products.product_id
        WHERE cart.user_id = '$user_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<div class="product-summary">';
    echo '<h2>Product Summary</h2>';

    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Product Name</th>';
    echo '<th>Quantity</th>';
    echo '<th>Price</th>';
    echo '<th>Total Price</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $product_name = $row['product_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $total_price = $quantity * $price;

        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $quantity . '</td>';
        echo '<td>' . $price . '</td>';
        echo '<td>' . $total_price . '</td>';
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


<!-- Place order button -->
<form action="order.php" method="post">
    <!-- Other form fields for user details -->

    <input  type="hidden" name="address_id" value="<?php if (isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    
 echo $_SESSION["address_id"];
}
 ?>"  class="place_order">
<div class="place_order">
    <button type="submit" class="">Place Order</button></div>
</form>
<a href="index.php">cancle Order
</a>


<script>
    $(document).ready(function() {
    $('.edit-address').click(function(e) {
        e.preventDefault();
        var addressId = $(this).data('address-id');
        $('.edit-address-form').hide();
        $('.edit-address[data-address-id="'+addressId+'"]').siblings('.edit-address-form').show();
    });

    $('.save-address').click(function(e) {
        e.preventDefault();
        var addressId = $(this).data('address-id');
        var addressLine1 = $(this).siblings('input[name="address_line1"]').val();
        var city = $(this).siblings('input[name="city"]').val();
        var state = $(this).siblings('input[name="state"]').val();
        var postalCode = $(this).siblings('input[name="postal_code"]').val();
        var country = $(this).siblings('input[name="country"]').val();

        // Perform an AJAX request to update the address in the database
        // You can use jQuery's $.ajax() method or any other method of your choice

        // After updating the address, you can update the displayed address dynamically without refreshing the page
        $(this).siblings('p').html(addressLine1 + ', ' + city + ', ' + state + ', ' + postalCode + ', ' + country);
       
        // After updating the address, you can update the displayed address dynamically without refreshing the page
        $(this).siblings('p').html(addressLine1 + ', ' + city + ', ' + state + ', ' + postalCode + ', ' + country);

        // Hide the edit form
        $(this).parent('.edit-address-form').hide();
    });
});

</script>
</div>

</body>
</html>