<?php
require_once '../../utils/connection.php';

// Prepare SQL to fetch all exercises
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
            $_SESSION['error'] = "No exercises found.";
            header("Location: ../frontend/login.php");
            exit;
        }

    } else {
        $_SESSION['error'] = "An error occurred while fetching data.";
        header("Location: ../frontend/login.php");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error.";
    header("Location: ../frontend/login.php");
    exit;
}
?>
