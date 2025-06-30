<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset(); // Unset all session to prevent user back to previous webpage
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

// Sanitize and validate input
$email = sanitizeEmail($_POST['email'] ?? '');
$password = sanitizePassword($_POST['password'] ?? '');

if (!$email || empty($password)) {
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Email and password are required";
    header("Location: ../frontend/login.php");
    exit;
}

# Setup session to store user credentials
$_SESSION['email'] = $email;

// Fetch user from database
$sql_check = "SELECT usr_id, usr_first_name, usr_password, usr_role, usr_profile_pic FROM users_t WHERE usr_email = ?";

if ($stmt = mysqli_prepare($connection, $sql_check)) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['usr_password'])) {
            // Secure session handling
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id']   = $user['usr_id'];
            $_SESSION['role'] = $user['usr_role'];
            $_SESSION['name']   = $user['usr_first_name'];
            $_SESSION['pfp'] = !empty($user['usr_profile_pic']) ? $user['usr_profile_pic'] : 'default.jpg';

            unset($_SESSION['first-name'], $_SESSION['last-name'], $_SESSION['gender']);

            mysqli_stmt_close($stmt);

            // Redirect based on role
            if ($user['usr_role'] === 'admin') {
                header('Location: ../../admin-site/frontend/dashboard.php');
            } else if ($user['usr_role'] === 'user') {
                header('Location: ../frontend/dashboard.php');
            } else {
                $_SESSION['target_form'] = 'loginForm';
                $_SESSION['error'] = "Unauthorized access";
                header("Location: ../frontend/login.php");
            }
            exit;
        }
    }

    // If no user or password mismatch
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Incorrect email or password";
    mysqli_stmt_close($stmt);
    header("Location: ../frontend/login.php");
    exit;
} else {
    error_log('Statement preparation failed: ' . mysqli_error($connection));
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Server error. Please try again later";
    header("Location: ../frontend/login.php");
    exit;
}
?>