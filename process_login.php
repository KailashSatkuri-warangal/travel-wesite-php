<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to protect against SQL injection
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $password_hash);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $password_hash)) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header('Location: homepage.php'); // Redirect to the homepage
        } else {
            // Incorrect password
            echo "Invalid username or password.";
        }
    } else {
        // No user found
        echo "Invalid username or password.";
    }

    $stmt->close();
}
$conn->close();
?>
