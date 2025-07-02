<?php
require_once '../../utils/connection.php';

$tables = ['users_t', 'feedbacks_t', 'ingredients_t', 'meals_t', 'meal_ingredients_t', 'exercises_t', 'workouts_t', 'workout_exercises_t', 'user_meal_logs_t', 'weight_logs_t', 'workout_logs_t'];
$filename = "all_data_" . date('Y-m-d') . ".csv";

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=$filename");

$output = fopen("php://output", "w");

foreach ($tables as $table) {
    // Table title
    fputcsv($output, []);
    fputcsv($output, ["TABLE: $table"]);

    // Fetch data
    $result = mysqli_query($connection, "SELECT * FROM `$table`");
    if ($result) {
        // Headers
        $fields = mysqli_fetch_fields($result);
        $headers = array_map(fn($f) => $f->name, $fields);
        fputcsv($output, $headers);

        // Rows
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
    }
}

fclose($output);
exit;
