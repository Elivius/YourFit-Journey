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

$exercise_id = sanitizeInt($_POST['exerciseId'] ?? '');
$exercise_name = cleanInput($_POST['exerciseName'] ?? '');
$image_url = cleanInput($_POST['imageUrl'] ?? '');
$category = cleanInput($_POST['category'] ?? '');
$target_muscle = cleanInput($_POST['targetMuscle'] ?? '');
$instructions = cleanInput($_POST['instructions'] ?? '');

if (!$exercise_id || !$exercise_name || !$image_url || !$category || !$target_muscle || !$instructions) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/exercise_management.php");
    exit;
}

$sql_update = "UPDATE exercises_t 
               SET exe_name = ?, 
                   exe_image_url = ?, 
                   exe_category = ?, 
                   exe_targeted_muscle = ?, 
                   exe_instructions = ?
               WHERE exe_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_update)) {
    mysqli_stmt_bind_param($stmt, "sssssi", $exercise_name, $image_url, $category, $target_muscle, $instructions, $exercise_id);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['success'] = "Exercise updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update exercise or no changes made";        
        error_log("Exercise update error: " . mysqli_stmt_error($stmt));
    }
    
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($connection);
}
mysqli_close($connection);
header("Location: ../frontend/exercise_management.php");
exit;
?>