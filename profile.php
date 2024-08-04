<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

$sql = "SELECT firstname, lastname, email, phone_number, profile_pic FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found");
}


$stmt->close();
$conn->close();
?>

<?php
// Include your database connection configuration
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user data from the database (users table)
$sqlUser = "SELECT * FROM users WHERE email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $email);

$user = [];
if ($stmtUser->execute()) {
    $resultUser = $stmtUser->get_result();
    if ($resultUser->num_rows > 0) {
        $user = $resultUser->fetch_assoc();
    } else {
        echo "User not found in database.";
        exit();
    }
} else {
    echo "Error fetching user data: " . htmlspecialchars($stmtUser->error);
    exit();
}

$stmtUser->close();

// Fetch all bookings for the user from the database (bookings table)
$sqlBookings = "SELECT * FROM bookings WHERE user_email = ? ORDER BY start_date DESC";
$stmtBookings = $conn->prepare($sqlBookings);
$stmtBookings->bind_param("s", $email);

$bookings = [];
if ($stmtBookings->execute()) {
    $resultBookings = $stmtBookings->get_result();
    while ($row = $resultBookings->fetch_assoc()) {
        $bookings[] = $row;
    }
} else {
    echo "Error fetching bookings: " . htmlspecialchars($stmtBookings->error);
    exit();
}

$stmtBookings->close();
$sql = "SELECT profile_pic FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($profilePic);
$stmt->fetch();
$stmt->close();

// Update session with profile picture path
if (!empty($profilePic)) {
    $_SESSION['profile_pic'] = $profilePic;
}

// Check if the form should be hidden
$hideForm = !empty($profilePic); // True if profile picture exists, false otherwise
?>

<!-- Custom CSS -->
<link rel="stylesheet" href="css/profile.css" />
</head>
<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 mb-4"><?php echo htmlspecialchars($user['firstname']) ?>, Welcome to the Dashboard</h1>

    <!-- Bootstrap Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="favorites-tab" data-toggle="tab" href="#favorites" role="tab" aria-controls="favorites" aria-selected="false">Favorites</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="statistics-tab" data-toggle="tab" href="#statistics" role="tab" aria-controls="statistics" aria-selected="false">Statistics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
        </li>
    </ul>
