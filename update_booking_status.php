<?php
include 'config.php'; // Ensure this file includes your database connection setup

$response = array('success' => false);

// Check if it's a POST request and the action is to update booking status
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['car_id'])) {
    $carId = $_GET['car_id'];

    // Update booking status to 'complete' for the given car ID
    $updateSql = "UPDATE bookings_transaction SET order_status = 'pending' WHERE car_id = ? AND order_status = 'pending'";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('i', $carId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Booking status updated to complete!';
    } else {
        $response['error'] = 'Error updating booking status: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $response['error'] = 'Invalid request or missing car ID.';
}

// Output JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
