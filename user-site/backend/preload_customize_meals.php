<?php
require_once '../../utils/connection.php';
require_once 'macro_calories_calculator.php';

$maxMealRetries = 100;
$maxLoops = 1000;

$tolerance = [
    'protein'  => 5,
    'carbs'    => 5,
    'fats'     => 5,
    'calories' => 100
];

$target = [
    'protein'  => $daily_macrosCal['protein_g'],
    'carbs'    => $daily_macrosCal['carbs_g'],
    'fats'     => $daily_macrosCal['fats_g'],
    'calories' => $daily_macrosCal['calories']
];

// Get 3 random meals
function getRandomMeals($connection) {
    $sql = "
    (
        SELECT * FROM meals_t WHERE mel_category = 'breakfast' ORDER BY RAND() LIMIT 1
    )
    UNION ALL
    (
        SELECT * FROM meals_t WHERE mel_category = 'lunch' ORDER BY RAND() LIMIT 1
    )
    UNION ALL
    (
        SELECT * FROM meals_t WHERE mel_category = 'dinner' ORDER BY RAND() LIMIT 1
    )";

    $meals = [];
    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $meals[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
    return $meals;
}

// Get ingredients for meal
function getMealIngredients($connection, $meal_id) {
    $sql = "
        SELECT 
            i.ing_id,
            i.ing_name,
            ROUND(i.ing_protein_per_100g / 100, 4) AS protein_per_1g,
            ROUND(i.ing_carbs_per_100g / 100, 4) AS carbs_per_1g,
            ROUND(i.ing_fats_per_100g / 100, 4) AS fats_per_1g,
            ROUND(((i.ing_protein_per_100g * 4 + i.ing_carbs_per_100g * 4 + i.ing_fats_per_100g * 9) / 100), 4) AS calories_per_1g,
            mi.mi_base_grams
        FROM meal_ingredients_t mi
        JOIN ingredients_t i ON mi.ing_id = i.ing_id
        WHERE mi.mel_id = ?
    ";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    
    $ingredients = mysqli_fetch_all($res, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $ingredients;
}

// Try different meal sets until macro mets
$matched = false;

for ($mealAttempt = 0; $mealAttempt < $maxMealRetries; $mealAttempt++) {
    $dailyMeals = getRandomMeals($connection);

    $nutrients = [];
    $flat = [];

    foreach ($dailyMeals as $meal) {
        $ingredients = getMealIngredients($connection, $meal['mel_id']);
        foreach ($ingredients as $ing) {
            $key = strtolower(str_replace(' ', '_', $ing['ing_name']));
            $nutrients[$key] = [
                'protein'  => $ing['protein_per_1g'],
                'carbs'    => $ing['carbs_per_1g'],
                'fats'     => $ing['fats_per_1g'],
                'calories' => $ing['calories_per_1g']
            ];
            if (!isset($flat[$key])) {
                $flat[$key] = $ing['mi_base_grams'];
            } else {
                $flat[$key] += $ing['mi_base_grams'];
            }
        }
    }

    // Scale attempts
    for ($i = 0; $i < $maxLoops; $i++) {
        $total = ['protein' => 0, 'carbs' => 0, 'fats' => 0, 'calories' => 0];

        foreach ($flat as $item => $grams) {
            foreach ($nutrients[$item] as $macro => $val) {
                $total[$macro] += $val * $grams;
            }
        }

        $within = true;
        foreach ($target as $macro => $goal) {
            if (abs($total[$macro] - $goal) > $tolerance[$macro]) {
                $within = false;
                break;
            }
        }

        if ($within) {
            $matched = true;
            break;
        }

        foreach ($flat as $item => &$grams) {
            foreach (['protein', 'carbs', 'fats'] as $macro) {
                $diff = $target[$macro] - $total[$macro];

                if ($macro === 'fats' && $total['fats'] > $target['fats'] + $tolerance['fats']) continue;

                if ($diff > $tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {
                    if ($total['fats'] > $target['fats'] + $tolerance['fats'] && $nutrients[$item]['fats'] > 0.1) {
                        continue;
                    }
                    $grams += 1;
                } elseif ($diff < -$tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {
                    $grams -= 1;
                    if ($grams < 0) $grams = 0;
                }
            }
        }
        unset($grams); // cleanup ref
    }

    if ($matched) break;
}

if ($matched) {
    $personalizedMeals = [];

    foreach ($dailyMeals as $meal) {
        $mealData = [
            'meal_id' => $meal['mel_id'],
            'meal_name' => $meal['mel_name'],
            'category' => $meal['mel_category'],
            'image_url' => $meal['mel_image_url'],
            'estimated_preparation_min' => $meal['mel_estimated_preparation_min'],
            'meal_macros' => [
                'protein' => 0,
                'carbs' => 0,
                'fat' => 0,
                'calories' => 0,
            ],
            'ingredients' => []
        ];

        $ingredients = getMealIngredients($connection, $meal['mel_id']);

        foreach ($ingredients as $ing) {
            $key = strtolower(str_replace(' ', '_', $ing['ing_name']));
            if (!isset($flat[$key]) || $flat[$key] <= 0) continue;

            $grams = $flat[$key];
            $protein  = round($grams * $ing['protein_per_1g'], 2);
            $carbs    = round($grams * $ing['carbs_per_1g'], 2);
            $fat      = round($grams * $ing['fats_per_1g'], 2);
            $calories = round($grams * $ing['calories_per_1g'], 2);

            $mealData['ingredients'][] = [
                'name' => $ing['ing_name'],
                'grams' => $grams,
                'protein' => $protein,
                'carbs' => $carbs,
                'fat' => $fat,
                'calories' => $calories,
            ];

            $mealData['meal_macros']['protein'] += $protein;
            $mealData['meal_macros']['carbs'] += $carbs;
            $mealData['meal_macros']['fat'] += $fat;
            $mealData['meal_macros']['calories'] += $calories;
        }

        // Round total meal macros
        foreach ($mealData['meal_macros'] as &$val) {
            $val = round($val, 1);
        }

        $personalizedMeals[] = $mealData;
    }

    $totalRounded = array_map(fn($v) => round($v, 1), $total);
    $targetRounded = array_map(fn($v) => round($v, 1), $target);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'user_macros' => $targetRounded,
        'total_macros' => $totalRounded,
        'personalized_meals' => $personalizedMeals
    ]);
    exit;
} else {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => "Failed to match macros after $maxMealRetries meal sets × $maxLoops loops.",
        'personalized_meals' => []
    ]);
    exit;
}
?>
