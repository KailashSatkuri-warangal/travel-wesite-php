<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: profile.php");
    exit();
}
include 'config.php';
// Retrieve form data
$email = $_SESSION['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone_number = $_POST['phone_number'];

// Update user's profile in the database
$sql = "UPDATE users SET firstname = ?, lastname = ?, phone_number = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("ssss", $firstname, $lastname, $phone_number, $email);

if ($stmt->execute()) {
    // Redirect back to the profile page after successful update
    header("Location: profile.php");
    exit();
} else {
    echo "Error updating profile: " . htmlspecialchars($stmt->error);
}


$stmt->close();
$conn->close();
?>
