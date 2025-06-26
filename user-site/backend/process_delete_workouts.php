<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset(); // Unset all session to prevent user back to previous webpage
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : null;

if (!$workout_id) {
    $_SESSION['error'] = "Invalid request";
    header("Location: ../frontend/workouts.php");
    exit;
}

// Check if workout belongs to the current user
$check_sql = "SELECT workout_id FROM workouts_t WHERE workout_id = ? AND user_id = ?";
if ($stmt = mysqli_prepare($connection, $check_sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $workout_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        mysqli_stmt_close($stmt);
        $_SESSION['error'] = "Unauthorized access";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error'] = "Database error: " . mysqli_error($connection);
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}

// Begin transaction (group multiple changes together and decide when to apply or cancel them)
mysqli_begin_transaction($connection);

// Delete from workout_exercise_t
$delete_sql_1 = "DELETE FROM workout_exercises_t WHERE workout_id = ?";
if ($stmt1 = mysqli_prepare($connection, $delete_sql_1)) {
    mysqli_stmt_bind_param($stmt1, "i", $workout_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
} else {
    mysqli_rollback($connection);
    $_SESSION['error'] = "Error deleting workout exercises";
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}

// Delete from workouts_t
$delete_sql_2 = "DELETE FROM workouts_t WHERE workout_id = ? AND user_id = ?";
if ($stmt2 = mysqli_prepare($connection, $delete_sql_2)) {
    mysqli_stmt_bind_param($stmt2, "ii", $workout_id, $user_id);
    mysqli_stmt_execute($stmt2);

    if (mysqli_stmt_affected_rows($stmt2) === 1) {
        mysqli_commit($connection);
        $_SESSION['success'] = "Workout deleted successfully";
    } else {
        mysqli_rollback($connection);
        $_SESSION['error'] = "Failed to delete workout";
    }

    mysqli_stmt_close($stmt2);
} else {
    mysqli_rollback($connection);
    $_SESSION['error'] = "Error deleting workout.";
}

header("Location: ../frontend/workouts.php?section=my-workouts");
exit;
?>