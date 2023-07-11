<nav class = "navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
    <div class = "container">
        <a class = "navbar-brand d-flex justify-content-between align-items-center order-lg-0" href = "index.html">
            <img src = "images/shopping-bag-icon.png" alt = "site icon">
            <span class = "text-uppercase fw-lighter ms-2">Attire</span>
        </a>
<?php
// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
// User is logged in, display the shopping cart button
echo '
<div class="order-lg-2 nav-btns">
<a href="logout.php" class="link">log out</a>
<a href="cart.php"    <button type="button" class="btn position-relative">
        <i class="fa fa-shopping-cart"></i>
        <!-- <span class="position-absolute top-0 start-100 translate-middle badge bg-primary">5</span> -->
    </button></a>
</div>';
} else {
// User is not logged in, display the login button
echo '
<div class="order-lg-2 nav-btns">
<a href="register.php"  class="link">Register</a>
    <a href="login.php" class="btn">Login</a>
</div>' ;
}
?>


        <button class = "navbar-toggler border-0" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navMenu">
            <span class = "navbar-toggler-icon"></span>
        </button>

        <div class = "collapse navbar-collapse order-lg-1" id = "navMenu">
            <ul class = "navbar-nav mx-auto text-center">
                <li class = "nav-item px-2 py-2">
                    <a class = "nav-link text-uppercase text-dark" href = "index.php">Home</a>
                </li>
                <li class = "nav-item px-2 py-2">
                    <a class = "nav-link text-uppercase text-dark" href = "index.php#collection">shop</a>
                </li>
                <li class = "nav-item px-2 py-2">
                    <a class = "nav-link text-uppercase text-dark" href = "index.php#about">About</a>
                </li>
                <li class = "nav-item px-2 py-2">
                    <a class = "nav-link text-uppercase text-dark" href = "my_orders.php">My orders</a>
                </li>
          
            </ul>
        </div>
    </div>
</nav>