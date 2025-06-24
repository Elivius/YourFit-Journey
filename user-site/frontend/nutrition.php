<?php
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../backend/preload_meal_logs.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition - YourFit Journey</title>
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
    <link rel="stylesheet" href="assets/css/log-meal-modal.css">
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
                    <h1 class="page-title">Nutrition</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="theme-switch-container">
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

            <!-- Nutrition Content -->
            <div class="dashboard-content">
                <!-- Nutrition Summary -->
                <div class="row g-4 align-items-stretch">
                    <div class="col-12 d-flex">
                    <!-- <div class="col-lg-8 d-flex"> -->
                        <div class="card flex-fill d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Today's Nutrition Summary</h5>
                                <div class="card-actions">
                                    <div class="date-selector d-flex align-items-center gap-2">
                                        <button class="btn btn-sm btn-icon" id="prev-date"><i class="fas fa-chevron-left"></i></button>
                                        <span id="current-date">--</span>
                                        <button class="btn btn-sm btn-icon" id="next-date"><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body flex-grow-1 d-flex align-items-center">
                                <div class="w-100">
                                    <div class="row row align-items-center">
                                        <div class="col-md-6">
                                            <div class="nutrition-chart-container">
                                                <canvas id="macronutrientChart" height="250"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="nutrition-summary">
                                                <div class="nutrition-goal">
                                                    <div class="goal-header">
                                                        <h6>Calories</h6>
                                                        <span id="calories-summary">-- / -- kcal</span>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="calories-bar" class="progress-bar progress-bar-calories" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="goal-text" id="calories-remaining">-- calories remaining</p>
                                                </div>
                                                <div class="macros-breakdown">
                                                    <div class="macro-item">
                                                        <div class="macro-icon protein">
                                                            <i class="fas fa-drumstick-bite"></i>
                                                        </div>
                                                        <div class="macro-content">
                                                            <div class="macro-header">
                                                                <h6>Protein</h6>
                                                                <span id="protein-summary">--g / --g</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div id="protein-bar" class="progress-bar progress-bar-protein" role="progressbar" style="width: 0%" aria-valuenow="0"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="macro-item">
                                                        <div class="macro-icon carbs">
                                                            <i class="fas fa-bread-slice"></i>
                                                        </div>
                                                        <div class="macro-content">
                                                            <div class="macro-header">
                                                                <h6>Carbs</h6>
                                                                <span id="carbs-summary">--g / --g</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div id="carbs-bar" class="progress-bar progress-bar-carbs" role="progressbar" style="width: 0%" aria-valuenow="0"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="macro-item">
                                                        <div class="macro-icon fats">
                                                            <i class="fas fa-cheese"></i>
                                                        </div>
                                                        <div class="macro-content">
                                                            <div class="macro-header">
                                                                <h6>Fats</h6>
                                                                <span id="fats-summary">--g / --g</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div id="fats-bar" class="progress-bar progress-bar-fats" role="progressbar" style="width: 0%" aria-valuenow="0"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 d-flex">
                        <div class="card flex-fill d-flex flex-column">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Water Intake</h5>
                            </div>
                            <div class="card-body flex-grow-1 d-flex align-items-center justify-content-center">
                                <div class="water-tracker">
                                    <div class="water-visual">
                                        <div class="water-container">
                                            <div class="water-level" style="height: 60%;"></div>
                                            <div class="water-overlay">
                                                <span>6/10</span>
                                                <small>glasses</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="water-controls">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="water-info">
                                        <p>Daily Goal: 10 glasses (2.5L)</p>
                                        <p>Current: 6 glasses (1.5L)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Today's Meals -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Today's Meals</h5>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-history"></i> Meal History
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="meal-list">
                        <?php foreach ($mealsByCategory as $category => $meals): ?>
                            <div class="meal-section">
                                <div class="meal-header">
                                    <div class="meal-title mx-1">
                                        <?php
                                            $icons = [
                                                'breakfast' => 'fas fa-sun',
                                                'lunch' => 'fas fa-cloud-sun',
                                                'dinner' => 'fas fa-moon'
                                            ];
                                        ?>
                                        <i class="<?= $icons[$category] ?>"></i>
                                        <h6><?= ucfirst($category) ?></h6>
                                    </div>
                                    <div class="meal-summary">
                                        <span>
                                            <?= array_sum(array_column($meals, 'calories')) ?> cal
                                        </span>
                                        <button class="btn btn-sm btn-primary" onclick="openMealModal(this)" data-category="<?= $category ?>">
                                            <i class="fas fa-plus"></i> Add Food
                                        </button>
                                    </div>
                                </div>

                                <div class="meal-items">
                                    <?php if (count($meals) === 0): ?>
                                        <div class="empty-state">
                                            <i class="fas fa-utensils"></i>
                                            <p>No <?= $category ?> logged yet. Click "Add Food" to log your <?= $category ?></p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($meals as $meal): ?>
                                            <div class="meal-item">
                                                <div class="meal-item-info">
                                                    <h6><?= htmlspecialchars($meal['meal_name']) ?></h6>
                                                    <p>Logged at <?= $meal['time'] ?></p>
                                                </div>
                                                <div class="meal-item-macros">
                                                    <div class="macro-pill protein"><strong><?= $meal['protein'] ?>g </strong> Protein</div>
                                                    <div class="macro-pill carbs"><strong><?= $meal['carbs'] ?>g </strong> Carbs</div>
                                                    <div class="macro-pill fats"><strong><?= $meal['fats'] ?>g </strong> Fats</div>
                                                    <div class="macro-pill calories"><strong><?= $meal['calories'] ?></strong> kcal</div>
                                                </div>
                                                <div class="meal-item-actions">
                                                    <button class="btn btn-sm btn-icon"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Meal Recommendations -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Personalized Meal Recommendations</h5>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-outline-primary btn-refresh">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4" id="meal-recommendations-container">
                            <!-- Meals inject by AJAX -->
                        </div>
                    </div>
                </div>

                <!-- Nutrition Tips -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h5 class="card-title">Nutrition Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="workout-tips">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Meal Prep for Success</h6>
                                    <p class="muted-p">Dedicate a few hours each weekend to prepare meals for the week. This saves time and helps you stick to your nutrition plan.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Stay Hydrated</h6>
                                    <p class="muted-p">Aim for at least 8 glasses of water daily. Sometimes hunger is actually thirst in disguise.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Balanced Macros</h6>
                                    <p class="muted-p">Include protein, carbs, and healthy fats in each meal for sustained energy and better nutrient absorption.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Mindful Eating</h6>
                                    <p class="muted-p">Eat slowly and without distractions to better recognize hunger and fullness cues.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Meal Input Modal -->
    <div id="mealModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Add Meal (<span id="mealCategoryLabel"></span>)</h5>
                <button class="close-btn" onclick="closeMealModal()">
                     <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="mealLogForm" action="../backend/process_save_meal_logs.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                    <input type="hidden" name="category" id="mealCategoryInput">
                    <div class="form">
                        <label for="mealName" class="form-label">Meal Name</label>
                        <input type="text" id="mealName" class="form-control" name="meal_name" placeholder="Enter meal name" required>
                    </div>

                    <div class="macros-grid">
                        <div class="form">
                            <label for="protein" class="form-label">Protein (g)</label>
                            <input type="number" id="protein" class="form-control" name="protein" placeholder="0" min="0" step="0.1" required>
                        </div>
                        
                        <div class="form">
                            <label for="carbs" class="form-label">Carbs (g)</label>
                            <input type="number" id="carbs" class="form-control" name="carbs" placeholder="0" min="0" step="0.1" required>
                        </div>
                        
                        <div class="form">
                            <label for="fats" class="form-label">Fats (g)</label>
                            <input type="number" id="fats" class="form-control" name="fats" placeholder="0" min="0" step="0.1" required>
                        </div>
                        
                        <div class="form">
                            <label for="calories" class="form-label">Calories</label>
                            <input type="number" id="calories" class="form-control" name="calories" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" onclick="closeMealModal()">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="saveMealBtn">
                            <i class="fas fa-save"></i> Save Meal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Modal Backdrop -->
    <div id="modalBackdrop" class="modal-backdrop"></div>

    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/customize-meals.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/log-meal-modal.js"></script>
    <script src="assets/js/summary-meals.js"></script>
</body>
</html>