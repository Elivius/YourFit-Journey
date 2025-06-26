<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset(); // Unset all session to prevent user back to previous webpage
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";    
    header("Location: ../frontend/login.php");
    exit;
}

$workout_name = cleanInput($_POST['workout_name'] ?? '');
$estimated_duration = sanitizeInt($_POST['estimated_duration'] ?? null);
$workout_description = cleanInput($_POST['workout_description'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

if (empty($workout_name)) {
    $_SESSION['error'] = "Workout info is incomplete";
    header("Location: ../frontend/workouts-create.php");
    exit;
}

$workout_id = isset($_POST['workout_id']) && is_numeric($_POST['workout_id']) ? intval($_POST['workout_id']) : null;

if ($workout_id) {
    // Make sure this workout belongs to the current user
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
    }

    // UPDATE the workout details
    $sql_update_workout = "UPDATE workouts_t 
                           SET workout_name = ?, estimated_duration = ?, workout_description = ?
                           WHERE workout_id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($connection, $sql_update_workout)) {
        mysqli_stmt_bind_param($stmt, "sisii", $workout_name, $estimated_duration, $workout_description, $workout_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        mysqli_stmt_close($stmt);
        error_log("Workout update failed: " . mysqli_error($connection));
        $_SESSION['error'] = "Failed to update workout";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }

    // Delete all previous exercises linked to this workout
    $delete_sql = "DELETE FROM workout_exercises_t WHERE workout_id = ?";
    if ($stmt = mysqli_prepare($connection, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $workout_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Insert updated exercises again (fresh data)
    if (isset($_POST['exercises']) && is_array($_POST['exercises'])) {
        $sql_insert_exercise = "INSERT INTO workout_exercises_t (workout_id, exercise_id, sets, reps, rest, weight) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($connection, $sql_insert_exercise)) {
            foreach ($_POST['exercises'] as $exercise) {
                $exercise_id = sanitizeInt($exercise['id']);
                $sets = sanitizeInt($exercise['sets']);
                $reps = cleanInput($exercise['reps']);
                $rest = sanitizeInt($exercise['rest']);
                $weight = cleanInput($exercise['weight']);

                mysqli_stmt_bind_param($stmt, "iiisiss", $workout_id, $exercise_id, $sets, $reps, $rest, $weight);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
            $_SESSION['success'] = "Workout updated successfully.";
            header("Location: ../frontend/workouts.php?section=my-workouts");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            error_log("Exercise update insert failed: " . mysqli_error($connection));
            $_SESSION['error'] = "Failed to update exercises";
            header("Location: ../frontend/workouts.php?section=my-workouts");
            exit;
        }
    } else {
        $_SESSION['error'] = "No exercises in the workout";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }

} else {
    // Insert into workouts
    $sql_insert_workout = "INSERT INTO workouts_t (user_id, workout_name, estimated_duration, workout_description) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $sql_insert_workout)) {
        mysqli_stmt_bind_param($stmt, "isis", $user_id, $workout_name, $estimated_duration, $workout_description);
        mysqli_stmt_execute($stmt);
        $workout_id = mysqli_insert_id($connection);
        mysqli_stmt_close($stmt);
    } else {
        mysqli_stmt_close($stmt);
        error_log("Workout insert prepare failed: " . mysqli_error($connection));
        $_SESSION['error'] = "Failed to save workout";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }
    
    // Insert each exercise
    if (isset($_POST['exercises']) && is_array($_POST['exercises'])) {
        $sql_insert_exercise = "INSERT INTO workout_exercises_t (workout_id, exercise_id, sets, reps, rest, weight) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($connection, $sql_insert_exercise)) {
            foreach ($_POST['exercises'] as $exercise) {
                $exercise_id = sanitizeInt($exercise['id']);
                $sets = sanitizeInt($exercise['sets']);
                $reps = cleanInput($exercise['reps']); // Could be a string like "10-12"
                $rest = sanitizeInt($exercise['rest']);
                $weight = cleanInput($exercise['weight']); // Could be string (e.g. "bodyweight")
    
                mysqli_stmt_bind_param($stmt, "iiisiss", $workout_id, $exercise_id, $sets, $reps, $rest, $weight);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
            $_SESSION['success'] = "Workout saved successfully";
            header("Location: ../frontend/workouts.php?section=my-workouts");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            error_log("Exercise insert prepare failed: " . mysqli_error($connection));
            $_SESSION['error'] = "Failed to save exercises";
            header("Location: ../frontend/workouts.php?section=my-workouts");
            exit;
        }
    } else {
        $_SESSION['error'] = "No exercises in the workout";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }
}
?>