<?php
include 'config.php';
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Function to fetch admin user ID
function getAdminUserId($conn, $email) {
    $query = "SELECT id FROM users WHERE email = ? AND role = 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null;
    }
}

// Fetch admin user ID
$email = $_SESSION['email'];
$adminUserId = getAdminUserId($conn, $email);

if ($adminUserId === null) {
    $_SESSION['upload_status'] = 'error';
    echo "Error: Admin user ID not found.";
    exit();
}

// Proceed with handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user inputs for security
    $carName = mysqli_real_escape_string($conn, $_POST['car_name']);
    $seatingCapacity = mysqli_real_escape_string($conn, $_POST['seating_capacity']);
    $carCategory = mysqli_real_escape_string($conn, $_POST['car_category']);
    $acOption = mysqli_real_escape_string($conn, $_POST['ac_option']);
    $nonAcOption = mysqli_real_escape_string($conn, $_POST['non_ac_option']);
    $cancellationPolicy = mysqli_real_escape_string($conn, $_POST['cancellation_policy']);

    // File upload handling
    $imagePath = 'uploads/' . basename($_FILES['image_path']['name']);
    if (move_uploaded_file($_FILES['image_path']['tmp_name'], $imagePath)) {
        // SQL query to insert data into `cars` table
        $sql = "INSERT INTO cars (car_name, seating_capacity, car_category, ac_option, non_ac_option, cancellation_policy, image_path, uploaded_by, created_at)
                VALUES ('$carName', $seatingCapacity, '$carCategory', $acOption, $nonAcOption, '$cancellationPolicy', '$imagePath', $adminUserId, NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['upload_status'] = 'success';
        } else {
            $_SESSION['upload_status'] = 'error';
            echo "Error: " . mysqli_error($conn); // Output the SQL error for debugging
        }
    } else {
        $_SESSION['upload_status'] = 'error';
        echo "Error: File upload failed.";
    }

    mysqli_close($conn); // Close database connection

    // Redirect to admin_panel.php after processing
    header("Location: admin_panel.php");
    exit(); // Ensure no further code execution after redirection
}
?>


<?php
include('config.php');

// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Initialize variables
$carId = $carName = $seatingCapacity = $carCategory = $acOption = $nonAcOption = $cancellationPolicy = $imagePath = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize inputs
    $carId = mysqli_real_escape_string($conn, $_POST['car_id']);
    $carName = mysqli_real_escape_string($conn, $_POST['car_name']);
    $seatingCapacity = mysqli_real_escape_string($conn, $_POST['seating_capacity']);
    $carCategory = mysqli_real_escape_string($conn, $_POST['car_category']);
    $acOption = mysqli_real_escape_string($conn, $_POST['ac_option']);
    $nonAcOption = mysqli_real_escape_string($conn, $_POST['non_ac_option']);
    $cancellationPolicy = mysqli_real_escape_string($conn, $_POST['cancellation_policy']);

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image_path']['name'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['image_path']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES['image_path']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['image_path']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                $_SESSION['upload_status'] = 'error';
                header("Location: admin_panel.php");
                exit();
            }
        } else {
            $_SESSION['upload_status'] = 'error';
            header("Location: admin_panel.php");
            exit();
        }
    }

    // Construct SQL query for updating car record
    $sql = "UPDATE cars SET car_name='$carName', seating_capacity=$seatingCapacity, car_category='$carCategory', ac_option=$acOption, non_ac_option=$nonAcOption, cancellation_policy='$cancellationPolicy'";

    // Add image update to SQL query if image was uploaded
    if (!empty($imagePath)) {
        $sql .= ", image_path='$imagePath'";
    }

    $sql .= " WHERE id=$carId";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['upload_status'] = 'success';
    } else {
        $_SESSION['upload_status'] = 'error';
    }

    // Process image captions
    if (!empty($_POST['image_caption'])) {
        $captions = explode("\n", $_POST['image_caption']);
        foreach ($captions as $caption) {
            $caption = trim($caption);
            if (!empty($caption)) {
                // Insert caption into car_images table
                $caption = mysqli_real_escape_string($conn, $caption);
                $insertSql = "INSERT INTO car_images (car_id, image_path, caption) VALUES ($carId, '$imagePath', '$caption')";
                mysqli_query($conn, $insertSql);
            }
        }
    }

    // Redirect to admin panel or appropriate page
    header("Location: admin_panel.php");
    exit();
}

// Fetch car details if editing
if (isset($_GET['id'])) {
    $carId = mysqli_real_escape_string($conn, $_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM cars WHERE id=$carId");
    $car = mysqli_fetch_assoc($result);
}
?>
