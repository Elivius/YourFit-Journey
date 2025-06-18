<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

// Get user data
$sql_user = "SELECT age, gender, weight, height, activity_level, goal FROM users_t WHERE user_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_user)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "Please fill out your profile in settings";
        header("Location: ../frontend/login.php");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error.";
    header("Location: ../frontend/login.php");
    exit;
}

// Calculate Basal Metabolic Rate (BMR) using Mifflin-St Jeor Equation
function calculateBMR($weight, $height, $age, $gender) {
    return ($gender === 'male') ? 10 * $weight + 6.25 * $height - 5 * $age + 5 
                                : 10 * $weight + 6.25 * $height - 5 * $age - 161;
}

// Calculate Total Daily Energy Expenditure (TDEE)'s multiplier based on activity level
function getActivityMultiplier($activityLevel) {
    $multipliers = [
        'sedentary' => 1.2,
        'light'     => 1.375,
        'moderate'  => 1.55,
        'active'    => 1.725,
        'very_active' => 1.9
    ];

    return $multipliers[$activityLevel] ?? 1.2;
}

function adjustCaloriesForGoal($tdee, $goal) {
    switch ($goal) {
        case 'cutting':
            return $tdee - 500;
        case 'bulking':
            return $tdee + 300;
        default:
            return $tdee;
    }
}

function calculateMacros($calories, $goal) {
    // Macronutrient ratio presets
    $ratios = [
        'cutting' => ['protein' => 0.40, 'fats' => 0.30, 'carbs' => 0.30], // 40% protein, 30% fats, 30% carbs
        'maintain' => ['protein' => 0.30, 'fats' => 0.30, 'carbs' => 0.40], // 30% protein, 30% fats, 40% carbs
        'bulking' => ['protein' => 0.30, 'fats' => 0.25, 'carbs' => 0.45] // 30% protein, 25% fats, 45% carbs
    ];

    $r = $ratios[$goal];

    return [
        'protein_g' => round(($calories * $r['protein']) / 4), // 4 calories per gram of protein
        'fats_g'     => round(($calories * $r['fats']) / 9),   // 9 calories per gram of fats
        'carbs_g'   => round(($calories * $r['carbs']) / 4),  // 4 calories per gram of carbs
    ];
}

$bmr = calculateBMR($user['weight'], $user['height'], $user['age'], $user['gender']);
$tdee = $bmr * getActivityMultiplier($user['activity_level']);
$calories = adjustCaloriesForGoal($tdee, $user['goal']);
$daily_macros = calculateMacros($calories, $user['goal']);
$daily_macros['calories'] = round($calories);
?>