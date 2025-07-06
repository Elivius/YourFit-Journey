<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../../user-site/frontend/login.php");
    exit;
}

$exerciseIds = $_POST['exerciseIds'] ?? [];

if (!is_array($exerciseIds) || empty($exerciseIds)) {
    $_SESSION['error'] = "No exercises selected";
    header("Location: ../frontend/exercise_management.php");
    exit;
}

$deletedCount = 0;
$skippedCount = 0;

foreach ($exerciseIds as $id) {
    $exercise_id = sanitizeInt($id);
    if (!$exercise_id) continue;

    // Check if exercise is used in workout plans
    $check_sql = "SELECT 1 FROM workout_exercises_t WHERE exe_id = ? LIMIT 1";
    $stmt = mysqli_prepare($connection, $check_sql);
    mysqli_stmt_bind_param($stmt, "i", $exercise_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $skippedCount++;
        mysqli_stmt_close($stmt);
        continue;
    }
    mysqli_stmt_close($stmt);

    // Delete the exercise
    $delete_sql = "DELETE FROM exercises_t WHERE exe_id = ?";
    $stmt = mysqli_prepare($connection, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $exercise_id);
    if (mysqli_stmt_execute($stmt)) {
        $deletedCount++;
    }
    mysqli_stmt_close($stmt);
}

if ($deletedCount > 0) {
    $_SESSION['success'] = "$deletedCount exercise(s) deleted successfully";
}
if ($skippedCount > 0) {
    $_SESSION['error'] = "$skippedCount exercise(s) could not be deleted as they are in use in workout plans";
}
if ($deletedCount === 0 && $skippedCount === 0) {
    $_SESSION['error'] = "No valid exercises to delete";
}

header("Location: ../frontend/exercise_management.php");
exit;
?>