</div>
    <!-- Tab panes with content -->
    <div class="tab-content" id="myTabContent">
        <!-- Profile Tab Content -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container d-flex justify-content-center">
                <div class="profile-container">
                    <div class="profile-header">
                        <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" id="profilePic" class="rounded-circle" width="100" height="100">
                        <h2><?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?></h2>
                    </div>
                    <div class="profile-details">
                        <!-- Update Profile Button -->
                        <button id="updateProfileBtn" class="btn btn-primary mt-3">Update Profile</button>

                        <!-- Update Profile Form (Initially Hidden) -->
                        <form id="updateProfileForm" action="update_profile.php" method="post" style="display: none;">
                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number:</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                        <!-- Upload Profile Picture Form -->
                        <?php if (!empty($profilePic)): ?>
                            <div>

                                <button class="btn btn-primary mt-3"onclick="showAlert()">Upload Picture</button>
                            </div>

                        <?php endif; ?>

                        <?php if (!$hideForm): ?>
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <div class="form-group mt-3">
                                    <label for="profilePicUpload">Upload Profile Picture:</label>
                                    <input type="file" name="profilePic" id="profilePicUpload" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Upload</button>
                            </form>
                        <?php endif; ?>

                    </div>

                    <!-- Script to display alerts -->
                    <?php if (isset($_SESSION['upload_success'])): ?>
                        <script>
                            alert("<?php echo $_SESSION['upload_success']; ?>");
                        </script>
                    <?php unset($_SESSION['upload_success']); ?>
                    <?php elseif (isset($_SESSION['upload_error'])): ?>
                        <script>
                            alert("<?php echo $_SESSION['upload_error']; ?>");
                        </script>
                    <?php unset($_SESSION['upload_error']); ?>
                    <?php elseif (isset($_SESSION['upload_invalid'])): ?>
                        <script>
                            alert("<?php echo $_SESSION['upload_invalid']; ?>");
                        </script>
                        <?php unset($_SESSION['upload_invalid']); ?>
                    <?php endif; ?>

                    <br><button type="button" class="btn btn-primary" id="forgotPasswordBtn">
                        Forgot Password?
                    </button>


                   <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="forgotPasswordForm">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
                                    </form>

                                    <form id="resetPasswordForm" style="display: none;">
                                        <div class="form-group">
                                            <label for="newPassword">New Password</label>
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </form>

                                    <div id="forgotPasswordAlert"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Display current profile information -->
                        <div class="detail">
                            <br> <span class="emoji">👤</span>
                            <strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?>
                        </div>
                        <div class="detail">
                            <span class="emoji">👤</span>
                            <strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?>
                        </div>
                        <div class="detail">
                            <span class="emoji">✉️</span>
                            <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
                        </div>
                        <div class="detail">
                            <span class="emoji">📞</span>
                            <strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?>
                        </div>
                    </div>
                </div>
            </div>


        <!-- History Tab Content -->
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <div class="container">
                <div class="dashboard">
                    <?php foreach ($bookings as $index => $booking): ?>
                        <div class="order-box">
                            <div class="order-details">
                                <h3>#<?php echo $index + 1; ?> - Order</h3>
                                <button class="btn btn-link accordion" type="button" aria-expanded="false" aria-controls="collapse-<?php echo $index; ?>">
                                    Show Details
                                </button>
                                <div class="panel" id="collapse-<?php echo $index; ?>">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                                            <p>Phone: <?php echo htmlspecialchars($user['phone_number']); ?></p>
                                            <p>Date: <?php echo htmlspecialchars($booking['start_date']); ?></p>
                                            <p>Location: <?php echo htmlspecialchars($booking['location']); ?></p>
                                            <p>Passengers: <?php echo htmlspecialchars($booking['passengers']); ?></p>
                                            <p>Start Date: <?php echo htmlspecialchars($booking['start_date']); ?></p>
                                            <p>Departure Date: <?php echo htmlspecialchars($booking['departure_date']); ?></p>
                                            <p>Hours: <?php echo htmlspecialchars($booking['hours']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Favorites Tab Content -->
        <div class="tab-pane fade" id="favorites" role="tabpanel" aria-labelledby="favorites-tab">
            <div class="container">
                <h3>Favorites content here</h3>
                <!-- Add your PHP logic and HTML for favorites content here -->
            </div>
        </div>

        <!-- Statistics Tab Content -->
        <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
            <div class="container">
                <h3>Statistics content here</h3>
                <!-- Add your PHP logic and HTML for statistics content here -->
            </div>
        </div>
    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
        <!-- Content for the "Orders" tab -->
        <?php
        if (isset($_SESSION['booking_details'])) {
            $booking_details = $_SESSION['booking_details'];

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

                    echo '<div class="booking-details">';
                    echo '<h2>Booking Details</h2>';

                    echo '<div class="car-details">';
                    echo '<h3>Car Details</h3>';
                    $car_numbering = sprintf("id%d", $car['id']);
                    echo '<p><strong>Car ID:</strong> ' . $car_numbering . '</p>';
                    echo '<p><strong>Car Name:</strong> ' . $car['car_name'] . '</p>';
                    echo '<p><strong>Seating Capacity:</strong> ' . $car['seating_capacity'] . '</p>';
                    echo '<p><strong>Car Category:</strong> ' . $car['car_category'] . '</p>';
                    echo '<p><strong>Cancellation Policy:</strong> ' . $car['cancellation_policy'] . '</p>';
                    echo '<p><strong>Location:</strong> ' . $car['location'] . '</p>';
                    // You can display the image here if needed
                    // echo '<img src="' . $car['image_path'] . '" alt="Car Image">';
                    echo '</div>';

                    echo '<div class="user-details">';
                    echo '<h3>User Details</h3>';
                    echo '<p><strong>Start Date:</strong> ' . $booking_details['start_date'] . '</p>';
                    echo '<p><strong>End Date:</strong> ' . $booking_details['end_date'] . '</p>';
                    echo '</div>';

                    // Add a button to download PDF
                    echo '<div class="download-pdf-section">';
                    echo '<a href="generate_pdf.php" class="btn btn-primary" target="_blank">Download PDF</a>';
                    echo '</div>';

                    echo '</div>'; // Close booking-details
                } else {
                    echo '<p>No car details found for Car ID: ' . $car_id . '</p>';
                }
            } else {
                echo "Error executing SQL query: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        } else {
            echo "No booking details found.";
        }
        ?>
    </div>
    </div>
<?php include 'footer.php'; ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var accordions = document.querySelectorAll('.accordion');

        accordions.forEach(function(accordion) {
            accordion.addEventListener('click', function() {
                var panel = this.nextElementSibling;
                this.classList.toggle('active');
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                }
            });
        });

        var updateProfileBtn = document.getElementById('updateProfileBtn');
        var updateProfileForm = document.getElementById('updateProfileForm');

        updateProfileBtn.addEventListener('click', function() {
            updateProfileForm.style.display = 'block';
        });
    });
    function showAlert() {
        alert("You Already Upload Your Profile picture");
    }
</script>

</body>
</html>