<?php
require_once '../../utils/connection.php';

// Total users
$sqlTotal = 'SELECT COUNT(usr_id) AS total_users FROM users_t';
$resultTotal = mysqli_query($connection, $sqlTotal);
$totalUsers = ($resultTotal && $row = mysqli_fetch_assoc($resultTotal)) ? $row['total_users'] : 'NaN';

// Current month new users
$sqlCurrent = "SELECT COUNT(usr_id) AS current_month_users
               FROM users_t
               WHERE MONTH(usr_created_at) = MONTH(CURRENT_DATE())
               AND YEAR(usr_created_at) = YEAR(CURRENT_DATE())";
$currentResult = mysqli_query($connection, $sqlCurrent);
$currentUsers = ($currentResult && $row = mysqli_fetch_assoc($currentResult)) ? $row['current_month_users'] : 0;

// Last month new users
$sqlLast = "SELECT COUNT(usr_id) AS last_month_users
            FROM users_t
            WHERE MONTH(usr_created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(usr_created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
$lastResult = mysqli_query($connection, $sqlLast);
$lastUsers = ($lastResult && $row = mysqli_fetch_assoc($lastResult)) ? $row['last_month_users'] : 0;

// Percentage growth
$percentageChange = 0;
if ($lastUsers > 0) {
    $percentageChange = (($currentUsers - $lastUsers) / $lastUsers) * 100;
}
$isPositiveUsers = $percentageChange >= 0;
$percentageTextUsers = number_format(abs($percentageChange), 1) . '%';

// ===================================================================================================================

// Total exercises
$sqlTotal = 'SELECT COUNT(exe_id) AS total_exercises FROM exercises_t';
$resultTotal = mysqli_query($connection, $sqlTotal);
$totalExercises = ($resultTotal && $row = mysqli_fetch_assoc($resultTotal)) ? $row['total_exercises'] : 'NaN';

// Current month new exercises
$sqlCurrent = "SELECT COUNT(exe_id) AS current_month_exercises
               FROM exercises_t
               WHERE MONTH(exe_created_at) = MONTH(CURRENT_DATE())
               AND YEAR(exe_created_at) = YEAR(CURRENT_DATE())";
$currentResult = mysqli_query($connection, $sqlCurrent);
$currentExercises = ($currentResult && $row = mysqli_fetch_assoc($currentResult)) ? $row['current_month_exercises'] : 0;

// Last month new exercises
$sqlLast = "SELECT COUNT(exe_id) AS last_month_exercises
            FROM exercises_t
            WHERE MONTH(exe_created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(exe_created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
$lastResult = mysqli_query($connection, $sqlLast);
$lastExercises = ($lastResult && $row = mysqli_fetch_assoc($lastResult)) ? $row['last_month_exercises'] : 0;

// Percentage growth
$percentageChange = 0;
if ($lastExercises > 0) {
    $percentageChange = (($currentExercises - $lastExercises) / $lastExercises) * 100;
}
$isPositiveExercises = $percentageChange >= 0;
$percentageTextExercises = number_format(abs($percentageChange), 1) . '%';

// ===================================================================================================================

// Total workouts created
$sqlTotal = 'SELECT COUNT(wko_id) AS total_workouts FROM workouts_t';
$resultTotal = mysqli_query($connection, $sqlTotal);
$totalWorkouts = ($resultTotal && $row = mysqli_fetch_assoc($resultTotal)) ? $row['total_workouts'] : 'NaN';

// Current week new workouts
$sqlCurrentWeek = "SELECT COUNT(wko_id) AS current_week_workouts
                   FROM workouts_t
                   WHERE YEARWEEK(wko_created_at, 1) = YEARWEEK(CURDATE(), 1)";
$currentWeekResult = mysqli_query($connection, $sqlCurrentWeek);
$currentWeekWorkouts = ($currentWeekResult && $row = mysqli_fetch_assoc($currentWeekResult)) ? $row['current_week_workouts'] : 0;

// Last week new workouts
$sqlLastWeek = "SELECT COUNT(wko_id) AS last_week_workouts
                FROM workouts_t
                WHERE YEARWEEK(wko_created_at, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)";
$lastWeekResult = mysqli_query($connection, $sqlLastWeek);
$lastWeekWorkouts = ($lastWeekResult && $row = mysqli_fetch_assoc($lastWeekResult)) ? $row['last_week_workouts'] : 0;

// Percentage growth (Week)
$weeklyChange = 0;
if ($lastWeekWorkouts > 0) {
    $weeklyChange = (($currentWeekWorkouts - $lastWeekWorkouts) / $lastWeekWorkouts) * 100;
}
$isPositiveWorkouts = $weeklyChange >= 0;
$percentageTextWorkouts = number_format(abs($weeklyChange), 1) . '%';

// ===================================================================================================================

// Total active diets
$sqlTotal = 'SELECT COUNT(DISTINCT mel_id) AS total_active_diets FROM meal_ingredients_t';
$resultTotal = mysqli_query($connection, $sqlTotal);
$totalActiveDiets = ($resultTotal && $row = mysqli_fetch_assoc($resultTotal)) ? $row['total_active_diets'] : 'NaN';

// Current month active diets
$sqlCurrent = "SELECT COUNT(DISTINCT mel_id) AS current_month_diets
               FROM meal_ingredients_t
               WHERE MONTH(mi_created_at) = MONTH(CURRENT_DATE())
               AND YEAR(mi_created_at) = YEAR(CURRENT_DATE())";
$currentResult = mysqli_query($connection, $sqlCurrent);
$currentMonthDiets = ($currentResult && $row = mysqli_fetch_assoc($currentResult)) ? $row['current_month_diets'] : 0;

// Last month active diets
$sqlLast = "SELECT COUNT(DISTINCT mel_id) AS last_month_diets
            FROM meal_ingredients_t
            WHERE MONTH(mi_created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(mi_created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
$lastResult = mysqli_query($connection, $sqlLast);
$lastMonthDiets = ($lastResult && $row = mysqli_fetch_assoc($lastResult)) ? $row['last_month_diets'] : 0;

// Percentage growth
$percentageChangeDiets = 0;
if ($lastMonthDiets > 0) {
    $percentageChangeDiets = (($currentMonthDiets - $lastMonthDiets) / $lastMonthDiets) * 100;
}
$isPositiveDiets = $percentageChangeDiets >= 0;
$percentageTextDiets = number_format(abs($percentageChangeDiets), 1) . '%';
?>