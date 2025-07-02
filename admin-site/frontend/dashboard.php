<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
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
                                    <span class="nav-text">User Feedback</span>
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
                            <a href="meal_ingredient_management.php" class="nav-link">
                                <i class="fas fa-hamburger"></i>
                                <span class="nav-text">Diet Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="nav-section">
                    <span class="nav-section-title">Exercises</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="exercise_management.php" class="nav-link">
                                <i class="fas fa-dumbbell"></i>
                                <span class="nav-text">Exercise Management</span>
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
                                <span class="nav-text">User Meal Log</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="weight_log.php" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">Weight Log</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="workout_log.php" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">Workout Log</span>
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
                
                <div class="top-bar-right">                   
                    <div class="top-bar-actions">                        
                        <button class="action-btn" onclick="toggleQuickActions()">
                            <i class="fas fa-plus"></i>
                        </button>
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
                            <button class="btn btn-primary" onclick="openModal('quickStatsModal')">
                                <i class="fas fa-chart-line"></i>
                                View Analytics
                            </button>
                            <button class="btn btn-outline" onclick="exportDashboardData()">
                                <i class="fas fa-download"></i>
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Grid -->
                <div class="stats-grid">
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
                                    <!-- <a href="#" onclick="exportUsers()">Export</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="1234">0</h3>
                            <p class="stat-label">Total Users</p>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>+12.5%</span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="usersChart" width="100" height="40"></canvas>
                        </div>
                    </div>
                    
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="exercise_management.php">View Details</a>
                                    <!-- <a href="#" onclick="exportWorkouts()">Export</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="2456">0</h3>
                            <p class="stat-label">Workouts Completed</p>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>+8.3%</span>
                                <small>vs last week</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="workoutsChart" width="100" height="40"></canvas>
                        </div>
                    </div>
                    
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-apple-alt"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="meal_ingredient_management.php">View Details</a>
                                    <!-- <a href="#" onclick="exportDiets()">Export</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="89">0</h3>
                            <p class="stat-label">Active Diet Plans</p>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>+15.7%</span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="dietsChart" width="100" height="40"></canvas>
                        </div>
                    </div>
                    
                    <div class="stat-card info">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-menu">
                                <button class="stat-menu-btn" onclick="toggleStatMenu(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="stat-menu-dropdown">
                                    <a href="feedback_management.php">View Details</a>
                                    <!-- <a href="#" onclick="exportFeedback()">Export</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number" data-target="4.8">0</h3>
                            <p class="stat-label">Average Rating</p>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>+0.3</span>
                                <small>vs last month</small>
                            </div>
                        </div>
                        <div class="stat-chart">
                            <canvas id="ratingChart" width="100" height="40"></canvas>
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
                                <h3>Add New User</h3>
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
                                <h3>Create Exercise</h3>
                                <p>Create a new exercise</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='meal_ingredient_management.php'">
                            <div class="action-icon diets">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="action-content">
                                <h3>Add Diet Plan</h3>
                                <p>Create a personalized nutrition plan</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='user_feedback.php'">
                            <div class="action-icon reports">
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
                        
                        <div class="quick-action-card" onclick="openModal('bulkImportModal')">
                            <div class="action-icon import">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="action-content">
                                <h3>Bulk Import</h3>
                                <p>Import data from CSV or Excel files</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="openModal('backupModal')">
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
                
                <!-- Charts Section -->
                <div class="charts-section">
                    <div class="chart-container large">
                        <div class="chart-header">
                            <div class="chart-title">
                                <h3>User Activity Overview</h3>
                                <p>Track user engagement and platform usage</p>
                            </div>
                            <div class="chart-controls">
                                <div class="time-selector">
                                    <button class="time-btn active" data-period="7d">7D</button>
                                    <button class="time-btn" data-period="30d">30D</button>
                                    <button class="time-btn" data-period="90d">90D</button>
                                    <button class="time-btn" data-period="1y">1Y</button>
                                </div>
                                <button class="chart-menu-btn" onclick="toggleChartMenu(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-content">
                            <canvas id="activityChart" width="800" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Quick Actions Panel -->
    <div class="quick-actions-panel" id="quickActionsPanel">
        <div class="quick-actions-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="quick-actions-list">
            <button class="quick-action-btn" onclick="window.location.href='user_management.php#add-user'">
                <i class="fas fa-user-plus"></i>
                <span>Add User</span>
            </button>
            <button class="quick-action-btn" onclick="window.location.href='exercise_management.php#add-workout'">
                <i class="fas fa-dumbbell"></i>
                <span>Create Exercise</span>
            </button>
            <button class="quick-action-btn" onclick="window.location.href='meal_ingredient_management.php#add-diet'">
                <i class="fas fa-apple-alt"></i>
                <span>Add Diet Plan</span>
            </button>
            <button class="quick-action-btn" onclick="exportAllData()">
                <i class="fas fa-download"></i>
                <span>Export Data</span>
            </button>
        </div>
    </div>
    
    <?php include 'scroll_to_top.php'; ?>
    
    <div id="notification-container"></div>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>