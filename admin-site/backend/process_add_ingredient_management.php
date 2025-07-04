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

$ingredient_name = cleanInput($_POST['ingredientName']);
$protein = sanitizeFloat($_POST['protein']);
$carbs = sanitizeFloat($_POST['carbs']);
$fats = sanitizeFloat($_POST['fats']);
$calories = sanitizeFloat($_POST['calories']);


if (!$ingredient_name || $protein === false || $carbs === false || $fats === false || $calories === false) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/ingredient_management.php");
    exit;
}

$sql_insert = "INSERT INTO ingredients_t (ing_name, ing_protein_per_100g, ing_carbs_per_100g, ing_fats_per_100g, ing_calories_per_100g) VALUES (?, ?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param($stmt, "sdddd", $ingredient_name, $protein, $carbs, $fats, $calories);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Ingredient added successfully";
    } else {
        $_SESSION['error'] = "Error adding ingredient: " . mysqli_error($connection);
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}
mysqli_close($connection);
header("Location: ../frontend/ingredient_management.php");
exit;
?>