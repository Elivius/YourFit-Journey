<?php
session_start();
require_once '../../utils/connection.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';
require_once '../../utils/hashing.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token";
    header("Location: ../frontend/settings.php");
    exit;
}

$form_type = $_POST['form_type'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

switch ($form_type) {
    case 'personalInfoForm':
        $first_name = cleanInput($_POST['first_name'] ?? '');
        $last_name = cleanInput($_POST['last_name'] ?? '');
        $gender = cleanInput($_POST['gender'] ?? '');

        if (!$first_name || !$last_name || !$gender) {
            $_SESSION['error'] = "Please fill in all personal info fields";
            break;
        }
        
        $sql_update_personal_info = "UPDATE users SET first_name=?, last_name=?, gender=? WHERE user_id=?";
        if ($stmt = mysqli_prepare($connection, $sql_update_personal_info)) {
            mysqli_stmt_bind_param($stmt, "sssi", $first_name, $last_name, $gender, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['success'] = "Personal info updated";
            } else {
                $_SESSION['success'] = "No changes detected";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Server error";
        }
        break;

    case 'physicalStatsForm':
        $age = sanitizeInt($_POST['age'] ?? null);
        $height = sanitizeFloat($_POST['height'] ?? null);
        $weight = sanitizeFloat($_POST['weight'] ?? null);

        if (is_null($age) || is_null($height) || is_null($weight)) {
            $_SESSION['error'] = "Please fill in all physical stats fields";
            break;
        }

        $sql_update_physical_stats = "UPDATE users SET age=?, weight=?, height=? WHERE user_id=?";
        if ($stmt = mysqli_prepare($connection, $sql_update_physical_stats)) {
            mysqli_stmt_bind_param($stmt, "idii", $age, $weight, $height, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['success'] = "Physical stats updated";
            } else {
                $_SESSION['success'] = "No changes detected";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Server error";
        }
        break;

    case 'passwordForm':
        $current_password = sanitizePassword($_POST['current_password'] ?? '');
        $new_password = sanitizePassword($_POST['new_password'] ?? '');
        $confirm_password = sanitizePassword($_POST['confirm_password'] ?? '');

        if (!$current_password || !$new_password || !$confirm_password) {
            $_SESSION['error'] = "Please fill in all password fields";
            break;
        }

        if (strlen($new_password) < 8 ||
            !preg_match('/[A-Z]/', $new_password) ||
            !preg_match('/[a-z]/', $new_password) ||
            !preg_match('/[0-9]/', $new_password) ||
            !preg_match('/[\W_]/', $new_password)
        ) {
            $_SESSION['error'] = "New password must be:<br>
                                  - at least 8 characters<br>
                                  - include uppercase letter<br>
                                  - include lowercase letter<br>
                                  - include a number<br>
                                  - include a symbol";
            break;
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['error'] = "Password confirmation does not match";
            break;
        }

        // Fetch current hashed password from database
        $sql_fetch_current_password = "SELECT password FROM users WHERE user_id=?";
        if ($stmt = mysqli_prepare($connection, $sql_fetch_current_password)) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && $row = mysqli_fetch_assoc($result)) {
                $hashed_password = $row['password'];
                if (!password_verify($current_password, $hashed_password)) {
                    $_SESSION['error'] = "Current password is incorrect";
                    mysqli_stmt_close($stmt);
                    break;
                }

                $new_hashed = hashPassword($new_password);
                $sql_update_password = "UPDATE users SET password=? WHERE user_id=?";

                if ($update_stmt = mysqli_prepare($connection, $sql_update_password)) {
                    mysqli_stmt_bind_param($update_stmt, "si", $new_hashed, $user_id);
                    mysqli_stmt_execute($update_stmt);
                    if (mysqli_stmt_affected_rows($update_stmt) > 0) {
                        $_SESSION['success'] = "Password updated";
                    } else {
                        $_SESSION['success'] = "No changes detected";
                    }
                    mysqli_stmt_close($update_stmt);
                }
            } else {
                $_SESSION['error'] = "An error occured";
            }
            mysqli_stmt_close($stmt);
        } else {
            error_log("Prepare failed: " . mysqli_error($connection));
            $_SESSION['error'] = "Server error";
        }
        break;

    case 'primaryGoalForm':
        $primary_goal = cleanInput($_POST['primary_goal'] ?? '');

        if (!$primary_goal) {
            $_SESSION['error'] = "Please select a primary fitness goal";
            break;
        }

        $sql_update_goal = "UPDATE users SET goal=? WHERE user_id=?";
         if ($stmt = mysqli_prepare($connection, $sql_update_goal)) {
            mysqli_stmt_bind_param($stmt, "si", $primary_goal, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['success'] = "Primary goal updated";
            } else {
                $_SESSION['success'] = "No changes detected";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Server error";
        }
        break;


    case 'activityLevelForm':
        $activity_level = cleanInput($_POST['activity_level'] ?? '');

        if (!$activity_level) {
            $_SESSION['error'] = "Please select an activity level";
            break;
        }

        $sql_update_activity_level = "UPDATE users SET activity_level=? WHERE user_id=?";
        if ($stmt = mysqli_prepare($connection, $sql_update_activity_level)) {
            mysqli_stmt_bind_param($stmt, "si", $activity_level, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['success'] = "Activity level updated";
            } else {
                $_SESSION['success'] = "No changes detected";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Server error";
        }
        break;

    default:
        $_SESSION['error'] = 'Invalid form submission';
        header('Location: ../frontend/settings.php');
        exit;
}

$redirect_section = match($form_type) {
    'personalInfoForm', 'physicalStatsForm', 'passwordForm' => 'profile',
    'primaryGoalForm', 'activityLevelForm' => 'fitness-goals',
    default => 'profile'
};

header("Location: ../frontend/settings.php?section=$redirect_section");
exit;
?>
