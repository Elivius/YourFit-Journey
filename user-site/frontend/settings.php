<?php
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../backend/preload_settings.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
        <?php require_once '../../utils/message.php'; ?>

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
                    <div class="theme-switch-container me-1">
                        <div class="theme-switch">
                            <input type="checkbox" id="theme-toggle" class="theme-switch-input">
                            <label for="theme-toggle" class="theme-switch-label">
                                <span class="theme-switch-slider">
                                    <span class="switch-handle">
                                        <i class="fas fa-sun theme-icon"></i>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Settings Content -->
            <div class="dashboard-content">
                <!-- Settings Navigation -->
                <div class="row">
                    <div class="col-12">
                        <div class="top-nav mb-5">
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
                                    <form id="pfpForm" action="../backend/process_save_profile_picture.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="form_type" value="pfpForm">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">

                                        <div class="profile-picture-container">
                                            <div class="profile-picture mb-3">
                                                <?php
                                                $profile_pic = (!empty($user['profile_pic'])) ? $user['profile_pic'] : 'default.jpg';
                                                ?>
                                                <img src="assets/images/profile_picture/<?= htmlspecialchars($profile_pic) ?>" 
                                                    alt="Profile Picture" class="img-fluid rounded" width="150" id="profilePreview">
                                            </div>

                                            <!-- Hidden file input -->
                                            <input type="file" name="pfp" id="pfpInput" accept="image/*" style="display: none" required>

                                            <div class="form-message" id="pfpFormMessage"></div>

                                            <!-- Change button (clicks hidden input) -->
                                            <div class="profile-picture-actions mt-0">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('pfpInput').click()">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
                                            <span class="status-value premium">Standard</span>
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
                                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
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
                                            <div class="form-message" id="physicalStatsFormMessage"></div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
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
                                                <button type="submit" class="btn btn-sm btn-primary">Update Password</button>
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
                                                <input type="radio" class="btn-check" name="primary_goal" id="improveEndurance" autocomplete="off" disabled>
                                                <label class="btn btn-outline-secondary w-100 position-relative opacity-75" for="improveEndurance">
                                                    <div class="coming-soon-badge">Coming Soon</div>
                                                    <i class="fas fa-running"></i>
                                                    <div class="fitness-goal-text">Improve Endurance</div>
                                                </label>
                                            </div>

                                        </div>
                                        <div class="form-message" id="primaryGoalFormMessage"></div>
                                        <div class="mt-3 settings-btn-margin">
                                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                        </div>
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
                                                        <div class="macro-pill protein">Little to no exercise</div>
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
                                                        <div class="macro-pill protein">Light exercise 1-3 days/week</div>
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
                                                        <div class="macro-pill protein">Moderate exercise 3-5 days/week</div>
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
                                                        <div class="macro-pill protein">Hard exercise 6-7 days/week</div>
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
                                                        <div class="macro-pill protein">Very hard exercise & physical job</div>
                                                    </div>
                                                    <p>Very intense exercise multiple times per day or physically demanding job.</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-message" id="activityLevelFormMessage"></div>
                                        <div class="mt-3 settings-btn-margin">
                                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="tab-section" id="feedback">
                    <div class="row g-4">                        
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">App Feedback</h5>
                                </div>
                                <div class="card-body">
                                    <form id="feedbackForm" action="../backend/process_save_feedbacks.php" method="POST">
                                        <input type="hidden" name="form_type" value="feedbackForm">
                                        <input type="hidden" name="csrf_token" 
                                            value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="position-relative">
                                                    <label for="feedbackCategory" class="form-label">Feedback Category</label>
                                                    <select class="form-control pe-5" id="category-filter" name="category" required>
                                                        <option value="general_feedback">General Feedback</option>
                                                        <option value="bug_report">Bug Report</option>
                                                        <option value="feature_request" selected>Feature Request</option>
                                                        <option value="user_experience">User Experience</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <i class="bi bi-chevron-down position-absolute select-chevron" id="select-chevron"
                                                    style="top: 70%; right: 15px;"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="feedbackSubject" class="form-label">Subject</label>
                                                <input type="text" class="form-control" id="feedbackSubject" name="subject" placeholder="Request for social sharing features" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="feedbackMessage" class="form-label">Message</label>
                                                <textarea class="form-control" id="feedbackMessage" rows="5" name="message" placeholder="I would love to see social sharing features added to the app. It would be great to be able to share my workout achievements and progress with friends on social media platforms. This would help with motivation and accountability." required></textarea>
                                            </div>
                                            <div class="form-message" id="feedbackFormMessage"></div>
                                            <div class="col-12 settings-btn-margin">
                                                <button type="submit" class="btn btn-sm btn-primary">Submit Feedback</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include 'scroll_to_top.php'; ?>
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/upload-pfp.js"></script>
</body>
</html>