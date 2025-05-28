<?php
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../../utils/message.php';
require_once '../backend/preload_settings.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - YourFit Journey</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body class="dark-theme dashboard-body settings-page">
    <div class="dashboard-container">

        <?php include 'side_bar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="btn-toggle-sidebar" id="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Settings</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <button id="theme-toggle" class="btn btn-icon">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>

            <!-- Settings Content -->
            <div class="dashboard-content">
                <!-- Settings Navigation -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="top-nav">
                            <button class="top-nav-item active" data-target="profile">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </button>
                            <button class="top-nav-item" data-target="fitness-goals">
                                <i class="fas fa-bullseye"></i>
                                <span>Fitness Goals</span>
                            </button>
                            <button class="top-nav-item" data-target="feedback">
                                <i class="fas fa-comment-alt"></i>
                                <span>Feedback</span>
                            </button>
                            <button class="top-nav-item" data-target="notifications">
                                <i class="fas fa-bell"></i>
                                <span>Notifications</span>
                            </button>
                            <button class="top-nav-item" data-target="account">
                                <i class="fas fa-shield-alt"></i>
                                <span>Account</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Profile Settings -->
                <div class="tab-section active" id="profile">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Profile Picture</h5>
                                </div>
                                <div class="card-body">
                                    <div class="profile-picture-container">
                                        <div class="profile-picture">
                                            <img src="assets/images/avatar.jpg" alt="Profile Picture" class="img-fluid rounded">
                                        </div>
                                        <div class="profile-picture-actions mt-3">
                                            <button class="btn btn-sm btn-outline-danger">Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Account Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="account-status">
                                        <div class="status-item">
                                            <span class="status-label">Membership</span>
                                            <span class="status-value premium">Premium</span>
                                        </div>
                                        <div class="status-item">
                                            <span class="status-label">Member Since</span>
                                            <span class="status-value">June 15, 2023</span>
                                        </div>
                                        <div class="status-item">
                                            <span class="status-label">Next Billing</span>
                                            <span class="status-value">July 15, 2023</span>
                                        </div>
                                        <div class="status-actions mt-3">
                                            <button class="btn btn-sm btn-outline-primary">Manage Subscription</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <form id="personalInfoForm" action="../backend/process_settings.php" method="POST">
                                        <input type="hidden" name="form_type" value="personalInfoForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="firstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="firstName" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lastName" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block mb-2">Gender</label>
                                                <div class="btn-group w-100" role="group" aria-label="Gender">
                                                    <input type="radio" class="btn-check" name="gender" id="male" value="male" autocomplete="off"
                                                        <?= $user['gender'] === 'male' ? 'checked' : '' ?> required>
                                                    <label class="btn btn-outline-primary gender-label" for="male">Male</label>

                                                    <input type="radio" class="btn-check" name="gender" id="female" value="female" autocomplete="off"
                                                        <?= $user['gender'] === 'female' ? 'checked' : '' ?>>
                                                    <label class="btn btn-outline-primary gender-label" for="female">Female</label>
                                                </div>
                                            </div>
                                            <div class="form-message" id="personalInfoFormMessage"></div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Physical Stats</h5>
                                </div>
                                <div class="card-body">
                                    <form id="physicalStatsForm" action="../backend/process_settings.php" method="POST">
                                        <input type="hidden" name="form_type" value="physicalStatsForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="age" class="form-label">Age</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>" min="0" max="120", step="1">
                                                    <span class="input-group-text">years</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="height" class="form-label">Height</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="height" name="height" value="<?= htmlspecialchars($user['height']) ?>" min="0" step="1">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="weight" class="form-label">Weight</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="weight" name="weight" value="<?= htmlspecialchars($user['weight']) ?>" min="0" step="0.01">
                                                    <span class="input-group-text">kg</span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <label for="bodyFat" class="form-label">Body Fat</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="bodyFat" value="15">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="chest" class="form-label">Chest</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="chest" value="95">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="waist" class="form-label">Waist</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="waist" value="82">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="hips" class="form-label">Hips</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="hips" value="90">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div> -->
                                            <div class="form-message" id="physicalStatsFormMessage"></div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Change Password</h5>
                                </div>
                                <div class="card-body">
                                    <form id="passwordForm" action="../backend/process_settings.php" method="POST">
                                        <input type="hidden" name="form_type" value="passwordForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="currentPassword" class="form-label">Enter Current Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="currentPassword" name="current_password">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newPassword" class="form-label">Enter New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newPassword" name="new_password">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirmPassword" class="form-label">Enter Password Confirmation</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-message" id="passwordFormMessage"></div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-primary">Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fitness Goals Settings -->
                <div class="tab-section" id="fitness-goals">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Primary Fitness Goal</h5>
                                </div>
                                <div class="card-body">
                                    <form id="primaryGoalForm" action="../backend/process_settings.php" method="POST">
                                        <input type="hidden" name="form_type" value="primaryGoalForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="fitness-goals-options">
                                            <div class="fitness-goal-option">
                                                <input type="radio" class="btn-check" name="primary_goal" value="cutting" id="cutting" autocomplete="off"
                                                    <?= $user['goal'] === 'cutting' ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-primary w-100" for="cutting">
                                                    <i class="fas fa-weight"></i>
                                                    <div class="fitness-goal-text">Cutting</div>
                                                </label>
                                            </div>
                                            <div class="fitness-goal-option">
                                                <input type="radio" class="btn-check" name="primary_goal" value="bulking" id="bulking" autocomplete="off"
                                                    <?= $user['goal'] === 'bulking' ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-primary w-100" for="bulking">
                                                    <i class="fas fa-dumbbell"></i>
                                                    <div class="fitness-goal-text">Bulking</div>
                                                </label>
                                            </div>
                                            <div class="fitness-goal-option">
                                                <input type="radio" class="btn-check" name="primary_goal" value="maintain" id="maintainHealth" autocomplete="off"
                                                    <?= $user['goal'] === 'maintain' ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-primary w-100" for="maintainHealth">
                                                    <i class="fas fa-heartbeat"></i>
                                                    <div class="fitness-goal-text">Maintain Health</div>
                                                </label>
                                            </div>
                                            <div class="fitness-goal-option">
                                                <input type="radio" class="btn-check" name="primary_goal" id="improveEndurance" autocomplete="off"
                                                    <?= $user['goal'] === 'improve_endurance' ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-primary w-100" for="improveEndurance">
                                                    <i class="fas fa-running"></i>
                                                    <div class="fitness-goal-text">Improve Endurance</div>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="goal-details mt-4"> -->
                                            <!-- <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="targetWeight" class="form-label">Target Weight</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="targetWeight" value="70">
                                                        <span class="input-group-text">kg</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="weeklyGoal" class="form-label">Weekly Goal</label>
                                                    <select class="form-select" id="weeklyGoal">
                                                        <option value="0.25">Lose 0.25 kg per week</option>
                                                        <option value="0.5" selected>Lose 0.5 kg per week</option>
                                                        <option value="0.75">Lose 0.75 kg per week</option>
                                                        <option value="1">Lose 1 kg per week</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <div class="goal-summary">
                                                        <p>Current weight: <strong>75 kg</strong></p>
                                                        <p>Target weight: <strong>70 kg</strong></p>
                                                        <p>Weight to lose: <strong>5 kg</strong></p>
                                                        <p>Estimated time: <strong>10 weeks</strong></p>
                                                    </div>
                                                </div> -->
                                                <div class="form-message" id="primaryGoalFormMessage"></div>
                                                <div class="mt-3 settings-btn-margin">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Activity Level</h5>
                                </div>
                                <div class="card-body">
                                    <form id="activityLevelForm" action="../backend/process_settings.php" method="POST">
                                        <input type="hidden" name="form_type" value="activityLevelForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="activity-level-options">
                                            <div class="form-check activity-level-option">
                                                <input class="form-check-input" type="radio" name="activity_level" value="sedentary" id="sedentary"
                                                    <?= $user['activity_level'] === 'sedentary' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="sedentary">
                                                    <div class="activity-level-header">
                                                        <h6>Sedentary</h6>
                                                        <span class="activity-level-tag">Little to no exercise</span>
                                                    </div>
                                                    <p>Desk job and little physical activity outside of daily tasks.</p>
                                                </label>
                                            </div>
                                            <div class="form-check activity-level-option">
                                                <input class="form-check-input" type="radio" name="activity_level" value="light" id="light"
                                                    <?= $user['activity_level'] === 'light' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="light">
                                                    <div class="activity-level-header">
                                                        <h6>Lightly Active</h6>
                                                        <span class="activity-level-tag">Light exercise 1-3 days/week</span>
                                                    </div>
                                                    <p>Some walking, light jogging, or recreational activities a few times per week.</p>
                                                </label>
                                            </div>
                                            <div class="form-check activity-level-option">
                                                <input class="form-check-input" type="radio" name="activity_level" value="moderate" id="moderate"
                                                    <?= $user['activity_level'] === 'moderate' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="moderate">
                                                    <div class="activity-level-header">
                                                        <h6>Moderately Active</h6>
                                                        <span class="activity-level-tag">Moderate exercise 3-5 days/week</span>
                                                    </div>
                                                    <p>Regular exercise including jogging, cycling, or sports several times per week.</p>
                                                </label>
                                            </div>
                                            <div class="form-check activity-level-option">
                                                <input class="form-check-input" type="radio" name="activity_level" value="active" id="active"
                                                    <?= $user['activity_level'] === 'active' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="active">
                                                    <div class="activity-level-header">
                                                        <h6>Active</h6>
                                                        <span class="activity-level-tag">Hard exercise 6-7 days/week</span>
                                                    </div>
                                                    <p>Intense exercise or sports training almost daily.</p>
                                                </label>
                                            </div>
                                            <div class="form-check activity-level-option">
                                                <input class="form-check-input" type="radio" name="activity_level" value="very_active" id="veryActive"
                                                    <?= $user['activity_level'] === 'very_active' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="veryActive">
                                                    <div class="activity-level-header">
                                                        <h6>Very Active</h6>
                                                        <span class="activity-level-tag">Very hard exercise & physical job</span>
                                                    </div>
                                                    <p>Very intense exercise multiple times per day or physically demanding job.</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-message" id="activityLevelFormMessage"></div>
                                        <div class="mt-3 settings-btn-margin">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Workout Preferences</h5>
                                </div>
                                <div class="card-body">
                                    <form id="workoutPreferencesForm">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="workoutDays" class="form-label">Workout Days per Week</label>
                                                <select class="form-select" id="workoutDays">
                                                    <option value="3" selected>3 days</option>
                                                    <option value="4">4 days</option>
                                                    <option value="5">5 days</option>
                                                    <option value="6">6 days</option>
                                                    <option value="7">7 days</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="workoutDuration" class="form-label">Workout Duration</label>
                                                <select class="form-select" id="workoutDuration">
                                                    <option value="30">30 minutes</option>
                                                    <option value="45" selected>45 minutes</option>
                                                    <option value="60">60 minutes</option>
                                                    <option value="90">90 minutes</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Preferred Workout Types</label>
                                                <div class="workout-type-options">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="weightTraining" checked>
                                                        <label class="form-check-label"  checked>
                                                        <label class="form-check-label" for="weightTraining">Weight Training</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="cardio" checked>
                                                        <label class="form-check-label" for="cardio">Cardio</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="hiit">
                                                        <label class="form-check-label" for="hiit">HIIT</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="yoga">
                                                        <label class="form-check-label" for="yoga">Yoga</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pilates">
                                                        <label class="form-check-label" for="pilates">Pilates</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="tab-section" id="feedback">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Workout Plan Feedback</h5>
                                </div>
                                <div class="card-body">
                                    <form id="workoutFeedbackForm">
                                        <div class="mb-3">
                                            <label for="workoutPlan" class="form-label">Select Workout Plan</label>
                                            <select class="form-select" id="workoutPlan">
                                                <option selected>Beginner Full Body Workout</option>
                                                <option>Intermediate Upper/Lower Split</option>
                                                <option>Advanced Push/Pull/Legs</option>
                                                <option>Custom Plan #1</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">How would you rate this workout plan?</label>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">What aspects did you like?</label>
                                            <div class="feedback-aspects">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="workoutEffectiveness" checked>
                                                    <label class="form-check-label" for="workoutEffectiveness">Effectiveness</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="workoutDifficulty" checked>
                                                    <label class="form-check-label" for="workoutDifficulty">Appropriate difficulty</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="workoutVariety">
                                                    <label class="form-check-label" for="workoutVariety">Exercise variety</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="workoutInstructions" checked>
                                                    <label class="form-check-label" for="workoutInstructions">Clear instructions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="workoutTime">
                                                    <label class="form-check-label" for="workoutTime">Time efficiency</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="workoutComments" class="form-label">Additional Comments</label>
                                            <textarea class="form-control" id="workoutComments" rows="4" placeholder="Share your thoughts on this workout plan...">The workout plan has been very effective for me. I've seen good progress in strength and endurance. The instructions are clear and easy to follow.</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Diet Plan Feedback</h5>
                                </div>
                                <div class="card-body">
                                    <form id="dietFeedbackForm">
                                        <div class="mb-3">
                                            <label for="dietPlan" class="form-label">Select Diet Plan</label>
                                            <select class="form-select" id="dietPlan">
                                                <option selected>High Protein Meal Plan</option>
                                                <option>Low Carb Diet</option>
                                                <option>Mediterranean Diet</option>
                                                <option>Custom Meal Plan #1</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">How would you rate this diet plan?</label>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">What aspects did you like?</label>
                                            <div class="feedback-aspects">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dietTaste" checked>
                                                    <label class="form-check-label" for="dietTaste">Taste/Flavor</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dietVariety" checked>
                                                    <label class="form-check-label" for="dietVariety">Meal variety</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dietPreparation" checked>
                                                    <label class="form-check-label" for="dietPreparation">Easy preparation</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dietSatiety">
                                                    <label class="form-check-label" for="dietSatiety">Feeling of fullness</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dietResults" checked>
                                                    <label class="form-check-label" for="dietResults">Visible results</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dietComments" class="form-label">Additional Comments</label>
                                            <textarea class="form-control" id="dietComments" rows="4" placeholder="Share your thoughts on this diet plan...">The high protein meal plan has been great for my recovery after workouts. The recipes are delicious and easy to prepare. I would like to see more vegetarian options though.</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">App Feedback</h5>
                                </div>
                                <div class="card-body">
                                    <form id="appFeedbackForm">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="feedbackCategory" class="form-label">Feedback Category</label>
                                                <select class="form-select" id="feedbackCategory">
                                                    <option>General Feedback</option>
                                                    <option>Bug Report</option>
                                                    <option selected>Feature Request</option>
                                                    <option>User Experience</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="feedbackPriority" class="form-label">Priority</label>
                                                <select class="form-select" id="feedbackPriority">
                                                    <option>Low</option>
                                                    <option selected>Medium</option>
                                                    <option>High</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="feedbackSubject" class="form-label">Subject</label>
                                                <input type="text" class="form-control" id="feedbackSubject" value="Request for social sharing features">
                                            </div>
                                            <div class="col-12">
                                                <label for="feedbackMessage" class="form-label">Message</label>
                                                <textarea class="form-control" id="feedbackMessage" rows="5">I would love to see social sharing features added to the app. It would be great to be able to share my workout achievements and progress with friends on social media platforms. This would help with motivation and accountability.</textarea>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="contactMe" checked>
                                                    <label class="form-check-label" for="contactMe">
                                                        Contact me about this feedback
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div class="tab-section" id="notifications">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Notification Preferences</h5>
                        </div>
                        <div class="card-body">
                            <form id="notificationsForm">
                                <div class="notification-categories">
                                    <div class="notification-category">
                                        <div class="notification-category-header">
                                            <h6>Workout Reminders</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="workoutReminders" checked>
                                                <label class="form-check-label" for="workoutReminders"></label>
                                            </div>
                                        </div>
                                        <div class="notification-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="workoutReminderApp" checked>
                                                <label class="form-check-label" for="workoutReminderApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="workoutReminderEmail">
                                                <label class="form-check-label" for="workoutReminderEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="workoutReminderPush" checked>
                                                <label class="form-check-label" for="workoutReminderPush">
                                                    <i class="fas fa-mobile-alt"></i> Push
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="notification-category">
                                        <div class="notification-category-header">
                                            <h6>Meal Tracking Reminders</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="mealReminders" checked>
                                                <label class="form-check-label" for="mealReminders"></label>
                                            </div>
                                        </div>
                                        <div class="notification-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mealReminderApp" checked>
                                                <label class="form-check-label" for="mealReminderApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mealReminderEmail">
                                                <label class="form-check-label" for="mealReminderEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mealReminderPush" checked>
                                                <label class="form-check-label" for="mealReminderPush">
                                                    <i class="fas fa-mobile-alt"></i> Push
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="notification-category">
                                        <div class="notification-category-header">
                                            <h6>Goal Achievement</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="goalAchievements" checked>
                                                <label class="form-check-label" for="goalAchievements"></label>
                                            </div>
                                        </div>
                                        <div class="notification-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="goalAchievementApp" checked>
                                                <label class="form-check-label" for="goalAchievementApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="goalAchievementEmail" checked>
                                                <label class="form-check-label" for="goalAchievementEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="goalAchievementPush" checked>
                                                <label class="form-check-label" for="goalAchievementPush">
                                                    <i class="fas fa-mobile-alt"></i> Push
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="notification-category">
                                        <div class="notification-category-header">
                                            <h6>New Features & Updates</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="newFeatures" checked>
                                                <label class="form-check-label" for="newFeatures"></label>
                                            </div>
                                        </div>
                                        <div class="notification-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newFeaturesApp" checked>
                                                <label class="form-check-label" for="newFeaturesApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newFeaturesEmail" checked>
                                                <label class="form-check-label" for="newFeaturesEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newFeaturesPush">
                                                <label class="form-check-label" for="newFeaturesPush">
                                                    <i class="fas fa-mobile-alt"></i> Push
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="notification-category">
                                        <div class="notification-category-header">
                                            <h6>Weekly Progress Reports</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="progressReports" checked>
                                                <label class="form-check-label" for="progressReports"></label>
                                            </div>
                                        </div>
                                        <div class="notification-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="progressReportsApp" checked>
                                                <label class="form-check-label" for="progressReportsApp">
                                                    <i class="fas fa-bell"></i> In-App
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="progressReportsEmail" checked>
                                                <label class="form-check-label" for="progressReportsEmail">
                                                    <i class="fas fa-envelope"></i> Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="progressReportsPush">
                                                <label class="form-check-label" for="progressReportsPush">
                                                    <i class="fas fa-mobile-alt"></i> Push
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Save Preferences</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="tab-section" id="account">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Account Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="account-info">
                                        <div class="info-item">
                                            <span class="info-label">Account ID</span>
                                            <span class="info-value">YFJ-12345678</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Email</span>
                                            <span class="info-value">john.doe@example.com</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Membership</span>
                                            <span class="info-value premium">Premium</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Billing Cycle</span>
                                            <span class="info-value">Monthly</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Next Billing Date</span>
                                            <span class="info-value">July 15, 2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Member Since</span>
                                            <span class="info-value">June 15, 2023</span>
                                        </div>
                                    </div>
                                    <div class="account-actions mt-4">
                                        <button class="btn btn-outline-primary">Manage Subscription</button>
                                        <button class="btn btn-outline-primary">Billing History</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Connected Accounts</h5>
                                </div>
                                <div class="card-body">
                                    <div class="connected-accounts">
                                        <div class="connected-account">
                                            <div class="account-info">
                                                <div class="account-icon google">
                                                    <i class="fab fa-google"></i>
                                                </div>
                                                <div class="account-details">
                                                    <h6>Google</h6>
                                                    <p>Connected as john.doe@gmail.com</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger">Disconnect</button>
                                        </div>
                                        <div class="connected-account">
                                            <div class="account-info">
                                                <div class="account-icon facebook">
                                                    <i class="fab fa-facebook-f"></i>
                                                </div>
                                                <div class="account-details">
                                                    <h6>Facebook</h6>
                                                    <p>Not connected</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">Connect</button>
                                        </div>
                                        <div class="connected-account">
                                            <div class="account-info">
                                                <div class="account-icon apple">
                                                    <i class="fab fa-apple"></i>
                                                </div>
                                                <div class="account-details">
                                                    <h6>Apple</h6>
                                                    <p>Not connected</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">Connect</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Privacy Settings</h5>
                                </div>
                                <div class="card-body">
                                    <form id="privacySettingsForm">
                                        <div class="privacy-settings">
                                            <div class="privacy-setting">
                                                <div class="privacy-setting-header">
                                                    <h6>Profile Visibility</h6>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="profileVisibility" checked>
                                                        <label class="form-check-label" for="profileVisibility"></label>
                                                    </div>
                                                </div>
                                                <p class="privacy-setting-description">Allow other users to view your profile and progress</p>
                                            </div>
                                            <div class="privacy-setting">
                                                <div class="privacy-setting-header">
                                                    <h6>Activity Sharing</h6>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="activitySharing" checked>
                                                        <label class="form-check-label" for="activitySharing"></label>
                                                    </div>
                                                </div>
                                                <p class="privacy-setting-description">Share your workout activities with friends</p>
                                            </div>
                                            <div class="privacy-setting">
                                                <div class="privacy-setting-header">
                                                    <h6>Data Collection</h6>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="dataCollection" checked>
                                                        <label class="form-check-label" for="dataCollection"></label>
                                                    </div>
                                                </div>
                                                <p class="privacy-setting-description">Allow us to collect anonymous usage data to improve the app</p>
                                            </div>
                                            <div class="privacy-setting">
                                                <div class="privacy-setting-header">
                                                    <h6>Personalized Recommendations</h6>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="personalizedRecommendations" checked>
                                                        <label class="form-check-label" for="personalizedRecommendations"></label>
                                                    </div>
                                                </div>
                                                <p class="privacy-setting-description">Receive personalized workout and nutrition recommendations</p>
                                            </div>
                                            <div class="privacy-setting">
                                                <div class="privacy-setting-header">
                                                    <h6>Marketing Communications</h6>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="marketingCommunications">
                                                        <label class="form-check-label" for="marketingCommunications"></label>
                                                    </div>
                                                </div>
                                                <p class="privacy-setting-description">Receive marketing emails about new features and offers</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Save Privacy Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Data Management</h5>
                                </div>
                                <div class="card-body">
                                    <div class="data-management">
                                        <div class="data-action">
                                            <div class="data-action-info">
                                                <h6>Export Your Data</h6>
                                                <p>Download all your personal data, workout history, and nutrition logs</p>
                                            </div>
                                            <button class="btn btn-outline-primary">Export Data</button>
                                        </div>
                                        <div class="data-action">
                                            <div class="data-action-info">
                                                <h6>Clear Workout History</h6>
                                                <p>Delete all your workout logs and history</p>
                                            </div>
                                            <button class="btn btn-outline-warning">Clear History</button>
                                        </div>
                                        <div class="data-action">
                                            <div class="data-action-info">
                                                <h6>Clear Nutrition History</h6>
                                                <p>Delete all your nutrition and meal logs</p>
                                            </div>
                                            <button class="btn btn-outline-warning">Clear History</button>
                                        </div>
                                        <div class="data-action danger-zone">
                                            <div class="data-action-info">
                                                <h6>Delete Account</h6>
                                                <p>Permanently delete your account and all associated data</p>
                                            </div>
                                            <button class="btn btn-outline-danger">Delete Account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>