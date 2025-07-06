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

$mealIds = $_POST['mealIds'] ?? [];

if (!is_array($mealIds) || empty($mealIds)) {
    $_SESSION['error'] = "No meals selected";
    header("Location: ../frontend/meal_management.php");
    exit;
}

$deletedCount = 0;
$skippedCount = 0;

foreach ($mealIds as $id) {
    $meal_id = sanitizeInt($id);
    if (!$meal_id) continue;

    // Check if used in meal_ingredients_t
    $check_sql = "SELECT 1 FROM meal_ingredients_t WHERE mel_id = ? LIMIT 1";
    $stmt = mysqli_prepare($connection, $check_sql);
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $skippedCount++;
        mysqli_stmt_close($stmt);
        continue;
    }
    mysqli_stmt_close($stmt);

    // Delete meal
    $delete_sql = "DELETE FROM meals_t WHERE mel_id = ?";
    $stmt = mysqli_prepare($connection, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    if (mysqli_stmt_execute($stmt)) {
        $deletedCount++;
    }
    mysqli_stmt_close($stmt);
}

if ($deletedCount > 0) {
    $_SESSION['success'] = "$deletedCount meal(s) deleted successfully";
}
if ($skippedCount > 0) {
    $_SESSION['error'] = "$skippedCount meal(s) could not be deleted as they are in use in diet plans";
}
if ($deletedCount === 0 && $skippedCount === 0) {
    $_SESSION['error'] = "No valid meals to delete";
}

header("Location: ../frontend/meal_management.php");
exit;
?>