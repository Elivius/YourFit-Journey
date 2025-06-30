<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // var_dump($_SESSION);
}

// Basic login check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>