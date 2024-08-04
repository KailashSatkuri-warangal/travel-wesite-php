<?php
include 'config.php';
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle POST request to update user role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_role') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    // Prepare and execute SQL query
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $role, $user_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Role updated successfully
            echo '<script>alert("Role updated successfully."); window.location.href = "admin_panel.php";</script>';
            exit();
        } else {
            // No rows affected, handle error
            echo '<script>alert("Failed to update role."); window.location.href = "admin_panel.php";</script>';
            exit();
        }
    } else {
        // SQL statement preparation failed
        echo '<script>alert("SQL error occurred."); window.location.href = "admin_panel.php";</script>';
        exit();
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $user_id = $_POST['user_id'];

    // Retrieve user data before deleting
    $sql_select_user = "SELECT * FROM users WHERE id = ?";
    $stmt_select_user = mysqli_prepare($conn, $sql_select_user);

    if ($stmt_select_user) {
        mysqli_stmt_bind_param($stmt_select_user, "i", $user_id);
        mysqli_stmt_execute($stmt_select_user);
        $result = mysqli_stmt_get_result($stmt_select_user);

        if ($row = mysqli_fetch_assoc($result)) {
            // Insert user data into temp_users table
            $sql_insert_temp = "INSERT INTO temp_users (username, email, phone_number, role)
                                VALUES (?, ?, ?, ?)";
            $stmt_insert_temp = mysqli_prepare($conn, $sql_insert_temp);

            if ($stmt_insert_temp) {
                mysqli_stmt_bind_param($stmt_insert_temp, "ssss", $row['username'], $row['email'], $row['phone_number'], $row['role']);
                mysqli_stmt_execute($stmt_insert_temp);

                if (mysqli_stmt_affected_rows($stmt_insert_temp) > 0) {
                    // User data moved to temp_users successfully, now delete from users table
                    $sql_delete_user = "DELETE FROM users WHERE id = ?";
                    $stmt_delete_user = mysqli_prepare($conn, $sql_delete_user);

                    if ($stmt_delete_user) {
                        mysqli_stmt_bind_param($stmt_delete_user, "i", $user_id);
                        mysqli_stmt_execute($stmt_delete_user);

                        if (mysqli_stmt_affected_rows($stmt_delete_user) > 0) {
                            // User deleted successfully
                            echo '<script>alert("User deleted successfully."); window.location.href = "admin_panel.php";</script>';
                            exit();
                        } else {
                            // No rows affected, handle error
                            echo '<script>alert("Failed to delete user."); window.location.href = "admin_panel.php";</script>';
                            exit();
                        }
                    } else {
                        // SQL statement preparation failed for delete from users
                        echo '<script>alert("SQL error occurred when deleting user."); window.location.href = "admin_panel.php";</script>';
                        exit();
                    }
                } else {
                    // Insert into temp_users failed
                    echo '<script>alert("Failed to move user data to temp_users table."); window.location.href = "admin_panel.php";</script>';
                    exit();
                }
            } else {
                // SQL statement preparation failed for insert into temp_users
                echo '<script>alert("SQL error occurred when moving user data to temp_users."); window.location.href = "admin_panel.php";</script>';
                exit();
            }
        } else {
            // No user found with the specified ID
            echo '<script>alert("User not found."); window.location.href = "admin_panel.php";</script>';
            exit();
        }
    } else {
        // SQL statement preparation failed for select from users
        echo '<script>alert("SQL error occurred when selecting user data."); window.location.href = "admin_panel.php";</script>';
        exit();
    }
}

?>
