<?php
include 'config.php'; // Ensure this file includes database connection setup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['id'];

    $sql = "SELECT bookings.*, users.username, cars.car_name FROM bookings
            JOIN users ON bookings.user_id = users.id
            JOIN cars ON bookings.car_id = cars.id
            WHERE bookings.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        echo "<p>Order ID: " . htmlspecialchars($order['order_id']) . "</p>";
        echo "<p>Customer Name: " . htmlspecialchars($order['username']) . "</p>";
        echo "<p>Car Name: " . htmlspecialchars($order['car_name']) . "</p>";
        echo "<p>Booking Date: " . htmlspecialchars($order['booking_date']) . "</p>";
        echo "<p>Order Status: " . htmlspecialchars($order['order_status']) . "</p>";
        // Add more order details as needed
    } else {
        echo "<p>Order not found.</p>";
    }
}
?>
