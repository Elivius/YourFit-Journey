<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - YourFit Admin</title>
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
                            <a href="dashboard.html" class="nav-link">
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
                                <a href="user.html" class="nav-link">
                                    <i class="fas fa-users-cog"></i>
                                    <span class="nav-text">User Management</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="feedback.html" class="nav-link">
                                    <i class="fas fa-comment-dots"></i>
                                    <span class="nav-text">Feedback Management</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <div class="nav-section">
                    <span class="nav-section-title">Meals</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="meal.html" class="nav-link">
                                <i class="fas fa-utensils"></i>
                                <span class="nav-text">Meal Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ingredient.html" class="nav-link">
                                <i class="fas fa-carrot"></i>
                                <span class="nav-text">Ingredient Management</span>
                                <span class="nav-badge new">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="meal_ingredient.html" class="nav-link">
                                <i class="fas fa-hamburger"></i>
                                <span class="nav-text">Meal and Ingredient Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="nav-section">
                    <span class="nav-section-title">Workouts</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="workout.html" class="nav-link">
                                <i class="fas fa-dumbbell"></i>
                                <span class="nav-text">Workout Management</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">Logs</span>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="user_meal_log.html" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">User Meal Log</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="weight_log.html" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span class="nav-text">Weight Log</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="workout_log.html" class="nav-link">
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
                        <img src="/placeholder.svg?height=40&width=40" alt="Admin">
                        <div class="status-indicator online"></div>
                    </div>
                    <div class="user-info">
                        <span class="user-name">Admin User</span>
                        <span class="user-role">Super Admin</span>
                    </div>
                </div>                
                <a href="#" class="user-menu-item" id="signOutBtn" style="display: flex; align-items: center; gap: 8px; margin-top: 10px;">
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
                        <button class="action-btn" onclick="toggleNotifications()">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
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
                        <h1>Welcome back, Admin! 👋</h1>
                        <p>Here's what's happening with your fitness platform today.</p>
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
                                    <a href="management/user.html">View Details</a>
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
                                    <a href="management/workout.html">View Details</a>
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
                                    <a href="management/diet.html">View Details</a>
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
                                    <a href="management/feedback.html">View Details</a>
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
                        <div class="quick-action-card" onclick="window.location.href='user.html'">
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
                        
                        <div class="quick-action-card" onclick="window.location.href='workout.html'">
                            <div class="action-icon workouts">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="action-content">
                                <h3>Create Workout</h3>
                                <p>Design a new workout program</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        
                        <div class="quick-action-card" onclick="window.location.href='diet.html'">
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
                        
                        <div class="quick-action-card" onclick="window.location.href='feedback.html'">
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
                    
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">
                                <h3>Popular Categories</h3>
                                <p>Most used workout categories</p>
                            </div>
                        </div>
                        <div class="chart-content">
                            <canvas id="categoryChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="recent-activity-section">
                    <div class="section-header">
                        <h2>Recent Activity</h2>
                        <div class="activity-filters">
                            <button class="filter-btn active" data-filter="all">All</button>
                            <button class="filter-btn" data-filter="users">Users</button>
                            <button class="filter-btn" data-filter="workouts">Workouts</button>
                            <button class="filter-btn" data-filter="diets">Diets</button>
                        </div>
                    </div>
                    
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-icon success">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <h4>New user registered</h4>
                                    <span class="activity-time">2 minutes ago</span>
                                </div>
                                <p>Sarah Johnson joined the platform and completed profile setup</p>
                                <div class="activity-actions">
                                    <button class="btn-link">View Profile</button>
                                    <button class="btn-link">Send Welcome</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon primary">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <h4>Workout completed</h4>
                                    <span class="activity-time">15 minutes ago</span>
                                </div>
                                <p>Mike Chen finished "HIIT Cardio Blast" with 95% completion rate</p>
                                <div class="activity-actions">
                                    <button class="btn-link">View Details</button>
                                    <button class="btn-link">Send Congrats</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon warning">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <h4>New 5-star review</h4>
                                    <span class="activity-time">1 hour ago</span>
                                </div>
                                <p>Emma Wilson left an excellent review for "Weight Loss Pro" diet plan</p>
                                <div class="activity-actions">
                                    <button class="btn-link">Read Review</button>
                                    <button class="btn-link">Respond</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon info">
                                <i class="fas fa-apple-alt"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <h4>Diet plan started</h4>
                                    <span class="activity-time">3 hours ago</span>
                                </div>
                                <p>John Doe began following "Muscle Gain Elite" nutrition program</p>
                                <div class="activity-actions">
                                    <button class="btn-link">Track Progress</button>
                                    <button class="btn-link">Send Tips</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-footer">
                        <button class="btn btn-outline" onclick="loadMoreActivity()">
                            <i class="fas fa-plus"></i>
                            Load More Activity
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Notifications Panel -->
    <div class="notifications-panel" id="notificationsPanel">
        <div class="notifications-header">
            <h3>Notifications</h3>
            <button class="btn-link" onclick="markAllAsRead()">Mark all as read</button>
        </div>
        <div class="notifications-list">
            <div class="notification-item unread">
                <div class="notification-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="notification-content">
                    <h4>New user registration</h4>
                    <p>3 new users joined today</p>
                    <span class="notification-time">5 min ago</span>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                    <h4>System maintenance</h4>
                    <p>Scheduled maintenance in 2 hours</p>
                    <span class="notification-time">1 hour ago</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Panel -->
    <div class="quick-actions-panel" id="quickActionsPanel">
        <div class="quick-actions-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="quick-actions-list">
            <button class="quick-action-btn" onclick="window.location.href='user.html#add-user'">
                <i class="fas fa-user-plus"></i>
                <span>Add User</span>
            </button>
            <button class="quick-action-btn" onclick="window.location.href='workout.html#add-workout'">
                <i class="fas fa-dumbbell"></i>
                <span>Create Workout</span>
            </button>
            <button class="quick-action-btn" onclick="window.location.href='diet.html#add-diet'">
                <i class="fas fa-apple-alt"></i>
                <span>Add Diet Plan</span>
            </button>
            <button class="quick-action-btn" onclick="exportAllData()">
                <i class="fas fa-download"></i>
                <span>Export Data</span>
            </button>
        </div>
    </div>
    
    <div id="notification-container"></div>
    <script src="assets/js/dashboard.js"></script>
    <script>

        // Check if admin is logged in
      document.getElementById('signOutBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        localStorage.removeItem("adminLoggedIn");
        localStorage.removeItem("adminLoginTime");
        window.location.replace("login.html");
      });
    </script>
</body>
</html>