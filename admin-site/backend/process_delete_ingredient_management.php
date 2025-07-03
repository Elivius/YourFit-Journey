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

$ingredient_id = sanitizeInt($_POST['ingredient_id'] ?? '');

if (!$ingredient_id) {
    $_SESSION['error'] = "Invalid ingredient ID";
    header("Location: ../frontend/ingredient_management.php");
    exit;
}

// Check if the ingredient is currently used in diet management
$check_usage_sql = "SELECT 1 FROM meal_ingredients_t WHERE ing_id = ? LIMIT 1";
if ($stmt = mysqli_prepare($connection, $check_usage_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $ingredient_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "This ingredient is currently used in diet management and cannot be deleted";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/ingredient_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error while checking ingredient usage";
    header("Location: ../frontend/ingredient_management.php");
    exit;
}

// Proceed to delete the ingredient
$sql = "DELETE FROM ingredients_t WHERE ing_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $ingredient_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Ingredient deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete ingredient";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
}

header("Location: ../frontend/ingredient_management.php");
exit;
?>