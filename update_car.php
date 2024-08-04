<?php
// Start session and include configuration
session_start();
include ('config.php');

// Redirect to login if not authenticated as admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle form submission for updating car details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $seating_capacity = $_POST['seating_capacity'];
    $car_category = $_POST['car_category'];
    $ac_option = $_POST['ac_option'];
    $non_ac_option = $_POST['non_ac_option'];
    $cancellation_policy = $_POST['cancellation_policy'];
    $image_path=$_POST['image_path'];

    // Update SQL query using prepared statement for security
    $update_sql = "UPDATE cars SET 
                    car_name = ?,
                    seating_capacity = ?,
                    car_category = ?,
                    ac_option = ?,
                    non_ac_option = ?,
                    cancellation_policy = ?
                    image_path = ?
                    WHERE id = ?";

    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "sisdsis", $car_name, $seating_capacity, $car_category, $ac_option, $non_ac_option, $cancellation_policy, $car_id ,$image_path);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['update_status'] = 'success';
    } else {
        $_SESSION['update_status'] = 'error';
    }

    mysqli_stmt_close($stmt);

    // Redirect back to admin panel after update
    header("Location: admin_panel.php");
    exit();
} else {
    // Redirect to admin panel if accessed without proper POST data
    header("Location: admin_panel.php");
    exit();
}
?>
