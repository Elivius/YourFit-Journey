<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

$workout_name = cleanInput($_POST['workout_name'] ?? '');
$estimated_duration = sanitizeInt($_POST['estimated_duration'] ?? null);
$workout_description = cleanInput($_POST['workout_description'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id || empty($workout_name)) {
    $_SESSION['error'] = "Workout info is incomplete.";
    header("Location: ../frontend/my-workouts.php");
    exit;
}

// Insert into workouts
$sql_insert_workout = "INSERT INTO workouts_t (user_id, workout_name, estimated_duration, workout_description) VALUES (?, ?, ?, ?)";
if ($stmt = mysqli_prepare($connection, $sql_insert_workout)) {
    mysqli_stmt_bind_param($stmt, "isis", $user_id, $workout_name, $estimated_duration, $workout_description);
    mysqli_stmt_execute($stmt);
    $workout_id = mysqli_insert_id($connection);
    mysqli_stmt_close($stmt);
} else {
    error_log("Workout insert prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Failed to save workout.";
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}

// Insert each exercise
if (isset($_POST['exercises']) && is_array($_POST['exercises'])) {
    $sql_insert_exercise = "INSERT INTO workout_exercises_t (workout_id, exercise_id, sets, reps, rest, weight, notes) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $sql_insert_exercise)) {
        foreach ($_POST['exercises'] as $exercise) {
            $exercise_id = sanitizeInt($exercise['id']);
            $sets = sanitizeInt($exercise['sets']);
            $reps = cleanInput($exercise['reps']); // Could be a string like "10-12"
            $rest = sanitizeInt($exercise['rest']);
            $weight = cleanInput($exercise['weight']); // Could be string (e.g. "bodyweight")
            $notes = cleanInput($exercise['notes']);

            mysqli_stmt_bind_param($stmt, "iiisiss", $workout_id, $exercise_id, $sets, $reps, $rest, $weight, $notes);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        $_SESSION['success'] = "Workout saved successfully.";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    } else {
        error_log("Exercise insert prepare failed: " . mysqli_error($connection));
        $_SESSION['error'] = "Failed to save exercises.";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }
} else {
    $_SESSION['error'] = "No exercises found.";
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}
?>
