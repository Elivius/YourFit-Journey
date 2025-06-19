<?php
require_once '../../utils/connection.php';
require_once 'macro_calories_calculator.php';

$sql_retrieve = "
(
    SELECT * FROM meals_t
    WHERE category = 'breakfast'
    ORDER BY RAND()
    LIMIT 1
)
UNION ALL
(
    SELECT * FROM meals_t
    WHERE category = 'lunch'
    ORDER BY RAND()
    LIMIT 1
)
UNION ALL
(
    SELECT * FROM meals_t
    WHERE category = 'dinner'
    ORDER BY RAND()
    LIMIT 1
)
";

if ($stmt = mysqli_prepare($connection, $sql_retrieve)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $dailyMeals = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dailyMeals[] = $row;
        }
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/error_page.php");
    exit;
}

function getMealIngredients($connection, $meal_id) {
    $sql = "
        SELECT 
            i.ingredient_id,
            i.name,
            ROUND(i.protein_per_100g / 100, 4) AS protein_per_1g,
            ROUND(i.carbs_per_100g / 100, 4) AS carbs_per_1g,
            ROUND(i.fats_per_100g / 100, 4) AS fats_per_1g
        FROM meal_ingredients_t mi
        JOIN ingredients_t i ON mi.ingredient_id = i.ingredient_id
        WHERE mi.meal_id = ?
    ";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $meal_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function scaleIngredients($ingredients, $targetMacrosCal, $tolerance) {
    $ingredientGrams = array_fill(0, count($ingredients), 0); // Initialize grams to 0
    $step = 5; // How much to increase per attempt
    $maxAttempts = 500;

    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        $total = ['protein' => 0, 'carbs' => 0, 'fats' => 0, 'calories' => 0];
        
        // Recalculate macros for current grams
        foreach ($ingredients as $index => $ingredient) {
            $grams = $ingredientGrams[$index];
            $total['protein']  += $ingredient['protein_per_1g'] * $grams;
            $total['carbs']    += $ingredient['carbs_per_1g'] * $grams;
            $total['fats']      += $ingredient['fats_per_1g'] * $grams;
            $total['calories'] += (
                ($ingredient['protein_per_1g'] * 4) +
                ($ingredient['carbs_per_1g'] * 4) +
                ($ingredient['fats_per_1g'] * 9)
            ) * $grams;
        }

        // Check if within tolerance
        $withinTolerance = true;
        foreach ($targetMacrosCal as $key => $value) {
            if (abs($total[$key] - $value) > $tolerance[$key]) {
                $withinTolerance = false;
                break;
            }
        }

        if ($withinTolerance) {
            // Done, macros matched
            break;
        }

        // Try to improve by adjusting grams
        foreach ($ingredients as $index => $ingredient) {
            // Temporarily increase this ingredient
            $tempGrams = $ingredientGrams[$index] + $step;

            // Simulate updated totals
            $testTotal = $total;
            $testTotal['protein']  += $ingredient['protein_per_1g'] * $step;
            $testTotal['carbs']    += $ingredient['carbs_per_1g'] * $step;
            $testTotal['fats']      += $ingredient['fats_per_1g'] * $step;
            $testTotal['calories'] += (
                ($ingredient['protein_per_1g'] * 4) +
                ($ingredient['carbs_per_1g'] * 4) +
                ($ingredient['fats_per_1g'] * 9)
            ) * $step;

            // Only apply if it helps and stays within target
            if (
                $testTotal['calories'] <= $targetMacrosCal['calories'] + $tolerance['calories'] &&
                $testTotal['protein'] <= $targetMacrosCal['protein'] + $tolerance['protein'] &&
                $testTotal['carbs'] <= $targetMacrosCal['carbs'] + $tolerance['carbs'] &&
                $testTotal['fats'] <= $targetMacrosCal['fats'] + $tolerance['fats']
            ) {
                $ingredientGrams[$index] = $tempGrams;
            }
        }
    }

    $scaledIngredients = [];
    $totalGramsUsed = 0;

    foreach ($ingredients as $index => $ingredient) {
        $grams = $ingredientGrams[$index];
        $totalGramsUsed += $grams;

        $scaledIngredients[] = array_merge($ingredient, [
            'grams' => $ingredientGrams[$index]
        ]);
    }

    // Return both scaled ingredients and final macros
    return [
        'ingredients' => $scaledIngredients,
        'total_macrosCal' => $total,
        'total_grams' => $totalGramsUsed
    ];
}

$meals = [];

foreach ($dailyMeals as $meal) {
    $ingredients = getMealIngredients($connection, $meal['meal_id']);

    // Target for 1 meal
    $targetMacrosCal = [
        'protein' => $daily_macrosCal['protein_g'] / 3,
        'carbs'   => $daily_macrosCal['carbs_g'] / 3,
        'fats'    => $daily_macrosCal['fats_g'] / 3,
        'calories'=> $daily_macrosCal['calories'] / 3
    ];

    // Acceptable ranges (±10g protein, ±15g carbs, ±5g fats)
    $tolerance = [
        'protein' => 10,
        'carbs'   => 15,
        'fats'    => 5,
        'calories'=> 50
    ];

    $scaledIngredients = scaleIngredients($ingredients, $targetMacrosCal, $tolerance);

    $meals[] = [
        'meal_name' => $meal['meal_name'],
        'estimated_preparation_min' => $meal['estimated_preparation_min'],
        // 'image_url' => $meal['image_url'],
        'category' => $meal['category'],
        'ingredients' => $scaledIngredients['ingredients'],
        'meal_macros' => array_map(fn($val) => round($val, 1), $scaledIngredients['total_macrosCal'])
    ];
}

// === Final Output ===
echo json_encode([
    'user_macros' => $daily_macrosCal,
    'personalized_meals' => $meals
], JSON_PRETTY_PRINT);
?>