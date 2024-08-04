<?php
session_start();
include('config.php');

$query = "SELECT id, user_id, car_id, booking_date, order_status FROM bookings_transaction";

$result = $conn->query($query);

if ($result) {
    $bookings = array();
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    $response['success'] = true;
    $response['bookings'] = $bookings;
} else {
    $response['error'] = $conn->error;
}

echo json_encode($response);

$conn->close();
?>
