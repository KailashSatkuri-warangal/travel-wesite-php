<?php
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    include('config.php'); // Include the database configuration

    $stmt = $conn->prepare('SELECT phone_number FROM users WHERE email = ?');
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($phone_number);
        $stmt->fetch();

        if ($phone_number) {
            echo $phone_number;
        } else {
            echo '';
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare statement';
    }

    $conn->close();
} else {
    echo '';
}
?>
