<?php
session_start();
include('config.php');

// Ensure this is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = array();

    try {
        // Sanitize and escape input data
        $car_id = intval($_POST['car_id']);
        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

        // Query to retrieve user_id based on user_email
        $find_user_sql = "SELECT id FROM users WHERE email = '$user_email'";
        $result = $conn->query($find_user_sql);

        if ($result->num_rows > 0) {
            // Fetch user_id from the query result
            $user_row = $result->fetch_assoc();
            $user_id = $user_row['id'];

            // Calculate booking duration in hours
            $start_timestamp = strtotime($start_date);
            $end_timestamp = strtotime($end_date);
            $booking_hours = round(($end_timestamp - $start_timestamp) / (60 * 60), 1);

            // Proceed with booking data insertion
            $booking_date = date('Y-m-d H:i:s');
            $order_status = 'pending';

            // Insert booking data into bookings_transaction table
            $sql = "INSERT INTO bookings_transaction (user_id, car_id, booking_date, order_status) 
                    VALUES ('$user_id', '$car_id', '$booking_date', '$order_status')";

            // Perform the SQL query
            if ($conn->query($sql) === TRUE) {
                // If insertion successful
                $response['success'] = true;

                // Store booking details in session with expiry time (3 hours)
                $expiry_time = time() + (3 * 60 * 60); // 3 hours from now
                $_SESSION['booking_details'] = array(
                    'car_id' => $car_id,
                    'user_id' => $user_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'expiry_time' => $expiry_time
                );

                // Provide a redirect URL for confirmation page
                $response['redirect'] = 'profile.php';
            } else {
                throw new Exception("Error: " . $conn->error);
            }
        } else {
            throw new Exception("User with email '$user_email' not found.");
        }
    } catch (Exception $e) {
        // Handle exceptions
        $response['success'] = false;
        $response['error'] = $e->getMessage();
    }

    // Return JSON response
    echo json_encode($response);
}
?>
