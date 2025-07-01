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

$first_name       = cleanInput($_POST['firstName'] ?? '');
$last_name        = cleanInput($_POST['lastName'] ?? '');
$email            = sanitizeEmail($_POST['email'] ?? '');
$password         = sanitizePassword($_POST['password'] ?? '');
$age              = sanitizeInt($_POST['age'] ?? '');
$gender           = cleanInput($_POST['gender'] ?? '');
$weight           = sanitizeFloat($_POST['weight'] ?? '');
$height           = sanitizeFloat($_POST['height'] ?? '');
$activityLevel    = cleanInput($_POST['activityLevel'] ?? '');
$goal             = cleanInput($_POST['goal'] ?? '');

if (!$first_name || !$last_name || !$email || !$password || !$age|| !$gender || !$weight || !$height || !$activityLevel || !$goal) {
    $_SESSION['error'] = "Please fill in all fields";
    header("Location: ../frontend/user_management.php");
    exit;
}

if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||        
    !preg_match('/[a-z]/', $password) ||        
    !preg_match('/[0-9]/', $password) ||        
    !preg_match('/[\W_]/', $password)           
) {
    $_SESSION['error'] = "Password must be at least 8 characters, include uppercase and lowercase letters, a number, and a symbol.";
    header("Location: ../frontend/user_management.php");
    exit;
}

// Check for existing email
$sql_check = "SELECT usr_id FROM users_t WHERE usr_email = ?";

if ($stmt = mysqli_prepare($connection, $sql_check)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Email already registered";
        mysqli_stmt_close($stmt);
        header("Location: ../frontend/user_management.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/user_management.php");
    exit;
}

// Handle profile picture upload
if (!isset($_FILES['pfp']) || $_FILES['pfp']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error'] = "Upload failed. Please try again";
    header("Location: ../frontend/user_management.php");
    exit;
}


$allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
$tmpPath = $_FILES['pfp']['tmp_name'];
$fileType = mime_content_type($tmpPath);
$fileSize = $_FILES['pfp']['size'];

if (!in_array($fileType, $allowedTypes)) {
    $_SESSION['error'] = "Invalid file type. Only JPG, PNG, WEBP, GIF allowed";
    header("Location: ../frontend/user_management.php");
    exit;
}

if ($fileSize > 2 * 1024 * 1024) {
    $_SESSION['error'] = "Image too large. Max 2MB";
    header("Location: ../frontend/user_management.php");
    exit;
}

$uploadDir = __DIR__ . '/../../user-site/frontend/assets/images/profile_picture/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext = pathinfo($_FILES['pfp']['name'], PATHINFO_EXTENSION);
$newFileName = "pfp_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
$destination = $uploadDir . $newFileName;

if (!move_uploaded_file($tmpPath, $destination)) {
    $_SESSION['error'] = "Failed to upload image";
    header("Location: ../frontend/user_management.php");
    exit;
}

$hashed_password = hashPassword($password);

$sql_insert = "INSERT INTO users_t (usr_first_name, usr_last_name, usr_email, usr_password, usr_profile_pic, usr_role, usr_age, usr_gender, usr_weight, usr_height, usr_activity_level, usr_goal)
                VALUES (?, ?, ?, ?, ?, 'user', ?, ?, ?, ?, ?, ?)";

if ($stmt = mysqli_prepare($connection, $sql_insert)) {
    mysqli_stmt_bind_param(
        $stmt,
        "sssssisddss",
        $first_name,
        $last_name,
        $email,
        $hashed_password,
        $newFileName,
        $age,            
        $gender,
        $weight,           
        $height,           
        $activityLevel,
        $goal
    );
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $_SESSION['success'] = "Account created successfully";
    } else {
        error_log("Insert failed: " . mysqli_stmt_error($stmt));
        $_SESSION['error'] = "Failed to create account";
    }    
    header("Location: ../frontend/user_management.php");
    exit;

} else {
    error_log("Prepare failed: " . mysqli_error($connection));
    $_SESSION['error'] = "Server error";
    header("Location: ../frontend/user_management.php");
    exit;
}
?>