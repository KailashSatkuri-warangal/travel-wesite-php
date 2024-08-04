<?php
include 'config.php';
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<?php include('header.php'); ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="adminTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="carUpload-tab" data-toggle="tab" href="#carUpload" role="tab" aria-controls="carUpload" aria-selected="true">Car Upload</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="userTab-tab" data-toggle="tab" href="#userTab" role="tab" aria-controls="userTab" aria-selected="false">User Data</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="editTab-tab" data-toggle="tab" href="#editTab" role="tab" aria-controls="editTab" aria-selected="false">Edit Car</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="editlocation-tab" data-toggle="tab" href="#locationTab" role="tab" aria-controls="locationTab" aria-selected="false">location Car</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="CustomerOrders-tab" data-toggle="tab" href="#CustomerOrdersTab" role="tab" aria-controls="CustomerOrdersTab" aria-selected="false">Customer Orders Car</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Bookings</a>
    </li>
</ul>

<!-- Display success or error messages if any -->
<?php if (isset($_SESSION['upload_status'])): ?>
    <?php if ($_SESSION['upload_status'] == 'success'): ?>
        <div class="alert alert-success mt-3 mx-3">You have added the car successfully!</div>
        <script>setTimeout(function(){ window.location.href = "admin_panel.php"; }, 2000);</script>
    <?php else: ?>
        <div class="alert alert-danger mt-3 mx-3">Error adding car. Please try again.</div>
        <script>setTimeout(function(){ window.location.href = "admin_panel.php"; }, 2000);</script>
    <?php endif; ?>
    <?php unset($_SESSION['upload_status']); ?>
<?php endif; ?>

<!-- Tab panes -->
<div class="tab-content mt-4" id="adminTabContent">
    <!-- Car Upload Tab -->
    <div class="tab-pane fade show active" id="carUpload" role="tabpanel" aria-labelledby="carUpload-tab">
        <form id="carForm" action="upload_car.php" method="POST" enctype="multipart/form-data" class="mx-3">
            <input type="hidden" id="carId" name="car_id">
            <div class="form-group">
                <label for="carName">Car Name</label>
                <input type="text" class="form-control" id="carName" name="car_name" required>
            </div>
            <div class="form-group">
                <label for="seatingCapacity">Seating Capacity</label>
                <input type="number" class="form-control" id="seatingCapacity" name="seating_capacity" required>
            </div>
            <div class="form-group">
                <label for="carCategory">Car Category</label>
                <select class="form-control" id="carCategory" name="car_category" required>
                    <option value="Compact">Compact</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Van">Van</option>
                </select>
            </div>
            <div class="form-group">
                <label for="acOption">AC Option Price</label>
                <input type="number" step="0" class="form-control" id="acOption" name="ac_option" required>
            </div>
            <div class="form-group">
                <label for="nonAcOption">Non-AC Option Price</label>
                <input type="number" step="0" class="form-control" id="nonAcOption" name="non_ac_option" required>
            </div>
            <div class="form-group">
                <label for="cancellationPolicy">Cancellation Policy</label>
                <input type="text" class="form-control" id="cancellationPolicy" name="cancellation_policy" required>
            </div>
            <div class="form-group">
                <label for="imageUpload">Upload Image</label>
                <input type="file" class="form-control-file" id="imageUpload" name="image_path">
                <div id="existingImageContainer" style="display:none;">
                    <img id="existingImage" src="" alt="Car Image" style="width: 100px; margin-top: 10px;">
                </div>
            </div>
            <button type="submit" id="carFormButton" class="btn btn-primary">Add Car</button>
        </form>
    </div>


    <!-- User Data Tab -->
    <div class="tab-pane fade" id="userTab" role="tabpanel" aria-labelledby="userTab-tab">
        <div class="table-responsive mx-3 mt-3">
            <table class="table table-striped" id="usersTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars(isset($row['username']) ? $row['username'] : 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars(isset($row['email']) ? $row['email'] : 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars(isset($row['phone_number']) ? $row['phone_number'] : 'N/A') . '</td>';
                        echo '<td>
                                 <form action="update_userinf.php" method="POST">
                                    <input type="hidden" name="action" value="update_role">
                                    <input type="hidden" name="user_id" value="' . htmlspecialchars($row['id']) . '">
                                    <select name="role" class="form-control-sm" required>
                                        <option value="user"' . ($row['role'] === 'user' ? ' selected' : '') . '>User</option>
                                        <option value="admin"' . ($row['role'] === 'admin' ? ' selected' : '') . '>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">Update</button>
                                </form>
                            </td>';
                        echo '<td>
                                <form action="update_userinf.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                                    <input type="hidden" name="action" value="delete_user">
                                    <input type="hidden" name="user_id" value="' . htmlspecialchars($row['id']) . '">
                                    <button type="submit" class="btn btn-danger delete-car-btn">Delete</button>
                                </form>
                            </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No users found.</td></tr>';
                }

                mysqli_close($conn);
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
include ('config.php');

// Redirect if user is not logged in or not an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all cars from the database
$sql = "SELECT * FROM cars";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching cars: " . mysqli_error($conn);
    exit();
}

