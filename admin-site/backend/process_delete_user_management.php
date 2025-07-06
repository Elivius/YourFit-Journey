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

    // Proceed to delete
    $delete_SQL = "DELETE FROM users_t WHERE usr_id = ?";
    $stmt = mysqli_prepare($connection, $delete_SQL);
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