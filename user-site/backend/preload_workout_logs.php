<?php
session_start();
require_once '../../utils/connection.php';

$sql_extract = "
    SELECT created_at, workout_name, estimated_duration, exercise_count
    FROM workout_logs_t
    WHERE user_id = ?
    ORDER BY created_at DESC";

if ($stmt = mysqli_prepare($connection, $sql_extract)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $logs = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = [
                'date' => date('M d, Y, h:i A', strtotime($row['created_at'])),
                'workout_name' => $row['workout_name'],
                'duration' => $row['estimated_duration'] . ' min',
                'exercise_count' => $row['exercise_count'] . ' exercise',
            ];
        }
    }

    mysqli_stmt_close($stmt);
    
    // Return JSON
    header('Content-Type: application/json');
    echo json_encode($logs);
    exit;
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch workout logs']);
    exit;
}
?>