<?php

// Calculate Basal Metabolic Rate (BMR) using Mifflin-St Jeor Equation
function calculateBMR($weight, $height, $age, $gender) {
    if ($gender === 'male') {
        return 10 * $weight + 6.25 * $height - 5 * $age + 5;
    } else {
        return 10 * $weight + 6.25 * $height - 5 * $age - 161;
    }
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
        case 'lose':
            return $tdee - 500;
        case 'gain':
            return $tdee + 300;
        case 'maintain':
        default:
            return $tdee;
    }
}

function calculateMacros($calories, $goal) {
    // Macronutrient ratio presets
    $ratios = [
        'lose' => ['protein' => 0.40, 'fat' => 0.30, 'carbs' => 0.30], // 40% protein, 30% fat, 30% carbs
        'maintain' => ['protein' => 0.30, 'fat' => 0.30, 'carbs' => 0.40], // 30% protein, 30% fat, 40% carbs
        'gain' => ['protein' => 0.30, 'fat' => 0.25, 'carbs' => 0.45] // 30% protein, 25% fat, 45% carbs
    ];

    $r = $ratios[$goal];

    return [
        'protein_g' => round(($calories * $r['protein']) / 4), // 4 calories per gram of protein
        'fat_g'     => round(($calories * $r['fat']) / 9),   // 9 calories per gram of fat
        'carbs_g'   => round(($calories * $r['carbs']) / 4),  // 4 calories per gram of carbs
    ];
}

// === Input ===
$age = 20;
$gender = 'male'; // 'male' or 'female'
$weight = 60;     // kg
$height = 165;    // cm
$activityLevel = 'active'; // sedentary, light, moderate, active, very_active
$goal = 'maintain'; // lose, maintain, gain

// === Processing ===
$bmr = calculateBMR($weight, $height, $age, $gender);
$multiplier = getActivityMultiplier($activityLevel);
$tdee = $bmr * $multiplier;
$calories = adjustCaloriesForGoal($tdee, $goal);
$macros = calculateMacros($calories, $goal);

// === Output ===
echo "BMR: " . round($bmr) . " kcal/day\n";
echo "TDEE: " . round($tdee) . " kcal/day\n";
echo "Calories for goal ($goal): $calories kcal/day\n\n";
echo "Macros:\n";
echo "- Protein: {$macros['protein_g']} g\n";
echo "- Fat: {$macros['fat_g']} g\n";
echo "- Carbs: {$macros['carbs_g']} g\n";

?>
