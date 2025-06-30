<?php
session_start();
require_once '../../utils/connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT DATE(wol_created_at) AS date
        FROM workout_logs_t
        WHERE usr_id = ?
        ORDER BY wol_created_at DESC";

$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $logs[] = $row['date'];
}

// Remove duplicates just in case
$logs = array_values(array_unique($logs));

// Fallback: return today to prevent JS error
if (empty($logs)) {
    $logs[] = date('Y-m-d');
}

echo json_encode($logs);
?>