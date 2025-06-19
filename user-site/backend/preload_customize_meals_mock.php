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
        SELECT i.*, mi.default_ratio
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

function getMealMacros($ingredients) {
    $totals = ['protein' => 0, 'carbs' => 0, 'fat' => 0, 'calories' => 0];
    foreach ($ingredients as $ing) {
        $g = $ing['default_ratio'] * 100;
        $totals['protein'] += $ing['protein_per_100g'] * $g / 100;
        $totals['carbs']   += $ing['carbs_per_100g'] * $g / 100;
        $totals['fat']     += $ing['fats_per_100g'] * $g / 100;
        $totals['calories'] += $ing['calories_per_100g'] * $g / 100;
    }
    return $totals;
}

function scaleIngredients($ingredients, $scalingFactor) {
    $result = [];
    foreach ($ingredients as $ing) {
        $grams = $ing['default_ratio'] * 100 * $scalingFactor;
        $result[] = [
            'name' => $ing['name'],
            'grams' => round($grams, 1),
            'protein' => round($ing['protein_per_100g'] * $grams / 100, 1),
            'carbs' => round($ing['carbs_per_100g'] * $grams / 100, 1),
            'fat' => round($ing['fats_per_100g'] * $grams / 100, 1),
            'calories' => round($ing['calories_per_100g'] * $grams / 100, 1)
        ];
    }
    return $result;
}

$meals = [];

foreach ($dailyMeals as $meal) {
    $ingredients = getMealIngredients($connection, $meal['meal_id']);
    $mealMacros = getMealMacros($ingredients);
    $scaling = ($mealMacros['calories'] > 0) ? ($daily_macros['calories'] / 3) / $mealMacros['calories'] : 1;
    $scaledIngredients = scaleIngredients($ingredients, $scaling);

    $meals[] = [
        'meal_name' => $meal['meal_name'],
        'estimated_preparation_min' => $meal['estimated_preparation_min'],
        'image_url' => $meal['image_url'],
        'category' => $meal['category'],
        'ingredients' => $scaledIngredients,
        'meal_macros' => array_map(fn($val) => round($val, 1), $mealMacros)
    ];
}

// === Final Output ===
echo json_encode([
    'user_macros' => $daily_macros,
    'personalized_meals' => $meals
], JSON_PRETTY_PRINT);
?>