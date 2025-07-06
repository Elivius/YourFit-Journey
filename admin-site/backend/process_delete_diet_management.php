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

$mealIngredientIds = $_POST['mealIngredientIds'] ?? [];

if (!is_array($mealIngredientIds) || empty($mealIngredientIds)) {
    $_SESSION['error'] = "No diet item selected";
    header("Location: ../frontend/diet_management.php");
    exit;
}

$deletedCount = 0;

foreach ($mealIngredientIds as $id) {
    $meal_ingredient_id = sanitizeInt($id);
    if (!$meal_ingredient_id) continue;

    $sql = "DELETE FROM meal_ingredients_t WHERE mi_id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $meal_ingredient_id);
        if (mysqli_stmt_execute($stmt)) {
            $deletedCount++;
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Prepare failed: " . mysqli_error($connection));
    }
}

if ($deletedCount > 0) {
    $_SESSION['success'] = "$deletedCount diet item(s) deleted successfully";
} else {
    $_SESSION['error'] = "No diet items were deleted";
}

header("Location: ../frontend/diet_management.php");
exit;
?>