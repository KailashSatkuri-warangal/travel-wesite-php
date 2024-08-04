<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    $_SESSION['upload_error'] = "Session expired. Please log in again.";
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Check if a file was uploaded
if ($_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    // Validate file type if necessary
    $fileType = strtolower(pathinfo($_FILES['profilePic']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
        $_SESSION['upload_invalid'] = "Sorry, only JPG, JPEG, and PNG files are allowed.";
        header("Location: profile.php");
        exit();
    }

    // Move uploaded file to target directory
    $targetDir = 'uploads/';
    $newFileName = uniqid('profile_', true) . '.' . $fileType;
    $targetFilePath = $targetDir . $newFileName;

    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFilePath)) {
        // Update profile picture path in the database
        $sql = "UPDATE users SET profile_pic = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $targetFilePath, $email);

        if ($stmt->execute()) {
            $_SESSION['profile_pic'] = $targetFilePath; // Update session with new profile picture path
            $_SESSION['upload_success'] = "Profile picture uploaded successfully.";
        } else {
            $_SESSION['upload_error'] = "Error updating profile picture: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $_SESSION['upload_error'] = "Sorry, there was an error uploading your file.";
    }
} else {
    $_SESSION['upload_error'] = "Upload error: " . $_FILES['profilePic']['error'];
}

header("Location: profile.php");
exit();
?>
