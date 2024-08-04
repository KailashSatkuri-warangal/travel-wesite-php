<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL root password
$dbname = "s2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully"; // You can remove or customize this message
}
?>



