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

$exerciseName = cleanInput($_POST['exerciseName']);
$imageUrl = cleanInput($_POST['imageUrl']);
$category = cleanInput($_POST['category']);
$targetMuscle = cleanInput($_POST['targetMuscle']);
$instructions = cleanInput($_POST['instructions']);

if (!$exerciseName || !$imageUrl || !$category || !$targetMuscle || !$instructions) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/exercise_management.php");
    exit;
}

$sql_insert = "INSERT INTO exercises_t (exe_name, exe_image_url, exe_category, exe_targeted_muscle, exe_instructions) VALUES (?, ?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param($stmt, "sssss", $exerciseName, $imageUrl, $category, $targetMuscle, $instructions);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Exercise added successfully";
    } else {
        $_SESSION['error'] = "Error adding exercise: " . mysqli_error($connection);
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}
mysqli_close($connection);
header("Location: ../frontend/exercise_management.php");
exit;
?>