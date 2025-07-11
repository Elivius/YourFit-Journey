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

$userIds = $_POST['userIds'] ?? [];

if (!is_array($userIds) || empty($userIds)) {
    $_SESSION['error'] = "No user selected";
    header("Location: ../frontend/user_management.php");
    exit;
}

$deletedCount = 0;
foreach ($userIds as $id) {
    $user_id = sanitizeInt($id);
    if (!$user_id) continue;

    // Check if user is admin
    $check_role_SQL = "SELECT usr_role FROM users_t WHERE usr_id = ?";
    $stmt = mysqli_prepare($connection, $check_role_SQL);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $role);
    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        if ($role === 'admin') continue;
    } else {
        mysqli_stmt_close($stmt);
        continue;
    }

    // Get all workouts for the user
    $workoutIds = [];
    $sql_get_workouts = "SELECT wko_id FROM workouts_t WHERE usr_id = ?";
    $stmt = mysqli_prepare($connection, $sql_get_workouts);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $workoutIds[] = $row['wko_id'];
    }
    mysqli_stmt_close($stmt);

    // Delete all workout_exercises linked to those workouts
    foreach ($workoutIds as $wko_id) {
        $stmt = mysqli_prepare($connection, "DELETE FROM workout_exercises_t WHERE wko_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $wko_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete from related tables that use usr_id
    $deleteTables = [
        'feedbacks_t',
        'user_meal_logs_t',
        'weight_logs_t',
        'workout_logs_t'
    ];

    foreach ($deleteTables as $table) {
        $delete_related_SQL = "DELETE FROM $table WHERE usr_id = ?";
        $stmt = mysqli_prepare($connection, $delete_related_SQL);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Delete workouts
    $stmt = mysqli_prepare($connection, "DELETE FROM workouts_t WHERE usr_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Finally delete the user
    $stmt = mysqli_prepare($connection, "DELETE FROM users_t WHERE usr_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $deletedCount++;
    }
    mysqli_stmt_close($stmt);
}

if ($deletedCount > 0) {
    $_SESSION['success'] = "$deletedCount user(s) deleted successfully";
} else {
    $_SESSION['error'] = "No users deleted (admins skipped or errors occurred)";
}

header("Location: ../frontend/user_management.php");
exit;
?>