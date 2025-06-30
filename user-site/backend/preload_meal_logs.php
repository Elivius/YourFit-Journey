<?php
require_once '../../utils/connection.php';

$sql_extract = "
    SELECT
        uml_id,
        uml_meal_name,
        uml_category,
        ROUND(uml_protein_g, 2) AS protein,
        ROUND(uml_carbs_g, 2) AS carbs,
        ROUND(uml_fats_g, 2) AS fats,
        ROUND(uml_calories, 2) AS calories,
        TIME(uml_created_at) AS time
    FROM user_meal_logs_t
    WHERE usr_id = ?
        AND DATE(uml_created_at) = CURDATE()
    ORDER BY uml_created_at ASC;";

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
            $cat = strtolower($row['uml_category']);
            if (isset($mealsByCategory[$cat])) {
                $mealsByCategory[$cat][] = $row;
            }
        }
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    header("Location: ../frontend/login.php");
    exit;
}
?>
