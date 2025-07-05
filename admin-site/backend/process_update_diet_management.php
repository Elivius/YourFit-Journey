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

$meal_ingredient_id = sanitizeInt($_POST['mealIngredientId'] ?? '');
$mel_id = sanitizeInt($_POST['melId'] ?? '');
$ingredient_id = sanitizeInt($_POST['ingId'] ?? '');
$base_grams = sanitizeInt($_POST['baseGrams'] ?? '');

if (!$meal_ingredient_id || !$mel_id || !$ingredient_id || !$base_grams) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/diet_management.php");
    exit;
}

// Check if the ingredient ID exists in the ingredients_t table
$check_ing_sql = "SELECT 1 FROM ingredients_t WHERE ing_id = ?";
if ($check_stmt = mysqli_prepare($connection, $check_ing_sql)) {
    mysqli_stmt_bind_param($check_stmt, "i", $ingredient_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) === 0) {
        $_SESSION['error'] = "Selected ingredient does not exist";
        mysqli_stmt_close($check_stmt);
        header("Location: ../frontend/diet_management.php");
        exit;
    }
    mysqli_stmt_close($check_stmt);
} else {
    $_SESSION['error'] = "Error checking ingredient: " . mysqli_error($connection);
    header("Location: ../frontend/diet_management.php");
    exit;
}

$sql_update = "UPDATE meal_ingredients_t 
                SET mel_id = ?, ing_id = ?, mi_base_grams = ? 
                WHERE mi_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_update)) {
    mysqli_stmt_bind_param($stmt, "iidi", $mel_id, $ingredient_id, $base_grams, $meal_ingredient_id);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['success'] = "Diet updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update Diet or no changes made";        
        error_log("Diet update error: " . mysqli_stmt_error($stmt));
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}

mysqli_close($connection);
header("Location: ../frontend/diet_management.php");
exit;
?>