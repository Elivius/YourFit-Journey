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
$ingredient_ids = $_POST['ingId'] ?? [];
$base_grams = $_POST['baseGrams'] ?? [];

if (!$meal_ingredient_id || !$mel_id || empty($ingredient_ids) || empty($base_grams) || count($ingredient_ids) !== count($base_grams)) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/diet_management.php");
    exit;
}

$sql_update = "UPDATE meal_ingredients_t 
                SET mel_id = ?, ing_id = ?, mi_base_grams = ? 
                WHERE mi_id = ?";
if ($stmt = mysqli_prepare($connection, $sql_update)) {

    $successCount = 0;

    for ($i = 0; $i < count($ingredient_ids); $i++) {
        $ing_id = sanitizeInt($ingredient_ids[$i]);
        $base_gram = sanitizeFloat($base_grams[$i]);

        if (!$ing_id || !$base_gram) continue;

        mysqli_stmt_bind_param($stmt, "iid", $mel_id, $ing_id, $base_gram);

        if (mysqli_stmt_execute($stmt)) {
            $successCount++;
        } else {
            $_SESSION['error'] = "Failed to add ingredient with ID: $ing_id. Error: " . mysqli_error($connection);
            header("Location: ../frontend/diet_management.php");
            exit;
        }
    }

    mysqli_stmt_close($stmt);
    
    if ($successCount > 0) {
        $_SESSION['success'] = "$successCount ingredient(s) added successfully for meal ID: $mel_id";
    } else {
        $_SESSION['error'] = "Failed to add ingredients";
    }
} else {
    $_SESSION['error'] = "Prepare statement failed: " . mysqli_error($connection);
}

mysqli_close($connection);
header("Location: ../frontend/diet_management.php");
exit;
?>