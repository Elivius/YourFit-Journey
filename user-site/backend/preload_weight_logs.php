<?php
session_start();
require_once '../../utils/connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT DATE(wel_created_at) AS date, wel_weight
        FROM weight_logs_t 
        WHERE usr_id = ? 
        ORDER BY wel_created_at DESC 
        LIMIT 7";

$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $logs[] = [
        'date' => $row['date'],
        'weight' => floatval($row['wel_weight'])
    ];
}

// Reverse to show from earliest to latest
$logs = array_reverse($logs);

$labels = array_column($logs, 'date');
$data = array_column($logs, 'weight');

// Fallback if no data
if (empty($labels)) {
    $labels[] = date('Y-m-d');
    $data[] = 0;
}

echo json_encode([
    "labels" => $labels,
    "data" => $data
]);
?>
