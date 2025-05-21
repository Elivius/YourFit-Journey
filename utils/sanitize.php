<?php
// Trim and clean general input (no HTML allowed)
function cleanInput($data) {
    return trim(strip_tags($data));
}

// Sanitize and validate email
function sanitizeEmail($email) {
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

// Sanitize integer
function sanitizeInt($int) {
    $int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    return filter_var($int, FILTER_VALIDATE_INT) !== false ? (int) $int : false;
}

// Sanitize float
function sanitizeFloat($float) {
    $float = filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return filter_var($float, FILTER_VALIDATE_FLOAT) !== false ? (float) $float : false;
}

// Sanitize password (do NOT modify contents, just trim)
function sanitizePassword($password) {
    return trim($password);
}

// Escape output for HTML context (prevent XSS)
function escapeHTML($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
