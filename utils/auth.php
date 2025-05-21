<?php
session_start();
var_dump($_SESSION);

// Basic login check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

// Role check example
// function isAdmin() {
//     return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
// }

// function isUser() {
//     return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
// }

// function authorization() {
//     if (isAdmin()) {
//         header("Location: dashboard.php");
//         exit;
//     } else if (isUser()) {
//         header("Location: dashboard.php");
//         exit;
//     } else {
//         header("Location: index.php");
//         exit;
//     }
// }
?>