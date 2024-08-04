<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/filter.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
include ('config.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: register.php'); // Redirect to register.php if not logged in
    exit();
}

$email = $_SESSION['email'];

// Retrieve user_id based on email
$user_query = "SELECT id, username, phone_number, email FROM users WHERE email = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch user details
    $userId = $user['id']; // Get user_id
} else {
    // Handle case where user with provided email does not exist
    header('Location: register.php'); // Redirect to register.php or handle appropriately
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $location = isset($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : '';
    $departure = isset($_GET['departure']) ? $_GET['departure'] : '';
    $return = isset($_GET['return']) ? $_GET['return'] : '';
    if (!empty($location)) {
        error_log("Location received: " . $location);
        $sql = "SELECT * FROM cars WHERE location LIKE '%$location%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<div class="row">'; // Start Bootstrap row
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">'; // Each column for medium screens (col-md-4), with margin-bottom (mb-4)
                echo '<div class="card">';
                echo '<img style="width: 100%" height="50%" src="' . $row['image_path'] . '" class="card-img-top" alt="Car Image">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['car_name'] . '</h5>';
                echo '<p class="card-text">Seating Capacity: ' . $row['seating_capacity'] . '</p>';
                echo '<p class="card-text">AC Option Price: ' . $row['ac_option'] . '</p>';
                echo '<p class="card-text">Non-AC Option Price: ' . $row['non_ac_option'] . '</p>';
                echo '<p class="card-text">Cancellation Policy: ' . $row['cancellation_policy'] . '</p>';

                $carId = $row['id'];
                echo '<a href="carview.php?car_id=' . $carId . '" class="btn btn-primary">';
                echo 'View Car Details';
                echo '</a>&nbsp;';
                $booking_check_sql = "SELECT * FROM bookings_transaction WHERE car_id = '$carId' AND user_id = '$userId' AND order_status = 'pending'";
                $booking_check_result = $conn->query($booking_check_sql);

                if ($booking_check_result->num_rows > 0) {
                    echo '<a href="#" class="btn btn-secondary disabled">Booked</a>';
                } else {
                    echo '<a href="#" class="btn btn-primary book-now" data-car-id="' . $row['id'] . '">Book Now</a>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>'; // End Bootstrap row
        } else {
            echo "No cars found matching the location: $location";

        }
    } else {
        echo "Please provide a valid location parameter.";
    }
}
?>


<!-- Booking Form Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book This Car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <input type="hidden" id="carId" name="car_id" value="">
                    <input type="hidden" id="userId" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input type="text" class="form-control" id="userName" name="user_name" placeholder="Enter your name" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="user_email" placeholder="Enter your email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="userPhone">Phone</label>
                        <input type="tel" class="form-control" id="userPhone" name="user_phone" placeholder="Enter your phone number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                    </div>
                    <div class="form-group">
                        <span><i class="ri-calendar-line"></i></span>
                        <label for="startDate">Departure Date</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" value="<?php echo isset($departure) ? htmlspecialchars($departure) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <span><i class="ri-calendar-line"></i></span>
                        <label for="endDate">Return Date</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo isset($return) ? htmlspecialchars($return) : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </form>
                <div id="bookingStatus" class="booking-loading" style="display: none;">
                    <div id="bookingStatusIcon">
                        <i class="fas fa-spinner fa-spin fa-5x"></i>
                    </div>
                    <div id="bookingStatusText">
                        <span>Booking in progress... </span><i class="ri-loader-2-line"></i>
                    </div>
                </div>
                <div id="confirmationBox" class="confirmation-message" style="display: none;">
                    <div id="confirmationIcon">
                        <span style="font-size: 48px;">🎉 <a href="#orders">Click here for confirmation</a></span>
                    </div>
                    <div id="confirmationText">
                        <p id="confirmationMessage"></p>
                        <div id="countdownTimer" style="font-size: 20px;"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?php include 'footer.php'; ?>
<script src="js/car.js"></script>
<script src="js/script.js"></script>

<script>
    // Function to disable booked buttons and start countdown timers
    function checkBookingStatus() {
        $('.book-now').each(function() {
            var carId = $(this).data('car-id');
            var button = $(this);

            $.ajax({
                url: 'update_booking_status.php',
                type: 'GET',
                data: { car_id: carId },
                dataType: 'json',
                success: function(response) {
                    if (response.booked && response.order_status === 'pending') {
                        var countDownDate = new Date(response.bookingEndTime * 1000).getTime();
                        var x = setInterval(function() {
                            var now = new Date().getTime();
                            var distance = countDownDate - now;

                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            button.text(hours + "h " + minutes + "m " + seconds + "s ");

                            if (distance < 0) {
                                clearInterval(x);
                                button.removeAttr('disabled').removeClass('btn-secondary').addClass('btn-primary').text('Book Now');
                            }
                        }, 1000);
                    } else {
                        button.removeAttr('disabled').removeClass('btn-secondary').addClass('btn-primary').text('Book Now');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking booking status:', error);
                }
            });
        });
    }

    checkBookingStatus();

    $('.book-now').click(function(e) {
        e.preventDefault();
        var carId = $(this).data('car-id');
        $('#carId').val(carId);
        $('#bookingModal').modal('show');
    });

    $('#bookingForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $('#bookingStatus').css('display', 'block').html('Booking in progress...');

        $.ajax({
            url: 'save_booking.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#bookingStatus').css('display', 'none');

                if (response.success) {
                    $('#confirmationBox').css('display', 'block');
                    $('#confirmationMessage').html('🎉 Booking successful! Enjoy your ride!');

                    var carId = $('#carId').val();
                    var bookedButton = $('.book-now[data-car-id="' + carId + '"]');
                    bookedButton.attr('disabled', true).removeClass('btn-primary').addClass('btn-secondary').text('Booked');

                    var userName = '<?php echo htmlspecialchars($user['username']); ?>';
                    var userEmail = '<?php echo htmlspecialchars($user['email']); ?>';

                    var carDetails = ''; // Fetch car details
                    var whatsappMessage = encodeURIComponent('Hello ' + userName + ', your car booking details:\n' +
                        carDetails + '\n' +
                        'Email: ' + userEmail);

                    var whatsappLink = 'https://wa.me/?text=' + whatsappMessage;

                    var whatsappLinkElement = $('<a>')
                        .attr('href', whatsappLink)
                        .addClass('btn btn-primary mt-2')
                        .text('Open WhatsApp');

                    bookedButton.after(whatsappLinkElement);

                    setTimeout(function() {
                        whatsappLinkElement.remove();
                    }, 20 * 60 * 1000);

                    $('#bookingModal').modal('hide');
                    $('#orders-tab').tab('show');
                    checkBookingStatus();
                } else {
                    $('#bookingStatusText').html('<span class="text-danger">Booking failed.</span>');
                    console.error('Error saving booking:', response.error);
                }
            },
            error: function(xhr, status, error) {
                $('#bookingStatus').css('display', 'none');
                $('#bookingStatusText').html('<span class="text-danger">AJAX Error: ' + error + '</span>');
                console.error('AJAX Error:', error);
            }
        });
    });
        // Get today's date and set the minimum and maximum selectable dates
        var today = new Date();
        var maxDate = new Date(today.getTime() + 15 * 24 * 60 * 60 * 1000); // 15 days from today

        // Format the max date for input
        var maxDateString = maxDate.toISOString().slice(0, 10);

        // Set the attributes for the date inputs
        document.getElementById("startDate").setAttribute("min", today.toISOString().slice(0, 10));
        document.getElementById("startDate").setAttribute("max", maxDateString);
        document.getElementById("endDate").setAttribute("min", today.toISOString().slice(0, 10));
        document.getElementById("endDate").setAttribute("max", maxDateString);

</script>
</body>
</html>
