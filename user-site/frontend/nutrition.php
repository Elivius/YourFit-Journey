<?php require_once '../../utils/auth.php'; ?>


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
                                    <i class="fas fa-sun sun-icon"></i>
                                    <i class="fas fa-moon moon-icon"></i>
                                    <span class="switch-handle"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Nutrition Content -->
            <div class="dashboard-content">
                <!-- Nutrition Summary -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Today's Nutrition Summary</h5>
                                <div class="card-actions">
                                    <div class="date-selector">
                                        <button class="btn btn-sm btn-icon"><i class="fas fa-chevron-left"></i></button>
                                        <span>May 24, 2023</span>
                                        <button class="btn btn-sm btn-icon"><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
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
                                                    <span>1,450 / 2,000 cal</span>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 72.5%" aria-valuenow="72.5" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <p class="goal-text">550 calories remaining</p>
                                            </div>
                                            <div class="macros-breakdown">
                                                <div class="macro-item">
                                                    <div class="macro-icon protein">
                                                        <i class="fas fa-drumstick-bite"></i>
                                                    </div>
                                                    <div class="macro-content">
                                                        <div class="macro-header">
                                                            <h6>Protein</h6>
                                                            <span>85g / 150g</span>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56.7%" aria-valuenow="56.7" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                            <span>120g / 200g</span>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                            <span>45g / 65g</span>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 69.2%" aria-valuenow="69.2" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Water Intake</h5>
                            </div>
                            <div class="card-body">
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
                    </div>
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
                            <!-- Breakfast -->
                            <div class="meal-section">
                                <div class="meal-header">
                                    <div class="meal-title">
                                        <i class="fas fa-sun"></i>
                                        <h6>Breakfast</h6>
                                    </div>
                                    <div class="meal-summary">
                                        <span>450 cal</span>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> Add Food
                                        </button>
                                    </div>
                                </div>
                                <div class="meal-items">
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Greek Yogurt with Berries</h6>
                                            <p>1 cup yogurt, 1/2 cup mixed berries, 1 tbsp honey</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>250 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>20g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>30g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>5g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Whole Grain Toast</h6>
                                            <p>2 slices with 1 tbsp almond butter</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>200 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>8g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>25g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>8g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Lunch -->
                            <div class="meal-section">
                                <div class="meal-header">
                                    <div class="meal-title">
                                        <i class="fas fa-cloud-sun"></i>
                                        <h6>Lunch</h6>
                                    </div>
                                    <div class="meal-summary">
                                        <span>650 cal</span>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> Add Food
                                        </button>
                                    </div>
                                </div>
                                <div class="meal-items">
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Grilled Chicken Salad</h6>
                                            <p>4oz chicken breast, mixed greens, cherry tomatoes, cucumber, 2 tbsp balsamic vinaigrette</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>350 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>35g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>15g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>18g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Quinoa</h6>
                                            <p>1 cup cooked</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>220 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>8g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>40g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>4g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Apple</h6>
                                            <p>1 medium</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>80 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>0g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>20g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>0g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dinner -->
                            <div class="meal-section">
                                <div class="meal-header">
                                    <div class="meal-title">
                                        <i class="fas fa-moon"></i>
                                        <h6>Dinner</h6>
                                    </div>
                                    <div class="meal-summary">
                                        <span>350 cal</span>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> Add Food
                                        </button>
                                    </div>
                                </div>
                                <div class="meal-items">
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Baked Salmon</h6>
                                            <p>5oz fillet with lemon and herbs</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>250 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>30g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>0g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>15g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Steamed Broccoli</h6>
                                            <p>1 cup</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>50 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>3g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>10g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>0g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="meal-item">
                                        <div class="meal-item-info">
                                            <h6>Sweet Potato</h6>
                                            <p>1/2 medium, baked</p>
                                        </div>
                                        <div class="meal-item-macros">
                                            <div class="macro-pill">
                                                <span>50 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>1g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>12g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>0g F</span>
                                            </div>
                                        </div>
                                        <div class="meal-item-actions">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Snacks -->
                            <div class="meal-section">
                                <div class="meal-header">
                                    <div class="meal-title">
                                        <i class="fas fa-cookie"></i>
                                        <h6>Snacks</h6>
                                    </div>
                                    <div class="meal-summary">
                                        <span>0 cal</span>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> Add Food
                                        </button>
                                    </div>
                                </div>
                                <div class="meal-items">
                                    <div class="empty-state">
                                        <i class="fas fa-utensils"></i>
                                        <p>No snacks logged yet. Click "Add Food" to log your snacks.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Meal Recommendations -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Personalized Meal Recommendations</h5>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="recipe-card">
                                    <div class="recipe-image">
                                        <img src="https://source.unsplash.com/random/300x200/?healthy-breakfast" alt="Breakfast Recipe" class="img-fluid rounded">
                                        <div class="recipe-time">
                                            <i class="fas fa-clock"></i> 15 min
                                        </div>
                                    </div>
                                    <div class="recipe-content">
                                        <h6>Protein-Packed Breakfast Bowl</h6>
                                        <p>A quick and nutritious breakfast with eggs, avocado, and quinoa.</p>
                                        <div class="recipe-macros">
                                            <div class="macro-pill">
                                                <span>350 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>25g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>30g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>15g F</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-3 w-100">View Recipe</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="recipe-card">
                                    <div class="recipe-image">
                                        <img src="https://source.unsplash.com/random/300x200/?healthy-lunch" alt="Lunch Recipe" class="img-fluid rounded">
                                        <div class="recipe-time">
                                            <i class="fas fa-clock"></i> 20 min
                                        </div>
                                    </div>
                                    <div class="recipe-content">
                                        <h6>Mediterranean Chicken Wrap</h6>
                                        <p>Grilled chicken with hummus, veggies, and whole grain wrap.</p>
                                        <div class="recipe-macros">
                                            <div class="macro-pill">
                                                <span>450 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>35g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>40g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>18g F</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-3 w-100">View Recipe</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="recipe-card">
                                    <div class="recipe-image">
                                        <img src="https://source.unsplash.com/random/300x200/?healthy-dinner" alt="Dinner Recipe" class="img-fluid rounded">
                                        <div class="recipe-time">
                                            <i class="fas fa-clock"></i> 25 min
                                        </div>
                                    </div>
                                    <div class="recipe-content">
                                        <h6>One-Pan Salmon & Vegetables</h6>
                                        <p>Baked salmon with roasted vegetables and herbs.</p>
                                        <div class="recipe-macros">
                                            <div class="macro-pill">
                                                <span>380 cal</span>
                                            </div>
                                            <div class="macro-pill protein">
                                                <span>30g P</span>
                                            </div>
                                            <div class="macro-pill carbs">
                                                <span>20g C</span>
                                            </div>
                                            <div class="macro-pill fats">
                                                <span>22g F</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-3 w-100">View Recipe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Tips -->
                <div class="card mb-4">
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
                                    <p>Dedicate a few hours each weekend to prepare meals for the week. This saves time and helps you stick to your nutrition plan.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Stay Hydrated</h6>
                                    <p>Aim for at least 8 glasses of water daily. Sometimes hunger is actually thirst in disguise.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Balanced Macros</h6>
                                    <p>Include protein, carbs, and healthy fats in each meal for sustained energy and better nutrient absorption.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Mindful Eating</h6>
                                    <p>Eat slowly and without distractions to better recognize hunger and fullness cues.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Food Modal -->
    <div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="addFoodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFoodModalLabel">Add Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="food-search mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for a food...">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    <div class="food-tabs">
                        <ul class="nav nav-tabs" id="foodTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent" type="button" role="tab" aria-controls="recent" aria-selected="true">Recent</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="my-foods-tab" data-bs-toggle="tab" data-bs-target="#my-foods" type="button" role="tab" aria-controls="my-foods" aria-selected="false">My Foods</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="database-tab" data-bs-toggle="tab" data-bs-target="#database" type="button" role="tab" aria-controls="database" aria-selected="false">Database</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="foodTabsContent">
                            <div class="tab-pane fade show active" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                                <div class="food-list">
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Greek Yogurt</h6>
                                            <p>1 cup (245g)</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>150 cal</span>
                                            <span>20g P</span>
                                            <span>8g C</span>
                                            <span>4g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Chicken Breast</h6>
                                            <p>4 oz (113g), cooked</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>165 cal</span>
                                            <span>31g P</span>
                                            <span>0g C</span>
                                            <span>3.6g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Quinoa</h6>
                                            <p>1 cup (185g), cooked</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>222 cal</span>
                                            <span>8g P</span>
                                            <span>39g C</span>
                                            <span>3.6g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="my-foods" role="tabpanel" aria-labelledby="my-foods-tab">
                                <div class="food-list">
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Homemade Protein Smoothie</h6>
                                            <p>1 serving (16 oz)</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>320 cal</span>
                                            <span>30g P</span>
                                            <span>40g C</span>
                                            <span>6g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Meal Prep Chicken & Rice</h6>
                                            <p>1 container (350g)</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>450 cal</span>
                                            <span>40g P</span>
                                            <span>45g C</span>
                                            <span>10g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="database" role="tabpanel" aria-labelledby="database-tab">
                                <div class="food-categories mb-3">
                                    <button class="btn btn-sm btn-outline-primary active">All</button>
                                    <button class="btn btn-sm btn-outline-primary">Proteins</button>
                                    <button class="btn btn-sm btn-outline-primary">Carbs</button>
                                    <button class="btn btn-sm btn-outline-primary">Fruits & Vegetables</button>
                                    <button class="btn btn-sm btn-outline-primary">Dairy</button>
                                </div>
                                <div class="food-list">
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Egg</h6>
                                            <p>1 large (50g)</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>70 cal</span>
                                            <span>6g P</span>
                                            <span>0g C</span>
                                            <span>5g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Banana</h6>
                                            <p>1 medium (118g)</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>105 cal</span>
                                            <span>1.3g P</span>
                                            <span>27g C</span>
                                            <span>0.4g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                    <div class="food-item">
                                        <div class="food-info">
                                            <h6>Salmon</h6>
                                            <p>3 oz (85g), cooked</p>
                                        </div>
                                        <div class="food-macros">
                                            <span>175 cal</span>
                                            <span>19g P</span>
                                            <span>0g C</span>
                                            <span>11g F</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create Custom Food</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/nutrition.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>