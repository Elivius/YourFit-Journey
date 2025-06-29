<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$workout_id = isset($_POST['workout_id']) && is_numeric($_POST['workout_id']) ? intval($_POST['workout_id']) : null;
$workout_name = isset($_POST['workout_name']) ? trim($_POST['workout_name']) : null;
$estimated_duration = isset($_POST['estimated_duration']) && is_numeric($_POST['estimated_duration']) ? intval($_POST['estimated_duration']) : null;

if (!$workout_id || !$workout_name || !$estimated_duration) {
    $_SESSION['error'] = "Missing workout details";
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}

// Optional: Prevent duplicate entry for same user/workout on same day
$sql_check = "SELECT 1 FROM workout_logs_t WHERE user_id = ? AND workout_id = ? AND DATE(created_at) = CURDATE()";
if ($stmt = mysqli_prepare($connection, $sql_check)) {
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $workout_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Workout already logged today";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }
    mysqli_stmt_close($stmt);
}

// Insert new workout log
$sql_insert = "INSERT INTO workout_logs_t (user_id, workout_id, workout_name, estimated_duration) VALUES (?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param($stmt, "iisi", $user_id, $workout_id, $workout_name, $estimated_duration);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 1) {
        $_SESSION['success'] = "Workout logged successfully";
    } else {
        $_SESSION['error'] = "Workout not logged. Please try again";
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Workout insert prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Failed to log workout";
}

header("Location: ../frontend/workouts.php?section=my-workouts");
exit;
