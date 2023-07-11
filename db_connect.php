<?php
$servername = "localhost";
$username = "id20752018_root";
$password = "Devhadvani@@1";
$dbname = "id20752018_ecom";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
