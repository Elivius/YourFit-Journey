<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

$form_type = $_POST['form_type'] ?? '';

$category = cleanInput($_POST['category'] ?? '');
$subject = cleanInput($_POST['subject'] ?? '');
$message = cleanInput($_POST['message'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

$_SESSION['target_form'] = 'feedbackForm';

if (empty($category) || empty($subject) || empty($message)) {
    $_SESSION['error'] = "All fields are required";
    header("Location: ../frontend/settings.php?section=feedback");
    exit;
}

$sql_insert_feedback = "INSERT INTO feedbacks_t (usr_id, fdb_category, fdb_subject, fdb_message) VALUES (?, ?, ?, ?)";

if ($stmt = mysqli_prepare($connection, $sql_insert_feedback)) {
    mysqli_stmt_bind_param($stmt, 'isss', $user_id, $category, $subject, $message);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) === 1) {
        $_SESSION['success'] = "Feedback submitted successfully! We appreciate your feedback";
    } else {
        $_SESSION['error'] = "Failed to submit feedback";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Feedback insert prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "An error occurred. Please try again later.";
}

header("Location: ../frontend/settings.php?section=feedback");
exit;
?>
