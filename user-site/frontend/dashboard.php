<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - YourFit Journey</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body class="dark-theme dashboard-body">
    <div class="dashboard-container">
        
        <?php include 'side-bar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="btn-toggle-sidebar" id="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Dashboard</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <button id="theme-toggle" class="btn btn-icon">
                        <i class="fas fa-moon"></i>
                    </button>
                    <!-- <div class="dropdown notification-dropdown">
                        <button class="btn btn-icon dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge">3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#">
                                <div class="notification-item">
                                    <div class="notification-icon bg-primary">
                                        <i class="fas fa-dumbbell"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>New workout plan available</p>
                                        <span>5 minutes ago</span>
                                    </div>
                                </div>
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <div class="notification-item">
                                    <div class="notification-icon bg-success">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>Reminder: Log your meals</p>
                                        <span>2 hours ago</span>
                                    </div>
                                </div>
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <div class="notification-item">
                                    <div class="notification-icon bg-info">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>You've reached your goal!</p>
                                        <span>1 day ago</span>
                                    </div>
                                </div>
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                        </ul>
                    </div> -->
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Card -->
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h2>Welcome back, John!</h2>
                        <p>You're making great progress. Keep up the good work!</p>
                        <button class="btn btn-primary">Today's Workout</button>
                    </div>
                    <div class="welcome-image">
                        <img src="https://source.unsplash.com/random/300x200/?fitness" alt="Fitness">
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <h6 class="stat-card-title">Workouts Completed</h6>
                                <h2 class="stat-card-value">24</h2>
                                <p class="stat-card-change positive">
                                    <i class="fas fa-arrow-up"></i> 12% from last month
                                </p>
                            </div>
                            <div class="stat-card-icon bg-primary">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <h6 class="stat-card-title">Calories Burned</h6>
                                <h2 class="stat-card-value">12,450</h2>
                                <p class="stat-card-change positive">
                                    <i class="fas fa-arrow-up"></i> 8% from last month
                                </p>
                            </div>
                            <div class="stat-card-icon bg-success">
                                <i class="fas fa-fire"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <h6 class="stat-card-title">Diet Adherence</h6>
                                <h2 class="stat-card-value">85%</h2>
                                <p class="stat-card-change positive">
                                    <i class="fas fa-arrow-up"></i> 5% from last month
                                </p>
                            </div>
                            <div class="stat-card-icon bg-warning">
                                <i class="fas fa-utensils"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <h6 class="stat-card-title">Goal Progress</h6>
                                <h2 class="stat-card-value">67%</h2>
                                <p class="stat-card-change positive">
                                    <i class="fas fa-arrow-up"></i> 15% from last month
                                </p>
                            </div>
                            <div class="stat-card-icon bg-info">
                                <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Workout Activity</h5>
                                <div class="card-actions">
                                    <select class="form-select form-select-sm">
                                        <option>This Month</option>
                                        <option>This Week</option>
                                        <option>This Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="workoutActivityChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Nutrition Breakdown</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="nutritionChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Calendar and Today's Workouts -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Calendar</h5>
                                <div class="card-actions">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus"></i> Add Event
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="calendar-container">
                                    <!-- Calendar will be rendered here by JavaScript -->
                                    <div class="calendar-placeholder">
                                        <div class="calendar-header">
                                            <button class="btn btn-sm btn-icon"><i class="fas fa-chevron-left"></i></button>
                                            <h6>May 2023</h6>
                                            <button class="btn btn-sm btn-icon"><i class="fas fa-chevron-right"></i></button>
                                        </div>
                                        <table class="calendar-table">
                                            <thead>
                                                <tr>
                                                    <th>Sun</th>
                                                    <th>Mon</th>
                                                    <th>Tue</th>
                                                    <th>Wed</th>
                                                    <th>Thu</th>
                                                    <th>Fri</th>
                                                    <th>Sat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Calendar days will be generated by JavaScript -->
                                                <tr>
                                                    <td class="inactive">30</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td class="has-event">4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td class="has-event">8</td>
                                                    <td>9</td>
                                                    <td>10</td>
                                                    <td>11</td>
                                                    <td class="has-event">12</td>
                                                    <td>13</td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>15</td>
                                                    <td class="has-event">16</td>
                                                    <td>17</td>
                                                    <td>18</td>
                                                    <td>19</td>
                                                    <td class="has-event">20</td>
                                                </tr>
                                                <tr>
                                                    <td>21</td>
                                                    <td>22</td>
                                                    <td>23</td>
                                                    <td class="active today">24</td>
                                                    <td>25</td>
                                                    <td class="has-event">26</td>
                                                    <td>27</td>
                                                </tr>
                                                <tr>
                                                    <td>28</td>
                                                    <td>29</td>
                                                    <td>30</td>
                                                    <td>31</td>
                                                    <td class="inactive">1</td>
                                                    <td class="inactive">2</td>
                                                    <td class="inactive">3</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Today's Workouts</h5>
                                <div class="card-actions">
                                    <a href="workouts.html" class="btn btn-sm btn-link">View All</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="workout-list">
                                    <li class="workout-item">
                                        <div class="workout-time">
                                            <span>08:00 AM</span>
                                        </div>
                                        <div class="workout-content">
                                            <h6>Morning Cardio</h6>
                                            <p>30 min • Moderate intensity</p>
                                        </div>
                                        <div class="workout-actions">
                                            <button class="btn btn-sm btn-primary">Start</button>
                                        </div>
                                    </li>
                                    <li class="workout-item">
                                        <div class="workout-time">
                                            <span>12:30 PM</span>
                                        </div>
                                        <div class="workout-content">
                                            <h6>Lunch Break Yoga</h6>
                                            <p>20 min • Low intensity</p>
                                        </div>
                                        <div class="workout-actions">
                                            <button class="btn btn-sm btn-primary">Start</button>
                                        </div>
                                    </li>
                                    <li class="workout-item">
                                        <div class="workout-time">
                                            <span>06:00 PM</span>
                                        </div>
                                        <div class="workout-content">
                                            <h6>Upper Body Strength</h6>
                                            <p>45 min • High intensity</p>
                                        </div>
                                        <div class="workout-actions">
                                            <button class="btn btn-sm btn-primary">Start</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Progress</h5>
                        <div class="card-actions">
                            <a href="progress.html" class="btn btn-sm btn-link">View Details</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="progress-item">
                                    <div class="progress-header">
                                        <h6>Weight Goal</h6>
                                        <span>75 kg / 70 kg</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="progress-text">You're 5 kg away from your goal</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress-item">
                                    <div class="progress-header">
                                        <h6>Strength Training</h6>
                                        <span>Level 4 / 10</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="progress-text">Keep pushing to reach the next level</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress-item">
                                    <div class="progress-header">
                                        <h6>Cardio Endurance</h6>
                                        <span>Level 6 / 10</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="progress-text">Great progress! Keep it up</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress-item">
                                    <div class="progress-header">
                                        <h6>Flexibility</h6>
                                        <span>Level 3 / 10</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="progress-text">Consider adding more stretching exercises</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>