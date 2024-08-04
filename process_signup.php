<?php
require 'config.php'; // Include your database configuration file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data (optional but recommended)
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $default_role = 'customer';

    // Validate input fields (example validation, adjust as needed)
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection parameters
    $dsn = 'mysql:host=localhost;dbname=s2';
    $db_username = 'root'; // Replace with your database username
    $db_password = ''; // Replace with your database password

    try {
        // Create a PDO instance
        $pdo = new PDO($dsn, $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query
        $stmt = $pdo->prepare('INSERT INTO users (username, firstname, lastname, email, password, role) VALUES (:username, :firstname, :lastname, :email, :password, :role)');
        $default_role = 'customer'; // Default role

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $default_role);

        if ($stmt->execute()) {
            // Registration successful, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $default_role;

            // Redirect to dashboard or another page after registration
            header("Location: index.php");
            exit;
        } else {
            echo "Error: Registration failed.";
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>
