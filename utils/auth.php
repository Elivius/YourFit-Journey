<?php
session_start();

// Basic login check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../user-site/frontend/index.php");
    exit;
}

// Role check example
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

function authorization() {
    if (isAdmin()) {
        header("Location: ../admin-site/frontend/dashboard.php");
        exit;
    } else if (isUser()) {
        header("Location: ../user-site/frontend/dashboard.php");
        exit;
    } else {
        header("Location: ../user-site/frontend/index.php");
        exit;
    }
}
?>