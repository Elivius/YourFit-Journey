<?php
require_once '../../utils/connection.php';
require_once 'macro_calories_calculator.php';

// === Step 1: Retrieve random meals ===
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

$dailyMeals = [];
if ($stmt = mysqli_prepare($connection, $sql_retrieve)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $dailyMeals[] = $row;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    exit;
}

// === Step 2: Get ingredients for all meals ===
function getMealIngredients($connection, $meal_id) {
    $sql = "
        SELECT 
            i.ingredient_id,
            i.name,
            ROUND(i.protein_per_100g / 100, 4) AS protein_per_1g,
            ROUND(i.carbs_per_100g / 100, 4) AS carbs_per_1g,
            ROUND(i.fats_per_100g / 100, 4) AS fats_per_1g,
            ROUND(((i.protein_per_100g * 4 + i.carbs_per_100g * 4 + i.fats_per_100g * 9) / 100), 4) AS calories_per_1g,
            mi.base_grams
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

// === Step 3: Build nutrient and flat gram tables ===
$nutrients = [];
$flat = [];

foreach ($dailyMeals as $meal) {
    $ingredients = getMealIngredients($connection, $meal['meal_id']);
    foreach ($ingredients as $ing) {
        $key = strtolower(str_replace(' ', '_', $ing['name']));
        $nutrients[$key] = [
            'protein'  => $ing['protein_per_1g'],
            'carbs'    => $ing['carbs_per_1g'],
            'fats'     => $ing['fats_per_1g'],
            'calories' => $ing['calories_per_1g']
        ];
        // Ensure no overwriting of grams if same ingredient appears in different meals
        if (!isset($flat[$key])) {
            $flat[$key] = $ing['base_grams'];
        } else {
            $flat[$key] += $ing['base_grams']; // Add up base grams across meals
        }
    }
}

// === Step 4: Optimization loop ===
$target = [
    'protein'  => $daily_macrosCal['protein_g'],
    'carbs'    => $daily_macrosCal['carbs_g'],
    'fats'     => $daily_macrosCal['fats_g'],
    'calories' => $daily_macrosCal['calories']
];

$tolerance = [
    'protein'  => 10,
    'carbs'    => 15,
    'fats'     => 5,
    'calories' => 100
];

$maxLoops = 500;
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
        break;
    }

    foreach ($flat as $item => &$grams) {
        foreach (['protein', 'carbs', 'fats'] as $macro) {
            $diff = $target[$macro] - $total[$macro];

            // Skip increasing high-fat ingredients if fat is over target
            if ($macro === 'fats' && $total['fats'] > $target['fats'] + $tolerance['fats']) {
                continue;
            }

            // Intelligent increase
            if ($diff > $tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {

                // ⚠️ Avoid increasing if that ingredient also adds too much fat when fat is over target
                if (
                    $total['fats'] > $target['fats'] + $tolerance['fats'] &&
                    $nutrients[$item]['fats'] > 0.1
                ) {
                    continue; // skip fat-heavy
                }

                $grams += 1;

            } elseif ($diff < -$tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {
                $grams -= 1;
                if ($grams < 0) $grams = 0;
            }
        }
    }
    unset($grams); // Unset ref
}

// === Step 5: Output ===
echo "Final Ingredients (grams):\n";
foreach ($flat as $item => $grams) {
    echo "$item: $grams g\n";
}

echo "\nFinal Totals:\n";
foreach ($target as $macro => $val) {
    echo ucfirst($macro) . ": " . round($total[$macro], 2) . " (Target: $val)\n";
}
?>
