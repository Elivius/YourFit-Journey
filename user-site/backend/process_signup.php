<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';
require_once '../../utils/hashing.php';

$_SESSION['target_form'] = 'signupForm';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/signup.php");
    exit;
}

// Sanitize and validate input
$first_name       = cleanInput($_POST['first-name'] ?? '');
$last_name        = cleanInput($_POST['last-name'] ?? '');
$email            = sanitizeEmail($_POST['email'] ?? '');
$password         = sanitizePassword($_POST['password'] ?? '');
$confirm_password = sanitizePassword($_POST['confirm-password'] ?? '');
$gender           = cleanInput($_POST['gender'] ?? '');
$terms           = cleanInput($_POST['terms'] ?? '');

$_SESSION['first-name'] = $first_name;
$_SESSION['last-name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['gender'] = $gender;

if (!$first_name || !$last_name || !$email || !$password || !$confirm_password || !$gender) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/signup.php");
    exit;
} elseif (!$terms) {
    $_SESSION['error'] = "You must accept the terms and conditions";
    header("Location: ../frontend/signup.php");
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Password confirmation does not match";
    header("Location: ../frontend/signup.php");
    exit;
}

if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||        // at least one uppercase letter
    !preg_match('/[a-z]/', $password) ||        // at least one lowercase letter
    !preg_match('/[0-9]/', $password) ||        // at least one digit
    !preg_match('/[\W_]/', $password)           // at least one symbol
) {
    $_SESSION['error'] = "Password must be at least 8 characters, include uppercase and lowercase letters, a number, and a symbol.";
    header("Location: ../frontend/signup.php");
    exit;
}

// Check for existing email
$sql_check = "SELECT user_id FROM users_t WHERE email = ?";

if ($stmt = mysqli_prepare($connection, $sql_check)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Email already registered";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/signup.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/signup.php");
    exit;
}

// Hash password and insert user
$hashed_password = hashPassword($password);

$sql_insert = "INSERT INTO users_t (first_name, last_name, email, password, gender, role) VALUES (?, ?, ?, ?, ?, 'user')";

if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $hashed_password, $gender);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        $sql_check = "SELECT user_id, first_name, password, role FROM users_t WHERE email = ?";
        if ($stmt = mysqli_prepare($connection, $sql_check)) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && $user = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $user['password'])) {

                    session_regenerate_id(true);

                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['name'] = $user['first_name'];

                    unset($_SESSION['first-name'], $_SESSION['last-name'], $_SESSION['gender']);

                    mysqli_stmt_close($stmt);

                    if ($user['role'] === 'user') {
                        header('Location: ../frontend/dashboard.php');
                    } else {
                        $_SESSION['error'] = "Unauthorized access";
                        header("Location: ../frontend/login.php");
                    }
                    exit;
                }
            }

            // Fallback if something goes wrong
            $_SESSION['error'] = "Account created but failed to log in";
            mysqli_stmt_close($stmt);
            header("Location: ../frontend/login.php");
            exit;
        } else {
            error_log('Auto-login prepare failed: ' . mysqli_error($connection));
            $_SESSION['error'] = "Server error";
            header("Location: ../frontend/login.php");
            exit;
        }
    } else {
        error_log("Insert failed: " . mysqli_stmt_error($stmt));
        $_SESSION['error'] = "Failed to create account";
        header("Location: ../frontend/signup.php");
        exit;
    }
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/signup.php");
    exit;
}
?>
