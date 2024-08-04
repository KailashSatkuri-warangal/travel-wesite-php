<?php
session_start();

// Include your database configuration file
include ('config.php');

// Function to generate QR code (you can use an external service as shown previously)
function generateQRCode($text) {
    // Example implementation, replace with your preferred QR code generation method
    // For example, using an external API service to generate QR codes
    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($text);
    return $qrCodeUrl;
}

// Check if booking details are stored in session
if (isset($_SESSION['booking_details'])) {
    $booking_details = $_SESSION['booking_details'];

    // Fetch car details from database based on booking
    $sql = "SELECT * FROM cars WHERE id = ?";
    $car_id = $booking_details['car_id'];

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $car = $result->fetch_assoc();
            $ticketNumber = $car['location'].'FT12'. '-' . $car['id'];

            // Generate QR code for booking details
            $qrText = "Booking ID: " . $ticketNumber . "\n";
            $qrText .= "Car ID: " . $car['id'] . "\n";
            $qrText .= "Start Date: " . $booking_details['start_date'] . "\n";
            $qrText .= "End Date: " . $booking_details['end_date'];

            $qrCodeUrl = generateQRCode($qrText);

            // HTML structure for the ticket
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Ticket</title>
                <!-- Link to Font Awesome for icons -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
                <!-- Link to your custom CSS for ticket styling -->
                <link rel="stylesheet" href="css/ticket.css" />
            </head>
            <body>
            <!-- Ticket structure -->
            <div class="ticket" style="border-radius: 2rem">
                <div class="left">
                    <!-- Left section with event details -->
                    <div class="image">

                        <p class="admit-one">
                            <span>Booked car</span>
                            <span>Booked car</span>
                            <span>Booked car</span>
                        </p>
                        <div class="ticket-number">
                            <p>#<?php echo $ticketNumber; ?></p>
                        </div>
                    </div>
                    <div class="ticket-info">
                        <div class="text">
                            <p class="date">
                                <span><?php echo date('l', strtotime($booking_details['start_date'])); ?></span>
                                <span class="<?php echo date('F dS', strtotime($booking_details['start_date'])); ?>"><?php echo date('F dS', strtotime($booking_details['start_date'])); ?></span>
                                <span><?php echo date('Y', strtotime($booking_details['start_date'])); ?></span>
                            </p>
                            <div class="show-name">
                                <h1>Booking Details</h1>
                                <div class="mycar-details">
                                    <h2>
                                        <p><strong>Car ID:</strong> <?php echo sprintf("id%d", $car['id']); ?></p>
                                    </h2>
                                    <p><strong>Car Name:</strong> <?php echo $car['car_name']; ?></p>
                                    <p><strong>Seating Capacity:</strong> <?php echo $car['seating_capacity']; ?></p>
                                    <p><strong>Car Category:</strong> <?php echo $car['car_category']; ?></p>
                                    <p><strong>Cancellation Policy:</strong> <?php echo $car['cancellation_policy']; ?></p>
                                    <p><strong>Location:</strong> <?php echo $car['location']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="time">
                            <p>8:00 PM <span>TO</span> 11:00 PM</p>
                            <p>DOORS <span>@</span> 7:00 PM</p>
                        </div>
                        <p class="location">
                            <span>Happy Journey</span>
                            <span class="separator"><i class="far fa-smile"></i></span>
                            <span>Be Smile</span>
                        </p>
                    </div>
                </div>
                <div class="right">
                    <!-- Right section with additional details and QR code -->
                    <div class="ticket-info">
                        <div class="carbooking-details">
                            <div class="myuser-details">
                                <h2>User Details</h2>
                                <p><strong>Start Date:</strong> <?php echo $booking_details['start_date']; ?></p>
                                <p><strong>End Date:</strong> <?php echo $booking_details['end_date']; ?></p>
                            </div><br>
                            <div class="barcode">
                                <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </body>
            </html>
            <?php
        } else {
            echo '<p>No car details found for Car ID: ' . $car_id . '</p>';
        }
    } else {
        echo "Error executing SQL query: " . htmlspecialchars($stmt->error);
    }

    // Close prepared statement
    $stmt->close();
} else {
    echo "No booking details found.";
}
?>
<script>
    window.onload = function() {
        window.print();
    };
</script>