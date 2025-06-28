<?php require_once '../../utils/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
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
        
        <?php include 'side_bar.php'; ?>

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

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Card -->
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h2>Welcome back, <?= $_SESSION['name'] ?>!</h2>
                        <p>You're making great progress. Keep up the good work!</p>
                        <a href="workouts.php?section=my-workouts" class="btn btn-primary">Unleash the Beast</a>
                    </div>
                </div>
                
                <div class="row g-4 align-items-stretch">
                    <!-- Nutrition Breakdown -->
                    <div class="col-lg-4 d-flex">
                        <div class="card flex-grow-1 d-flex flex-column">
                            <div class="card-header">
                                <h5 class="card-title">Daily Nutrition Summary</h5>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <canvas id="macronutrientChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="col-lg-8 d-flex">
                        <div class="card flex-grow-1 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center pt-3 pb-3">
                                <h5 class="card-title">Calendar</h5>
                                <div class="card-actions">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-history"></i> Workout History
                                    </button>
                                </div>
                            </div>
                            <div class="card-body calendar-body">
                                <div class="calendar-container h-100">
                                    <div class="calendar-placeholder h-100">
                                        <!-- Calendar will be rendered here by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Weight Tracker -->
                 <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Weight Tracking - Recent 7 Logs</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="weightChart" height="450"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/summary-meals.js"></script>
    <script src="assets/js/render-calendar.js"></script>
</body>
</html>