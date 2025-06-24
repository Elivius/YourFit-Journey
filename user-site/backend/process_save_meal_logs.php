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

$meal_name = cleanInput($_POST['meal_name'] ?? '');
$protein = sanitizeFloat($_POST['protein'] ?? '');
$carbs = sanitizeFloat($_POST['carbs'] ?? '');
$fats = sanitizeFloat($_POST['fats'] ?? '');
$calories = sanitizeFloat($_POST['calories'] ?? '');
$category = cleanInput($_POST['category'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

$sql_insert_meal_log = "INSERT INTO user_meal_logs_t (user_id, meal_name, category, protein_g, carbs_g, fats_g, calories) VALUES (?, ?, ?, ?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert_meal_log)) {
    mysqli_stmt_bind_param($stmt, 'issdddd', $user_id, $meal_name, $category, $protein, $carbs, $fats, $calories);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) === 1) {
        $_SESSION['success'] = "Meal successfully logged";
        header("Location: ../frontend/nutrition.php");
        exit;
    } else {
        $_SESSION['error'] = "Meal not logged. Please try again";
        error_log("Insert executed but affected 0 rows for user_id=$user_id");
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Meal insert prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Failed to log meals";
    header("Location: ../frontend/nutrition.php");
    exit;
}
?>