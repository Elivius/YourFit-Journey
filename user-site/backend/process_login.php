<?php
session_start();
require_once '../../utils/db.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    die("Invalid CSRF token");
}

// Sanitize and validate input
$email = sanitizeEmail($_POST['email'] ?? '');
$password = cleanInput($_POST['password'] ?? '');

if (!$email || empty($password)) {
    die("Email and password are required");
}

// Fetch user from database
$stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Incorrect email or password.');
}

//Verify password hash
if (!password_verify($password, $user['password'])) {
    die('Incorrect email or password.');
}

//Secure session management
session_regenerate_id(true);

$_SESSION['logged_in'] = true;
$_SESSION['user_id']   = $user['id'];
$_SESSION['email']     = $user['email'];
$_SESSION['role']      = $user['role'];

// Redirect based on role
if ($user['role'] === 'admin') {
    header('Location: ../admin-site/frontend/dashboard.php');
} else {
    header('Location: ../user-site/frontend/dashboard.php');
}

exit;