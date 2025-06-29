<?php
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';
require_once '../../utils/hashing.php';

$user_id = $_SESSION['user_id'];

$sql_extract = "SELECT first_name, last_name, email, profile_pic, age, gender, weight, height, activity_level , goal FROM users_t WHERE user_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_extract)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "An error occurred. Please log in again";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/login.php");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/login.php");
    exit;
}
?>