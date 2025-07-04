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

$meal_id = sanitizeInt($_POST['mealId'] ?? '');
$meal_name = cleanInput($_POST['mealName'] ?? '');
$image_url = cleanInput($_POST['imageUrl'] ?? '');
$category = cleanInput($_POST['category'] ?? '');
$estimatedPrepMinutes = sanitizeInt($_POST['estimatedPrepMinutes'] ?? '');

if (!$meal_id || !$meal_name || !$image_url || !$category || $estimatedPrepMinutes === null) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../../admin-site/frontend/meal_management.php");
    exit;
}

$sql_update = "UPDATE meals_t 
               SET mel_name = ?, 
                   mel_estimated_preparation_min = ?, 
                   mel_image_url = ?, 
                   mel_category = ?
               WHERE mel_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_update)) {
    mysqli_stmt_bind_param($stmt, "sissi", $meal_name, $estimatedPrepMinutes, $image_url, $category, $meal_id);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['success'] = "Meal updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update meal or no changes made";
        error_log("Meal update error: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}

header("Location: ../../admin-site/frontend/meal_management.php");
exit;
?>