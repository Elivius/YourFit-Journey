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

$meal_id = isset($_POST['meal_id']) && is_numeric($_POST['meal_id']) ? intval($_POST['meal_id']) : null;

$meal_name = cleanInput($_POST['meal_name'] ?? '');
$protein = sanitizeFloat($_POST['protein'] ?? '');
$carbs = sanitizeFloat($_POST['carbs'] ?? '');
$fats = sanitizeFloat($_POST['fats'] ?? '');
$calories = sanitizeFloat($_POST['calories'] ?? '');
$category = cleanInput($_POST['category'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

if ($meal_id) {
    $sql_update = "UPDATE user_meal_logs_t SET meal_name = ?, category = ?, protein_g = ?, carbs_g = ?, fats_g = ?, calories = ? WHERE user_meal_log_id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($connection, $sql_update)) {
        mysqli_stmt_bind_param($stmt, 'ssddddii', $meal_name, $category, $protein, $carbs, $fats, $calories, $meal_id, $user_id);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) >= 0) {
            $_SESSION['success'] = "Meal successfully updated";
        } else {
            $_SESSION['error'] = "Meal not updated. Please try again";
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Meal update prepare failed: " . mysqli_error($connection));
        $_SESSION['error'] = "Failed to update meal";
    }
} else {
    $sql_insert_meal_log = "INSERT INTO user_meal_logs_t (user_id, meal_name, category, protein_g, carbs_g, fats_g, calories) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $sql_insert_meal_log)) {
        mysqli_stmt_bind_param($stmt, 'issdddd', $user_id, $meal_name, $category, $protein, $carbs, $fats, $calories);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) === 1) {
            $_SESSION['success'] = "Meal logged successfully";
        } else {
            $_SESSION['error'] = "Meal not logged. Please try again";
            error_log("Insert executed but affected 0 rows for user_id=$user_id");
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Meal insert prepare failed: " . mysqli_error($connection));
        $_SESSION['error'] = "Failed to log meal";
    }
}

header("Location: ../frontend/nutrition.php");
exit;
?>