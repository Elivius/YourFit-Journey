<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../backend/dashboard_analytics.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <span class="logo-text">YourFit</span>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <span class="nav-section-title">Main</span>
                    <ul class="nav-menu">
                        <li class="nav-item active">
                            <a href="dashboard.php" class="nav-link">
                                <i class="fas fa-chart-line"></i>
                                <span class="nav-text">Dashboard</span>
                                <div class="nav-indicator"></div>
                            </a>
                        </li>
                    </ul>
                </div>

                <nav class="sidebar-nav">
                    <div class="nav-section">
                        <span class="nav-section-title">Users</span>
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a href="user_management.php" class="nav-link">
                                    <i class="fas fa-users-cog"></i>
                                    <span class="nav-text">User Management</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_feedback.php" class="nav-link">
                                    <i class="fas fa-comment-dots"></i>
                                    <span class="nav-text">User Feedbacks</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <div class="nav-section">
                    <span class="nav-section-title">Diets</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="meal_management.php" class="nav-link">
                                <i class="fas fa-utensils"></i>
                                <span class="nav-text">Meal Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ingredient_management.php" class="nav-link">
                                <i class="fas fa-carrot"></i>
                                <span class="nav-text">Ingredient Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="diet_management.php" class="nav-link">
                                <i class="fas fa-hamburger"></i>
                                <span class="nav-text">Diet Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="nav-section">
                    <span class="nav-section-title">Workouts</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="exercise_management.php" class="nav-link">
                                <i class="fas fa-dumbbell"></i>
                                <span class="nav-text">Exercise Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="user_workout.php" class="nav-link">
                                <i class="fas fa-dumbbell"></i>
                                <span class="nav-text">User Workouts</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">Logs</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="user_meal_log.php" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">User Meal Logs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="weight_log.php" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">Weight Logs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="workout_log.php" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">Workout Logs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="../../user-site/frontend/assets/images/profile_picture/<?= $_SESSION['pfp'] ?>" 
                            alt="Profile Picture" class="user-avatar">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?= $_SESSION['name'] ?></span>
                        <span class="user-role">Admin</span>
                    </div>
                </div>                
                <a href="../../utils/logout.php" class="user-menu-item" id="signOutBtn" style="display: flex; align-items: center; gap: 8px; margin-top: 10px;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="top-bar-left">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        <span class="breadcrumb-item">Dashboard</span>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <div class="welcome-content">
                        <h1>Welcome back, <?= $_SESSION['name'] ?>!</h1>
                        <p>Here's a Real-Time Look at What's Happening on YourFit Journey</p>
                        <div class="welcome-actions">
                            <form action="../backend/export_data.php" method="POST">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-download"></i>
                                    Export Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <!-- User Analytics -->
                    <div class="stat-card primary">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="user_management.php">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="<?= $totalUsers ?>">0</h3>
                            <p class="stat-label">Total Users</p>
                            <div class="stat-change <?= $isPositiveUsers ? 'positive' : 'negative' ?>">
                                <i class="fas fa-arrow-<?= $isPositiveUsers ? 'up' : 'down' ?>"></i>
                                <span><?= $isPositiveUsers ? '+' : '-' ?><?= $percentageTextUsers ?></span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="usersChart" width="100" height="40"></canvas>
                        </div>
                    </div>

                    <!-- Exercise Analytics -->
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="exercise_management.php">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="<?= $totalExercises ?>">0</h3>
                            <p class="stat-label">Exercises Available</p>
                            <div class="stat-change <?= $isPositiveExercises ? 'positive' : 'negative' ?>">
                                <i class="fas fa-arrow-<?= $isPositiveExercises ? 'up' : 'down' ?>"></i>
                                <span><?= $isPositiveExercises ? '+' : '-' ?><?= $percentageTextExercises ?></span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="ratingChart" width="100" height="40"></canvas>
                        </div>
                    </div>
                    
                    <!-- Workout Analytics -->
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="user_workout.php">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="<?= $totalWorkouts ?>">0</h3>
                            <p class="stat-label">Workouts Created by Users</p>
                            <div class="stat-change <?= $isPositiveWorkouts ? 'positive' : 'negative' ?>">
                                <i class="fas fa-arrow-<?= $isPositiveWorkouts ? 'up' : 'down' ?>"></i>
                                <span><?= $isPositiveWorkouts ? '+' : '-' ?><?= $percentageTextWorkouts ?></span>
                                <small>vs last week</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="workoutsChart" width="100" height="40"></canvas>
                        </div>
                    </div>

                    <!-- Diet Analytics -->
                    <div class="stat-card info">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-apple-alt"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="diet_management.php">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="<?= $totalActiveDiets ?>">0</h3>
                            <p class="stat-label">Active Diet Plans</p>
                            <div class="stat-change <?= $isPositiveDiets ? 'positive' : 'negative' ?>">
                                <i class="fas fa-arrow-<?= $isPositiveDiets ? 'up' : 'down' ?>"></i>
                                <span><?= $isPositiveDiets ? '+' : '-' ?><?= $percentageTextDiets ?></span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="dietsChart" width="100" height="40"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions-section">
                    <div class="section-header">
                        <h2>Quick Actions</h2>
                    </div>
                    
                    <div class="quick-actions-grid">
                        <div class="quick-action-card" onclick="window.location.href='user_management.php'">
                            <div class="action-icon users">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="action-content">
                                <h3>Create New User</h3>
                                <p>Register a new member to the platform</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='exercise_management.php'">
                            <div class="action-icon workouts">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="action-content">
                                <h3>Add New Exercise</h3>
                                <p>Create a new exercise</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>

                        <div class="quick-action-card" onclick="window.location.href='user_feedback.php'">
                            <div class="action-icon feedbacks">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="action-content">
                                <h3>View Feedback</h3>
                                <p>Check detailed user feedback</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='diet_management.php'">
                            <div class="action-icon diets">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="action-content">
                                <h3>Add New Diet Plan</h3>
                                <p>Create a new nutrition meal</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='../backend/export_data.php'">
                            <div class="action-icon backup">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="action-content">
                                <h3>Backup Data</h3>
                                <p>Create a backup of your database</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <?php include 'scroll_to_top.php'; ?>
    
    <div id="notification-container"></div>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>