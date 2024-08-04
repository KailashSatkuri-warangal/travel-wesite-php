<?php
session_start(); // Start session if not already started
include 'config.php'; // Include database connection file
// Handle login form submission
if(isset($_POST['signIn'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = md5($password); // Hash password for comparison

    // Check if user exists with given email and password
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        // Start session and store email in session variable
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: index.php"); // Redirect to homepage after successful login
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>

<?php
// Handle registration form submission
if(isset($_POST['signUp'])){
    // Sanitize and assign form data to variables
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password = md5($password); // Hash password for security

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists !";
    } else {
        // Prepare INSERT statement using a prepared statement
        $insertQuery = "INSERT INTO users (username, firstName, lastName, email, password, phone_number, role)
                        VALUES (?, ?, ?, ?, ?, ?, 'user')";

        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssss", $username, $firstName, $lastName, $email, $password, $phone_number);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Log in the user automatically after successful registration
            $_SESSION['email'] = $email;
            header("location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="signup-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 signup-content">
                <h1>Welcome! 🎉</h1>
                <p>Join us and explore amazing features. 🌟</p>
                <form id="signupForm" method="post" action="#">
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" pattern=".{10,12}" maxlength="12" placeholder="Username (10-12 characters)" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]{10}" maxlength="10" placeholder="Phone number" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required >
                        <small class="form-text text-muted">Valid domains: @gmail.com, @hotmail.com, @yahoo.com, @outlook.com, @icloud.com</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" pattern=".{10,12}" maxlength="12" placeholder="Password (10-12)" required>
                    </div>
                    <!-- OTP input field -->
                    <button type="submit" class="btn btn-primary" name="signUp">Sign Up</button>
                </form>
                <p>Already have an account? <a href="index.php">Login here</a></p>
            </div>
            <div class="col-md-6">
                <img src="assets/signpic.jpg" alt="Signup Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#signupForm').submit(function(e) {
            // Check if email ends with @gmail.com
            var email = $('#email').val().trim();
            if (!email.endsWith('@gmail.com')) {
                alert('Please use a valid @gmail.com email address.');
                e.preventDefault(); // Prevent form submission
            }
        });
    });
</script>
</body>
</html>