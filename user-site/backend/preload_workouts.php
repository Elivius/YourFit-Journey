<?php
require_once '../../utils/connection.php';

$user_id = $_SESSION['user_id'] ?? null;
$workouts = [];

$sql_select = "SELECT w.workout_id, w.workout_name, w.estimated_duration, w.workout_description, w.created_at, 
            (SELECT COUNT(*) FROM workout_exercises_t we WHERE we.workout_id = w.workout_id) AS exercise_count 
            FROM workouts_t w 
            WHERE w.user_id = ? 
            ORDER BY w.created_at DESC";


if ($stmt = mysqli_prepare($connection, $sql_select)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
            $workouts[] = $row;
        }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/login.php");
    exit;
}
?>
