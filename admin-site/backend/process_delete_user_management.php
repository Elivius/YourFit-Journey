<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../../user-site/frontend/login.php");
    exit;
}

$user_id = sanitizeInt($_POST['user_id'] ?? '');

if (!$user_id) {
    $_SESSION['error'] = "Invalid user ID";
    header("Location: ../frontend/user_management.php");
    exit;
}

// Check if the user is an admin
$check_role_SQL = "SELECT usr_role FROM users_t WHERE usr_id = ?";
if ($stmt = mysqli_prepare($connection, $check_role_SQL)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $role);
    if (mysqli_stmt_fetch($stmt)) {
        if ($role === 'admin') {
            $_SESSION['error'] = "Cannot delete an admin user";
            mysqli_stmt_close($stmt);
            header("Location: ../frontend/user_management.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "User not found";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/user_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/user_management.php");
    exit;
}

// Proceed to delete the user
$sql = "DELETE FROM users_t WHERE usr_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "User deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete user";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
}

header("Location: ../frontend/user_management.php");
exit;
?>