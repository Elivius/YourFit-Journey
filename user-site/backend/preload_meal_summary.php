<?php
require_once '../../utils/connection.php';
require_once 'macro_calories_calculator.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$response = [
    'consumed' => [
        'protein' => 0,
        'carbs' => 0,
        'fats' => 0,
        'calories' => 0
    ],
    'goal' => $daily_macrosCal
];

$sql = "SELECT
            SUM(protein_g) AS protein,
            SUM(carbs_g) AS carbs,
            SUM(fats_g) AS fats,
            SUM(calories) AS calories
        FROM user_meal_logs_t
        WHERE user_id = ?
            AND DATE(created_at) = ?";

if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "is", $user_id, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $response['consumed'] = [
            'protein' => round($row['protein'], 2),
            'carbs' => round($row['carbs'], 2),
            'fats' => round($row['fats'], 2),
            'calories' => round($row['calories'], 2)
        ];
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Query failed']);
    exit;
}

echo json_encode($response);