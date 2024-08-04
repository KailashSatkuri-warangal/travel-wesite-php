<?php
include 'config.php';

// Add at the beginning for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if car_id is received
if (isset($_POST['id'])) {
    $carId = $_POST['id'];

    // Prepare and execute DELETE query
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $carId);

    if (mysqli_stmt_execute($stmt)) {
        echo 'success'; // Send success response back to AJAX
    } else {
        echo 'error'; // Send error response back to AJAX
    }

    mysqli_stmt_close($stmt);
} else {
    echo 'error'; // Send error response if car_id is not received
}

mysqli_close($conn);
?>
