<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';
require_once '../../utils/hashing.php';

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../../user-site/frontend/login.php");
    exit;
}

$user_id       = sanitizeInt($_POST['user_id'] ?? '');
$first_name    = cleanInput($_POST['firstName'] ?? '');
$last_name     = cleanInput($_POST['lastName'] ?? '');
$email         = sanitizeEmail($_POST['email'] ?? '');
$password      = sanitizePassword($_POST['password'] ?? '');
$age           = sanitizeInt($_POST['age'] ?? '');
$gender        = cleanInput($_POST['gender'] ?? '');
$weight        = sanitizeFloat($_POST['weight'] ?? '');
$height        = sanitizeFloat($_POST['height'] ?? '');
$activityLevel = cleanInput($_POST['activityLevel'] ?? '');
$goal          = cleanInput($_POST['goal'] ?? '');

if (!$user_id || !$first_name || !$last_name || !$email || !$age || !$gender || !$weight || !$height || !$activityLevel || !$goal) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/user_management.php");
    exit;
}

// Check if email is already used by another user
$check_email_sql = "SELECT usr_id FROM users_t WHERE usr_email = ? AND usr_id != ?";
if ($stmt = mysqli_prepare($connection, $check_email_sql)) {
    mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Email is already used by another account";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/user_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Email check failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error during email validation.";
    header("Location: ../frontend/user_management.php");
    exit;
}


// Optional password validation & hashing
$updatePassword = false;
if ($password !== '') {
    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[\W_]/', $password)
    ) {
        $_SESSION['error'] = "Password must be at least 8 characters, include uppercase/lowercase, number, and symbol.";
        header("Location: ../frontend/user_management.php");
        exit;
    }
    $hashed_password = hashPassword($password);
    $updatePassword = true;
}

// Optional profile picture upload
$updateImage = false;
if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $tmpPath = $_FILES['pfp']['tmp_name'];
    $fileType = mime_content_type($tmpPath);
    $fileSize = $_FILES['pfp']['size'];

    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['error'] = "Invalid image type";
        header("Location: ../frontend/user_management.php");
        exit;
    }

    if ($fileSize > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Image too large. Max 2MB.";
        header("Location: ../frontend/user_management.php");
        exit;
    }

    $uploadDir = __DIR__ . '/../../user-site/frontend/assets/images/profile_picture/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
    $ext = pathinfo($_FILES['pfp']['name'], PATHINFO_EXTENSION);
    $newFileName = "pfp_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
    $destination = $uploadDir . $newFileName;

    if (!move_uploaded_file($tmpPath, $destination)) {
        $_SESSION['error'] = "Failed to upload profile picture";
        header("Location: ../frontend/user_management.php");
        exit;
    }

    $updateImage = true;
}

// Build update query dynamically
$setFields = "usr_first_name=?, usr_last_name=?, usr_email=?, usr_age=?, usr_gender=?, usr_weight=?, usr_height=?, usr_activity_level=?, usr_goal=?";
$params = [$first_name, $last_name, $email, $age, $gender, $weight, $height, $activityLevel, $goal];
$types = "sssisdiss";

if ($updatePassword) {
    $setFields .= ", usr_password=?";
    $params[] = $hashed_password;
    $types .= "s";
}

if ($updateImage) {
    $setFields .= ", usr_profile_pic=?";
    $params[] = $newFileName;
    $types .= "s";
}

$params[] = $user_id;
$types .= "i";

$sql_update = "UPDATE users_t SET $setFields WHERE usr_id = ?";

if ($stmt = mysqli_prepare($connection, $sql_update)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "User updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update user or no changes made";
        error_log("Update error: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
    header("Location: ../frontend/user_management.php");
    exit;
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/user_management.php");
    exit;
}
?>