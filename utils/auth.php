<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // var_dump($_SESSION);
}

// Basic login check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: ../../user-site/frontend/index.php");
    exit;
}

// Role check
if (isset($requireRole)) {
    if (!isset($_SESSION['role'])) {
        header("Location: ../../user-site/frontend/index.php");
        exit;
    }
    
    if (is_array($requireRole)) {
        if (!in_array($_SESSION['role'], $requireRole, true)) {
            header("Location: ../../user-site/frontend/index.php");
            exit;
        }
    } else {
        if ($_SESSION['role'] !== $requireRole) {
            header("Location: ../../user-site/frontend/index.php");
            exit;
        }
    }
}
?>