<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../utils/connection.php';

header('Content-Type: application/json');

$response = [];

$user_id = $_SESSION['user_id'];

$sql_extract = "
    SELECT uml_meal_name, uml_category, uml_protein_g, uml_carbs_g, uml_fats_g, uml_calories, uml_created_at 
    FROM user_meal_logs_t 
    WHERE usr_id = ? 
    ORDER BY uml_created_at DESC 
    LIMIT 20
";

if ($stmt = mysqli_prepare($connection, $sql_extract)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
}

echo json_encode($response);