<?php
require_once '../../utils/connection.php';

$sql_extract = "
    SELECT
        meal_name,
        category,
        ROUND(protein_g, 2) AS protein,
        ROUND(carbs_g, 2) AS carbs,
        ROUND(fats_g, 2) AS fats,
        ROUND(calories, 2) AS calories
    FROM user_meal_logs_t
    WHERE user_id = ?
        AND created_at = CURDATE()
    ORDER BY created_at DESC;";

$mealsByCategory = [
    'breakfast' => [],
    'lunch' => [],
    'dinner' => []
];

if ($stmt = mysqli_prepare($connection, $sql_extract)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cat = strtolower($row['category']);
            if (isset($mealsByCategory[$cat])) {
                $mealsByCategory[$cat][] = $row;
            }
        }
    }

    // echo json_encode($mealsByCategory);

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    header("Location: ../frontend/login.php");
    exit;
}
?>
