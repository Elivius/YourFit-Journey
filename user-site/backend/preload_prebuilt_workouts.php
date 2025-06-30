<?php
require_once '../../utils/connection.php';
require_once '../../utils/sanitize.php';

// Define workout ID with related category
$workoutIdToCategory = [
    21 => 'back',
    22 => 'chest',
    23 => 'legs',
    24 => 'arms'
];

$prebuiltWorkouts = [];

foreach ($workoutIdToCategory as $workout_id => $category) {
    $sql = "
        SELECT 
            wt.wko_name, wt.wko_description,
            we.we_sets, we.we_reps, we.we_rest, we.we_weight,
            e.exe_id, e.exe_name, e.exe_image_url, e.exe_targeted_muscle, e.exe_instructions
        FROM workouts_t wt
        JOIN workout_exercises_t we ON wt.wko_id = we.wko_id
        JOIN exercises_t e ON we.exe_id = e.exe_id
        WHERE wt.wko_id = ? AND wt.usr_id = 7
    ";

    $exercises = [];
    $workoutName = '';
    $description = '';

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $workout_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            // Only set workout name & description once
            if (empty($workoutName)) {
                $workoutName = $row['wko_name'];
                $description = $row['wko_description'];
            }

            $exercises[] = [
                'sets' => $row['we_sets'],
                'reps' => $row['we_reps'],
                'rest' => $row['we_rest'],
                'weight' => $row['we_weight'],
                'exercise_id' => $row['exe_id'],
                'exercise_name' => $row['exe_name'],
                'image_url' => $row['exe_image_url'],
                'targeted_muscle' => $row['exe_targeted_muscle'],
                'instructions' => $row['exe_instructions']
            ];
        }

        mysqli_stmt_close($stmt);
    }

    $prebuiltWorkouts[$category] = [
        'name' => $workoutName,
        'description' => $description,
        'exercises' => $exercises
    ];
}
?>