<?php
require_once '../../utils/connection.php';

$sql_extract = "SELECT * FROM exercises_t";

if ($stmt = mysqli_prepare($connection, $sql_extract)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $exercises = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $exercises[] = $row;
        }

        if (empty($exercises)) {
            $_SESSION['error'] = "No exercises found";
            header("Location: ../frontend/workouts.php?section=my-workouts");
            exit;
        }

    } else {
        $_SESSION['error'] = "An error occurred while fetching data";
        header("Location: ../frontend/workouts.php?section=my-workouts");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/workouts.php?section=my-workouts");
    exit;
}
?>