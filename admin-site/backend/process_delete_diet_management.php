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

$meal_ingredient_id = sanitizeInt($_POST['meal_ingredient_id'] ?? '');

if (!$meal_ingredient_id) {
    $_SESSION['error'] = "Invalid meal ingredient ID";
    header("Location: ../frontend/diet_management.php");
    exit;
}

// Proceed to delete the meal ingredient
$sql = "DELETE FROM meal_ingredients_t WHERE mi_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $meal_ingredient_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Meal ingredient deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete meal ingredient";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
}

header("Location: ../frontend/diet_management.php");
exit;
?>