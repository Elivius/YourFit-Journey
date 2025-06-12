<?php
require_once '../../utils/connection.php';

$user_id = $_SESSION['user_id'] ?? null;

$workouts = [];

if ($user_id) {
    $stmt = mysqli_prepare($connection, "SELECT workout_id, workout_name, estimated_duration, workout_description, created_at FROM workouts_t WHERE user_id = ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $workouts[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>
