<?php
// Tolerances
$tolerance = [
    'protein' => 10,
    'carbs'   => 15,
    'fats'    => 5,
    'calories'=> 100
];

// Macro values per gram
$nutrients = [
    "rolled_oats"     => ["protein" => 0.13, "carbs" => 0.68, "fats" => 0.07, "calories" => 3.85],
    "banana"          => ["protein" => 0.011, "carbs" => 0.225, "fats" => 0.0038, "calories" => 0.9],
    "peanut_butter"   => ["protein" => 0.25, "carbs" => 0.3, "fats" => 0.52, "calories" => 9.4],
    "milk_skim"       => ["protein" => 0.034, "carbs" => 0.05, "fats" => 0.002, "calories" => 0.35],
    "chicken_breast"  => ["protein" => 0.31, "carbs" => 0.0, "fats" => 0.036, "calories" => 1.65],
    "brown_rice"      => ["protein" => 0.026, "carbs" => 0.27, "fats" => 0.01, "calories" => 1.33],
    "broccoli"        => ["protein" => 0.033, "carbs" => 0.055, "fats" => 0.0038, "calories" => 0.44],
    "tofu"            => ["protein" => 0.10, "carbs" => 0.025, "fats" => 0.06, "calories" => 1.25],
    "lettuce"         => ["protein" => 0.01, "carbs" => 0.02, "fats" => 0.002, "calories" => 0.2],
    "tomato"          => ["protein" => 0.016, "carbs" => 0.052, "fats" => 0.002, "calories" => 0.3],
    "olive_oil"       => ["protein" => 0.0, "carbs" => 0.0, "fats" => 1.0, "calories" => 9.0]
];

// Target macros
$target = [
    "protein" => 50,
    "carbs" => 70,
    "fats" => 20,
    "calories" => 700
];

// Meal ingredient structure (to be scaled)
$meals = [
    "breakfast" => [
        "rolled_oats" => 40,
        "banana" => 80,
        "peanut_butter" => 15,
        "milk_skim" => 100
    ],
    "lunch" => [
        "chicken_breast" => 100,
        "brown_rice" => 60,
        "broccoli" => 80
    ],
    "dinner" => [
        "tofu" => 80,
        "lettuce" => 50,
        "tomato" => 50,
        "olive_oil" => 8
    ]
];

// Flatten ingredients into one array for scaling
$flat = [];
foreach ($meals as $meal) {
    foreach ($meal as $item => $grams) {
        $flat[$item] = $grams;
    }
}

// Optimization loop
$maxLoops = 1000;
for ($i = 0; $i < $maxLoops; $i++) {
    $total = ["protein" => 0, "carbs" => 0, "fats" => 0, "calories" => 0];

    // Calculate totals
    foreach ($flat as $item => $grams) {
        foreach ($nutrients[$item] as $macro => $val) {
            $total[$macro] += $val * $grams;
        }
    }

    echo "Iteration $i:\n";
    echo "Total Macros: Protein: " . round($total['protein'], 2) . 
         ", Carbs: " . round($total['carbs'], 2) . 
         ", Fats: " . round($total['fats'], 2) . 
         ", Calories: " . round($total['calories'], 2) . "\n";

    // Check if within tolerance
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

    // Adjust grams based on macro difference
    foreach ($flat as $item => &$grams) {
        foreach (["protein", "carbs", "fats"] as $macro) {
            $diff = $target[$macro] - $total[$macro];
            if ($diff > $tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {
                $grams += 1;
            } elseif ($diff < -$tolerance[$macro] / 2 && $nutrients[$item][$macro] > 0) {
                $grams -= 1;
                if ($grams < 0) $grams = 0;
            }
        }
    }
    unset($grams);
}

// Output result
echo "Final Ingredients (grams):\n";
foreach ($flat as $item => $grams) {
    echo "$item: $grams g\n";
}

echo "\nFinal Totals:\n";
foreach ($target as $macro => $val) {
    echo ucfirst($macro) . ": " . round($total[$macro], 2) . " (Target: $val)\n";
}
?>
