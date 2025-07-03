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

$exercise_id = sanitizeInt($_POST['exercise_id'] ?? '');

if (!$exercise_id) {
    $_SESSION['error'] = "Invalid exercise ID";
    header("Location: ../frontend/exercise_management.php");
    exit;
}

// Check if the exercise is currently used in any plans
$check_usage_sql = "SELECT 1 FROM workout_exercises_t WHERE exe_id = ? LIMIT 1";
if ($stmt = mysqli_prepare($connection, $check_usage_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $exercise_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "This exercise is currently used in workout plans and cannot be deleted";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/exercise_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error while checking exercise usage";
    header("Location: ../frontend/exercise_management.php");
    exit;
}

// Proceed to delete the exercise
$sql = "DELETE FROM exercises_t WHERE exe_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $exercise_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Exercise deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete exercise";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
}

header("Location: ../frontend/exercise_management.php");
exit;
?>