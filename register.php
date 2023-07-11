<?php
// Include the navigation bar
session_start();

// Database connection details
require_once 'db_connect.php';
// Process the registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Insert user data into the users table
    $sql = "INSERT INTO users (name, password, email) VALUES ('$name', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
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
</head>

<body>


<?php
include 'nav.php';
?>


<h2>User Registration</h2>
<form class="login"  action="" method="POST">
        <h2>Welcome, User!</h2>
        <p>Please Register</p>
        <label for="email">Name:</label>
        <input type="text" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
        <div class="links">
            <!-- <a href="#">Forgot password</a> -->
            <a href="login.php">Login</a>
          </div>
    </form>


