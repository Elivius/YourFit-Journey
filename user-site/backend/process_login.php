<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

// Sanitize and validate input
$email = sanitizeEmail($_POST['email'] ?? '');
$password = sanitizePassword($_POST['password'] ?? '');

if (!$email || empty($password)) {
    $_SESSION['error'] = "Email and password are required";
    header("Location: ../frontend/login.php");
    exit;
}

// Fetch user from database
$sql = "SELECT user_id, email, password, role FROM users WHERE email = ?";

if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            // Secure session handling
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id']   = $user['user_id'];

            mysqli_stmt_close($stmt);

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: ../admin-site/frontend/dashboard.php');
            } else {
                header('Location: ../frontend/dashboard.php');
            }
            exit;
        }
    }

    // If no user or password mismatch
    $_SESSION['error'] = "Incorrect email or password";
    mysqli_stmt_close($stmt);
    header("Location: ../frontend/login.php");
    exit;
} else {
    error_log('Statement preparation failed: ' . mysqli_error($connection));
    $_SESSION['error'] = "Server error. Please try again later.";
    header("Location: ../frontend/login.php");
    exit;
}