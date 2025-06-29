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
            wt.workout_name, wt.workout_description,
            we.sets, we.reps, we.rest, we.weight,
            e.exercise_id, e.exercise_name, e.image_url, e.targeted_muscle, e.instructions
        FROM workouts_t wt
        JOIN workout_exercises_t we ON wt.workout_id = we.workout_id
        JOIN exercises_t e ON we.exercise_id = e.exercise_id
        WHERE wt.workout_id = ? AND wt.user_id = 7
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
                $workoutName = $row['workout_name'];
                $description = $row['workout_description'];
            }

            $exercises[] = [
                'sets' => $row['sets'],
                'reps' => $row['reps'],
                'rest' => $row['rest'],
                'weight' => $row['weight'],
                'exercise_id' => $row['exercise_id'],
                'exercise_name' => $row['exercise_name'],
                'image_url' => $row['image_url'],
                'targeted_muscle' => $row['targeted_muscle'],
                'instructions' => $row['instructions']
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