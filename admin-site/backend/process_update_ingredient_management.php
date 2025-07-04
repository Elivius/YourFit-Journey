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

$ingredient_id = sanitizeInt($_POST['ingredientId'] ?? '');
$ingredient_name = cleanInput($_POST['ingredientName'] ?? '');
$protein = sanitizeFloat($_POST['protein'] ?? '');
$carbs = sanitizeFloat($_POST['carbs'] ?? '');
$fats = sanitizeFloat($_POST['fats'] ?? '');
$calories = sanitizeFloat($_POST['calories'] ?? '');


if (!$ingredient_id || !$ingredient_name || $protein === false || $carbs === false || $fats === false || $calories === false) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/ingredient_management.php");
    exit;
}

$sql_update = "UPDATE ingredients_t 
               SET ing_name = ?, 
                   ing_protein_per_100g = ?, 
                   ing_carbs_per_100g = ?, 
                   ing_fats_per_100g = ?, 
                   ing_calories_per_100g = ?
               WHERE ing_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_update)) {
    mysqli_stmt_bind_param($stmt, "sddddi", $ingredient_name, $protein, $carbs, $fats, $calories, $ingredient_id);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['success'] = "Ingredient updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update ingredient or no changes made";
        error_log("Ingredient update error: " . mysqli_stmt_error($stmt));
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}

header("Location: ../frontend/ingredient_management.php");
exit;
?>