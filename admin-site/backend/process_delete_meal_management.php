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

$meal_id = sanitizeInt($_POST['meal_id'] ?? '');

if (!$meal_id) {
    $_SESSION['error'] = "Invalid meal ID";
    header("Location: ../frontend/meal_management.php");
    exit;
}

// Check if the meal is currently used in diet management
$check_usage_sql = "SELECT 1 FROM meal_ingredients_t WHERE mel_id = ? LIMIT 1";
if ($stmt = mysqli_prepare($connection, $check_usage_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "This meal is currently used in diet management and cannot be deleted";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/meal_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error while checking meal usage";
    header("Location: ../frontend/meal_management.php");
    exit;
}

// Proceed to delete the meal
$sql = "DELETE FROM meals_t WHERE mel_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Meal deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete meal";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
}

header("Location: ../frontend/meal_management.php");
exit;
?>