<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';

$_SESSION['target_form'] = 'pfpForm';

$user_id = $_SESSION['user_id'] ?? null;

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    session_unset();
    $_SESSION['target_form'] = 'loginForm';
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/login.php");
    exit;
}

if (!isset($_FILES['pfp']) || $_FILES['pfp']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error'] = "Upload failed. Please try again";
    header("Location: ../frontend/settings.php?section=profile");
    exit;
}

// Validate file
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
$tmpPath = $_FILES['pfp']['tmp_name'];
$fileType = mime_content_type($tmpPath);
$fileSize = $_FILES['pfp']['size'];

if (!in_array($fileType, $allowedTypes)) {
    $_SESSION['error'] = "Invalid file type. Only JPG, PNG, WEBP, GIF allowed";
    header("Location: ../frontend/settings.php?section=profile");
    exit;
}

if ($fileSize > 2 * 1024 * 1024) {
    $_SESSION['error'] = "Image too large. Max 2MB";
    header("Location: ../frontend/settings.php?section=profile");
    exit;
}

// Set paths
$uploadDir = __DIR__ . '/../frontend/assets/images/profile_picture/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext = pathinfo($_FILES['pfp']['name'], PATHINFO_EXTENSION);
$newFileName = "pfp_{$user_id}_" . time() . "." . $ext;
$destination = $uploadDir . $newFileName;

// Delete old PFP
$sql_old = "SELECT usr_profile_pic FROM users_t WHERE usr_id = ?";
if ($stmt = mysqli_prepare($connection, $sql_old)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $oldPic);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($oldPic && file_exists($uploadDir . $oldPic)) {
        unlink($uploadDir . $oldPic);
    }
}

// Move file and update DB
if (move_uploaded_file($tmpPath, $destination)) {
    $sql_update = "UPDATE users_t SET usr_profile_pic = ? WHERE usr_id = ?";
    if ($stmt = mysqli_prepare($connection, $sql_update)) {
        mysqli_stmt_bind_param($stmt, "si", $newFileName, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['success'] = "Profile picture updated";
        $_SESSION['pfp'] = $newFileName;
    } else {
        $_SESSION['error'] = "Failed to save image to database";
    }
} else {
    $_SESSION['error'] = "Failed to upload image";
}

header("Location: ../frontend/settings.php?section=profile");
exit;
