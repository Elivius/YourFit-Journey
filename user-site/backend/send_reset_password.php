<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['target_form'] = 'forgotPasswordForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/forgot-password.php");
    exit;
}

$email = sanitizeEmail($_POST['email'] ?? '');
$_SESSION['target_form'] = 'forgotPasswordForm';

if (!$email) {
    $_SESSION['error'] = "Please enter a valid email";
    header("Location: ../frontend/forgot-password.php");
    exit;
}

// Check if email exists
$sql = "SELECT usr_id FROM users_t WHERE usr_email = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // Generate token
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $update_sql = "UPDATE users_t SET usr_reset_token = ?, usr_token_expiry = ? WHERE usr_email = ?";
        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param($update_stmt, 'sss', $token, $expiry, $email);
        mysqli_stmt_execute($update_stmt);

        // Send email
        $reset_link = "http://yourfitjourney.com/user-site/frontend/reset_password.php?token=$token";
        $message = "Click to reset your password: $reset_link";
        mail($email, "Password Reset Request", $message);

        $_SESSION['success'] = "A reset link has been sent to your email";
        header("Location: ../frontend/forgot-password.php");
        exit;
    } else {
        $_SESSION['error'] = "Email not found";
        header("Location: ../frontend/forgot-password.php");
        exit;
    }
} else {
    error_log("SQL Error: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error. Please try again later.";
    header("Location: ../frontend/forgot-password.php");
    exit;
}
?>
