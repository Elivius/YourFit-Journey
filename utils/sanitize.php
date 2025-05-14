<?php
function cleanInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function sanitizeEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizeInt($int) {
    return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
}
?>