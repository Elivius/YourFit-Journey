<?php
require_once '../../utils/connection.php';
require_once '../../utils/sanitize.php';

$user_id = $_SESSION['user_id'] ?? null;
$workout_id = sanitizeInt($_GET['id'] ?? $_GET['edit'] ?? null);

// Step 1: Check ownership and fetch workout details
$sql_check = "SELECT workout_name, estimated_duration, workout_description FROM workouts_t WHERE workout_id = ? AND user_id = ?";
$workout_name = "";
$estimated_duration = "";
$workout_description = "";

if ($stmt = mysqli_prepare($connection, $sql_check)) {
    mysqli_stmt_bind_param($stmt, "ii", $workout_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $workout_name, $estimated_duration, $workout_description);

    if (!mysqli_stmt_fetch($stmt)) {
        // Not found or not yours
        http_response_code(403);
        die("Access denied.");
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    die("Server error.");
}

// Step 2: Get exercises linked to this workout
$exercises = [];

$sql_exercises = "
    SELECT we.sets, we.reps, we.rest, we.weight, we.notes,
           e.exercise_id, e.exercise_name, e.targeted_muscle, e.instructions
    FROM workout_exercises_t we
    JOIN exercises_t e ON we.exercise_id = e.exercise_id
    WHERE we.workout_id = ?
";

if ($stmt = mysqli_prepare($connection, $sql_exercises)) {
    mysqli_stmt_bind_param($stmt, "i", $workout_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $exercises[] = $row;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Exercise query failed: " . mysqli_error($connection));
    die("Could not load exercises.");
}
?>