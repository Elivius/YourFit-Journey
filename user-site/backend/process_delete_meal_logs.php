<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset(); // Unset all session to prevent user back to previous webpage
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$meal_id = isset($_POST['meal_id']) ? intval($_POST['meal_id']) : null;

if (!$meal_id) {
    $_SESSION['error'] = "Invalid request";
    header("Location: ../frontend/nutrition.php");
    exit;
}

$sql_delete = "DELETE FROM user_meal_logs_t WHERE uml_id = ? AND usr_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_delete)) {
    mysqli_stmt_bind_param($stmt, 'ii', $meal_id, $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 1) {
        $_SESSION['success'] = "Meal deleted successfully";
    } else {
        $_SESSION['error'] = "Meal not found or unauthorized";
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Delete prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Database error";
}

header("Location: ../frontend/nutrition.php");
exit;
?>