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

$mealName = cleanInput($_POST['mealName']);
$imageUrl = cleanInput($_POST['imageUrl']);
$category = cleanInput($_POST['category']);
$estimatedPrepMinutes = sanitizeInt($_POST['estimatedPrepMinutes']);

if (!$mealName || !$imageUrl || !$category || $estimatedPrepMinutes === null) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../../admin-site/frontend/meal_management.php");
    exit;
}

$sql_insert = "INSERT INTO meals_t (mel_name, mel_estimated_preparation_min, mel_image_url, mel_category) VALUES (?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param($stmt, "siss", $mealName, $estimatedPrepMinutes, $imageUrl, $category);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['success'] = "Meal added successfully";
    } else {
        $_SESSION['error'] = "Failed to add meal: " . mysqli_error($connection);
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}

header("Location: ../../admin-site/frontend/meal_management.php");
exit;
?>