?>


    <div class="tab-pane fade" id="editTab" role="tabpanel" aria-labelledby="editTab-tab">
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['car_name']); ?></h5>
                            <p class="card-text">Seating Capacity: <?php echo $row['seating_capacity']; ?></p>
                            <p class="card-text">Category: <?php echo htmlspecialchars($row['car_category']); ?></p>
                            <p class="card-text">AC Option Price: $<?php echo number_format($row['ac_option'], 2); ?></p>
                            <p class="card-text">Non-AC Option Price: $<?php echo number_format($row['non_ac_option'], 2); ?></p>
                            <p class="card-text">Cancellation Policy: <?php echo htmlspecialchars($row['cancellation_policy']); ?></p>
                        </div>
                        <div class="card-body">
                            <!-- Edit button triggers modal -->
                            <button type="button" class="btn btn-primary edit-car-btn"
                                    onclick="editProcess(<?php echo $row['id']; ?>,
                                            '<?php echo htmlspecialchars($row['car_name']); ?>',
                                    <?php echo $row['seating_capacity']; ?>,
                                            '<?php echo htmlspecialchars($row['car_category']); ?>',
                                    <?php echo $row['ac_option']; ?>,
                                    <?php echo $row['non_ac_option']; ?>,
                                            '<?php echo htmlspecialchars($row['cancellation_policy']); ?>',
                                            '<?php echo htmlspecialchars($row['image_path']); ?>')"
                                    data-toggle="modal" data-target="#editCarModal">Edit</button>

                            <button class="btn btn-danger" onclick="deleteCar(<?php echo $row['id']; ?>)" data-car-id="<?php echo $row['id']; ?>">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


    <?php
    include 'config.php';

    // Fetch all cars
    $sql = "SELECT * FROM cars";
    $result = $conn->query($sql);

    // Locations list
    $locations = ['Hanmakonda', 'Warangal', 'Delhi', 'Mumbai', 'Goa', 'Gujarat', 'Ladakh', 'Bangalore', 'Hyderabad', 'Kolkata', 'Chennai', 'Jaipur', 'Ahmedabad', 'Pune', 'Surat', 'Kanpur', 'Nagpur', 'Indore', 'Thane', 'Bhopal'];

    // Handle success message
    $update_success = isset($_GET['update']) && $_GET['update'] == 'success';
    ?>
    <?php if ($update_success): ?>
        <div class="alert alert-success" role="alert">
            Record updated successfully!
        </div>
    <?php endif;
    ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="edit_car.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Car Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="car-id">
                        <div class="form-group">
                            <label for="car-name">Car Name</label>
                            <input type="text" class="form-control" id="car-name" name="car_name" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select class="form-control" id="location" name="location" required>
                                <?php foreach ($locations as $loc): ?>
                                    <option value="<?php echo $loc; ?>"><?php echo $loc; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="locationTab" role="tabpanel" aria-labelledby="editlocation-tab">
        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Car Name</th>
                <th>Seating Capacity</th>
                <th>Category</th>
                <th>AC Option</th>
                <th>Non-AC Option</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['car_name']; ?></td>
                    <td><?php echo $row['seating_capacity']; ?></td>
                    <td><?php echo $row['car_category']; ?></td>
                    <td><?php echo $row['ac_option']; ?></td>
                    <td><?php echo $row['non_ac_option']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><button class="btn btn-primary btn-sm edit-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['car_name']; ?>" data-location="<?php echo $row['location']; ?>">Edit</button></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <?php
    include 'config.php'; // Ensure this file includes database connection setup

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_order_status') {
        $orderId = $_POST['orderId'];

        // Perform SQL update query
        $updateSql = "UPDATE bookings SET order_status = 'complete' WHERE booking_id = $orderId";

        if (mysqli_query($conn, $updateSql)) {
            echo "Order status updated successfully!";
        } else {
            echo "Error updating order status: " . mysqli_error($conn);
        }
    }

    // Your existing PHP code for fetching and displaying orders
    $sql = "SELECT bookings.booking_id, users.username, bookings.start_date AS booking_date, bookings.order_status 
        FROM bookings 
        JOIN users ON bookings.user_id = users.id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }
    ?>

    <div class="tab-pane fade" id="CustomerOrdersTab" role="tabpanel" aria-labelledby="CustomerOrders-tab">
        <div class="table-responsive mx-3 mt-3">
            <table class="table table-striped" id="ordersTable">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Booking Date</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['order_status']; ?></td>
                        <td>
                            <button class="btn btn-info view-order-btn" data-id="<?php echo $row['booking_id']; ?>">Complete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="orderDetailsBody">
                    <!-- Order details will be populated here via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printOrderDetails()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
        <?php
        // Include your database connection configuration file
        include 'config.php';

        // Fetch all bookings from bookings_transaction table
        $sql = "SELECT id, user_id, car_id, booking_date, order_status FROM bookings_transaction";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error fetching bookings: " . mysqli_error($conn);
            exit();
        }

        // Process form submission for updating order status
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id']) && isset($_POST['action'])) {
            $bookingId = $_POST['booking_id'];
            $action = $_POST['action'];

            // Prepare and execute the SQL update query
            $updateSql = "UPDATE bookings_transaction SET order_status = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateSql);

            if ($stmt === false) {
                echo "Error preparing statement: " . mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($stmt, "si", $action, $bookingId);
                if (mysqli_stmt_execute($stmt)) {
                    // Success message (optional)
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          Order status updated successfully.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                } else {
                    echo "Error updating order status: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            }
        }

        // Reset $result pointer to beginning for displaying bookings
        mysqli_data_seek($result, 0);
        ?>
        <div class="table-responsive mx-3 mt-3">
            <table class="table table-striped" id="ordersTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Car ID</th>
                    <th>Booking Date</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['car_id']; ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['order_status']; ?></td>
                        <td>
                            <?php if ($row['order_status'] !== 'complete'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="complete">
                                    <button type="submit" class="btn btn-info" onclick="return confirm('Are you sure you want to mark this order as complete?');">Complete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php
        mysqli_close($conn);
        ?>
    </div>


</div>
<!-- Initialize DataTables -->
<script src="js/car.js"></script>

<!-- Bootstrap JS (jQuery and Popper.js required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS (including Popper.js if using Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>


