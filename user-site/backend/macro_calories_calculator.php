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

        if (
            empty($user['age']) || $user['age'] == 0 ||
            empty($user['height']) || $user['height'] == 0 ||
            empty($user['weight']) || $user['weight'] == 0
        ) {
            echo json_encode(['error' => 'Please complete your profile (age, height, weight)']);
            exit;
        }

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
    global $user;

    if ($goal === 'bulking') {
        $weight = $user['weight'];

        // Fixed macros by body weight
        $protein_g = round($weight * 2.2);  // ~2.2g protein per kg
        $fats_g = round($weight * 0.9);     // ~0.9g fats per kg

        // Calories used by protein & fats
        $protein_kcal = $protein_g * 4;
        $fats_kcal = $fats_g * 9;

        // Remaining calories go to carbs
        $remaining_kcal = $calories - ($protein_kcal + $fats_kcal);
        $carbs_g = round($remaining_kcal / 4);

        return [
            'protein_g' => $protein_g,
            'fats_g' => $fats_g,
            'carbs_g' => $carbs_g
        ];
    }

    // For cutting and maintenance, use ratio
    $ratios = [
        'cutting' => ['protein' => 0.40, 'fats' => 0.30, 'carbs' => 0.30],
        'maintain' => ['protein' => 0.30, 'fats' => 0.30, 'carbs' => 0.40]
    ];

    $r = $ratios[$goal] ?? $ratios['maintain'];

    return [
        'protein_g' => round(($calories * $r['protein']) / 4),
        'fats_g'    => round(($calories * $r['fats']) / 9),
        'carbs_g'   => round(($calories * $r['carbs']) / 4)
    ];
}

$bmr = calculateBMR($user['weight'], $user['height'], $user['age'], $user['gender']);
$tdee = $bmr * getActivityMultiplier($user['activity_level']);
$calories = adjustCaloriesForGoal($tdee, $user['goal']);
$daily_macrosCal = calculateMacros($calories, $user['goal']);
$daily_macrosCal['calories'] = round($calories);
?>