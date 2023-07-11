<?php
// Start session
session_start();

// Database connection details
require_once 'db_connect.php';

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email == "admin@gmail.com" && $password == "admin") {
        $_SESSION["admin_login"] = $email;
        header("Location: order_details.php");
        exit();
    }

    // Retrieve user data from the users table
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        // Login successful
        $user = $result->fetch_assoc();

        // Store user information in session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        // Redirect to the desired page
header("Location:index.php");
        exit();
    } else {
        // Invalid login credentials
        $errorMessage = "Invalid email or password.";
    }
}

// Close the database connection
$conn->close();
?>

<?php
// Include the navigation bar
include 'nav.php';
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
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <form class="login" action="" method="POST">
        <h2>Welcome, User!</h2>
        <p>Please log in</p>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
        <div class="links">
            <!-- <a href="#">Forgot password</a> -->
            <a href="register.php">Register</a>
        </div>
        <?php
        if (isset($errorMessage)) {
            echo "<p>$errorMessage</p>";
        }
        ?>
    </form>
</body>
</html>
