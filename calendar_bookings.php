<?php
session_start();
include 'config.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    // Fetch user email based on session or authentication mechanism
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Sanitize and validate input
        $location = $conn->real_escape_string($_POST['location']);
        $passengers = intval($_POST['passengers']);
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $departure_date = date('Y-m-d', strtotime($_POST['departure_date']));
        $hours = $_POST['hours'];

        // Fetch user_id from users table
        $userQuery = "SELECT id FROM users WHERE email = ?";
        $stmtUser = $conn->prepare($userQuery);
        $stmtUser->bind_param("s", $email);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();

        if ($resultUser->num_rows > 0) {
            $row = $resultUser->fetch_assoc();
            $user_id = $row['id'];

            // Insert into bookings table
            $insertQuery = "INSERT INTO s2.bookings (location, passengers, start_date, departure_date, user_id, user_email, hours, created_at, updated_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sississ", $location, $passengers, $start_date, $departure_date, $user_id, $email, $hours);

            if ($stmt->execute()) {
                $booking_id = $stmt->insert_id;

                // Log the booking creation if needed
                // Example: $logQuery = "INSERT INTO booking_history (booking_id, user_id, action, timestamp) VALUES (?, ?, 'created', NOW())";

                $stmt->close();
                $conn->close();

                // Redirect to car.php after successful booking
                header("Location: car.php");
                exit;
            } else {
                echo '<script>alert("Error: ' . $stmt->error . '"); window.location = "car.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("Error: User with email ' . $email . ' not found."); window.location = "car.php";</script>';
            exit;
        }

        $stmtUser->close();
        $conn->close();
    } else {
        echo '<script>alert("Error: User session not found. Please log in."); window.location = "car.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("Error: Form submission error."); window.location = "car.php";</script>';
    exit;
}
?>
