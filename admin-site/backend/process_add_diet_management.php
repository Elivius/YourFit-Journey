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

$melId = sanitizeInt($_POST['melId']);
$ingredientIds = $_POST['ingId'] ?? [];
$baseGrams = $_POST['baseGrams'] ?? [];

if (!$melId || empty($ingredientIds) || empty($baseGrams) || count($ingredientIds) !== count($baseGrams)) {
    $_SESSION['error'] = "Please fill in all required fields correctly";
    header("Location: ../frontend/diet_management.php");
    exit;
}

$sql_insert = "INSERT INTO meal_ingredients_t (mel_id, ing_id, mi_base_grams) VALUES (?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    
    $successCount = 0;

    for ($i = 0; $i < count($ingredientIds); $i++) {
        $ingId = sanitizeInt($ingredientIds[$i]);
        $baseGram = sanitizeFloat($baseGrams[$i]);

        if (!$ingId || !$baseGram) continue;

        mysqli_stmt_bind_param($stmt, "iid", $melId, $ingId, $baseGram);
        
        if (mysqli_stmt_execute($stmt)) {
            $successCount++;
        } else {
            $_SESSION['error'] = "Failed to add ingredient with ID: $ingId. Error: " . mysqli_error($connection);
            header("Location: ../frontend/diet_management.php");
            exit;
        }
    }

    mysqli_stmt_close($stmt);
    
    if ($successCount > 0) {
        $_SESSION['success'] = "$successCount ingredient(s) added successfully for meal ID: $melId";
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