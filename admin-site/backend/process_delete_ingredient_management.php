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

$ingredientIds = $_POST['ingredientIds'] ?? [];

if (!is_array($ingredientIds) || empty($ingredientIds)) {
    $_SESSION['error'] = "No ingredients selected";
    header("Location: ../frontend/ingredient_management.php");
    exit;
}

$deletedCount = 0;
$skippedCount = 0;

foreach ($ingredientIds as $id) {
    $ingredient_id = sanitizeInt($id);
    if (!$ingredient_id) continue;

    // Check if used in meal_ingredients_t
    $check_sql = "SELECT 1 FROM meal_ingredients_t WHERE ing_id = ? LIMIT 1";
    $stmt = mysqli_prepare($connection, $check_sql);
    mysqli_stmt_bind_param($stmt, "i", $ingredient_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $skippedCount++;
        mysqli_stmt_close($stmt);
        continue;
    }
    mysqli_stmt_close($stmt);

    // Delete ingredient
    $delete_sql = "DELETE FROM ingredients_t WHERE ing_id = ?";
    $stmt = mysqli_prepare($connection, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $ingredient_id);
    if (mysqli_stmt_execute($stmt)) {
        $deletedCount++;
    }
    mysqli_stmt_close($stmt);
}

if ($deletedCount > 0) {
    $_SESSION['success'] = "$deletedCount ingredient(s) deleted successfully";
}
if ($skippedCount > 0) {
    $_SESSION['error'] = "$skippedCount ingredient(s) could not be deleted as they are in use in diet plans";
}
if ($deletedCount === 0 && $skippedCount === 0) {
    $_SESSION['error'] = "No valid ingredients to delete";
}

header("Location: ../frontend/ingredient_management.php");
exit;
?>