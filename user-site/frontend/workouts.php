<?php
require_once '../../utils/auth.php';
require_once '../backend/preload_all_workouts.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts - YourFit Journey</title>
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
<body class="dark-theme dashboard-body workouts-page">
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
                    <h1 class="page-title">Workouts</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="header-right">
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
                   
                </div>
            </header>

            <!-- Workout Content -->
            <div class="dashboard-content">
                <!-- Workout Navigation -->
                <div class="row">
                    <div class="col-12">
                        <div class="top-nav mb-5">
                            <button class="top-nav-item active" data-target="pre-built-workouts">
                                <i class="fas fa-layer-group"></i>
                                <span>Pre-built Workouts</span>
                            </button>
                            <button class="top-nav-item" data-target="my-workouts">
                                <i class="fas fa-folder-open"></i>
                                <span>My Workouts</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pre-built Workouts Section -->
                <div class="tab-section active" id="pre-built-workouts">
                    <!-- Workout Categories -->
                    <div class="workout-categories">
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <div class="workout-category-card active" data-category="chest">
                                    <div class="workout-category-icon">
                                        <i class="fas fa-fist-raised"></i>
                                    </div>
                                    <h4>Chest</h4>
                                    <p>Target pectoral muscles and shoulders</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="back">
                                    <div class="workout-category-icon">
                                        <i class="fas fa-swimmer"></i>
                                    </div>
                                    <h4>Back</h4>
                                    <p>Strengthen your back and improve posture</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="legs">
                                    <div class="workout-category-icon">
                                        <i class="fas fa-running"></i>
                                    </div>
                                    <h4>Legs</h4>
                                    <p>Focus on quadriceps, hamstrings, and calves</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="arms">
                                    <div class="workout-category-icon">
                                        <i class="fas fa-child"></i>
                                    </div>
                                    <h4>Arms</h4>
                                    <p>Target biceps, triceps, and shoulders</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workout Category Sections -->
                    <div class="workout-category-sections">
                        <!-- Chest Workouts -->
                        <div id="pre-built-chest-workouts" class="workout-category-section active">
                            <!-- Chest Exercises -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Exercises</h5>
                                    <div class="card-actions">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion workout-exercises" id="chestWorkoutExercises">
                                        <!-- Exercise 1 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="chestExercise1Heading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#chestExercise1Collapse" aria-expanded="true" aria-controls="chestExercise1Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">1</span>
                                                        <div class="exercise-title">
                                                            <h6 class="mb-2">Barbell Bench Press</h6>
                                                            <p class="mb-2 muted-p small">Target muscles:</p>

                                                            <div class="d-flex flex-wrap gap-2 mb-0">
                                                                <span class="alternative-badge">Chest</span>
                                                                <span class="alternative-badge">Shoulders</span>
                                                                <span class="alternative-badge">Triceps</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="chestExercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="chestExercise1Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?bench-press" alt="Barbell Bench Press" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6 class="muted-p">Instructions:</h6>
                                                                    <ol class="small">
                                                                        <li class="mb-2">Lie on a flat bench with feet firmly on the ground.</li>
                                                                        <li class="mb-2">Grip the barbell slightly wider than shoulder-width.</li>
                                                                        <li class="mb-2">Lower the bar to your chest with control.</li>
                                                                        <li class="mb-2">Press the bar back up to starting position.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Sets:</span>
                                                                        <span class="parameter-value">4</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Reps:</span>
                                                                        <span class="parameter-value">8-10</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Rest:</span>
                                                                        <span class="parameter-value">2-3 min</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Weight:</span>
                                                                        <span class="parameter-value">Moderate to heavy</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Dumbbell Bench Press</span>
                                                                    <span class="alternative-badge">Push-ups</span>
                                                                    <span class="alternative-badge">Chest Press Machine</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Exercise 2 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="chestExercise2Heading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#chestExercise2Collapse" aria-expanded="false" aria-controls="chestExercise2Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">2</span>
                                                        <div class="exercise-title">
                                                            <h6 class="mb-2">Incline Dumbbell Press</h6>
                                                            <p class="mb-2 muted-p small">Target muscles:</p>

                                                            <div class="d-flex flex-wrap gap-2 mb-0">
                                                                <span class="alternative-badge">Upper Chest</span>
                                                                <span class="alternative-badge">Shoulders</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="chestExercise2Collapse" class="accordion-collapse collapse" aria-labelledby="chestExercise2Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?incline-press" alt="Incline Dumbbell Press" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6>Instructions:</h6>
                                                                    <ol>
                                                                        <li>Set bench to 30-45 degree incline.</li>
                                                                        <li>Hold dumbbells at chest level with palms facing forward.</li>
                                                                        <li>Press dumbbells up and slightly inward.</li>
                                                                        <li>Lower with control back to starting position.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Sets:</span>
                                                                        <span class="parameter-value">3</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Reps:</span>
                                                                        <span class="parameter-value">10-12</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Rest:</span>
                                                                        <span class="parameter-value">90 sec</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Weight:</span>
                                                                        <span class="parameter-value">Moderate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Incline Barbell Press</span>
                                                                    <span class="alternative-badge">Incline Push-ups</span>
                                                                    <span class="alternative-badge">Cable Flyes</span>
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

                        <!-- Back Workouts -->
                        <div id="pre-built-back-workouts" class="workout-category-section">
                            <!-- Back Exercises -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Exercises</h5>
                                    <div class="card-actions">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion workout-exercises" id="backWorkoutExercises">
                                        <!-- Exercise 1 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="backExercise1Heading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#backExercise1Collapse" aria-expanded="true" aria-controls="backExercise1Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">1</span>
                                                        <div class="exercise-title">
                                                            <h6>Pull-ups</h6>
                                                            <span class="exercise-target">Target: Lats, Rhomboids, Biceps</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="backExercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="backExercise1Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?pullup" alt="Pull-ups" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6>Instructions:</h6>
                                                                    <ol>
                                                                        <li>Hang from pull-up bar with hands slightly wider than shoulders.</li>
                                                                        <li>Pull your body up until chin clears the bar.</li>
                                                                        <li>Lower yourself with control to starting position.</li>
                                                                        <li>Keep core engaged throughout the movement.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Sets:</span>
                                                                        <span class="parameter-value">4</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Reps:</span>
                                                                        <span class="parameter-value">6-10</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Rest:</span>
                                                                        <span class="parameter-value">2-3 min</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Weight:</span>
                                                                        <span class="parameter-value">Bodyweight</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Assisted Pull-ups</span>
                                                                    <span class="alternative-badge">Lat Pulldown</span>
                                                                    <span class="alternative-badge">Inverted Rows</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Exercise 2 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="backExercise2Heading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#backExercise2Collapse" aria-expanded="false" aria-controls="backExercise2Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">2</span>
                                                        <div class="exercise-title">
                                                            <h6>Barbell Rows</h6>
                                                            <span class="exercise-target">Target: Mid Traps, Rhomboids, Lats</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="backExercise2Collapse" class="accordion-collapse collapse" aria-labelledby="backExercise2Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?barbell-row" alt="Barbell Rows" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6>Instructions:</h6>
                                                                    <ol>
                                                                        <li>Stand with feet hip-width apart, holding barbell with overhand grip.</li>
                                                                        <li>Hinge at hips, keeping back straight and chest up.</li>
                                                                        <li>Pull barbell to lower chest/upper abdomen.</li>
                                                                        <li>Lower with control back to starting position.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Sets:</span>
                                                                        <span class="parameter-value">4</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Reps:</span>
                                                                        <span class="parameter-value">8-10</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Rest:</span>
                                                                        <span class="parameter-value">2 min</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Weight:</span>
                                                                        <span class="parameter-value">Moderate to heavy</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Dumbbell Rows</span>
                                                                    <span class="alternative-badge">T-Bar Rows</span>
                                                                    <span class="alternative-badge">Cable Rows</span>
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

                        <!-- Legs Workouts -->
                        <div id="pre-built-legs-workouts" class="workout-category-section">
                            <!-- Legs Exercises -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Exercises</h5>
                                    <div class="card-actions">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion workout-exercises" id="legsWorkoutExercises">
                                        <!-- Exercise 1 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="legsExercise1Heading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#legsExercise1Collapse" aria-expanded="true" aria-controls="legsExercise1Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">1</span>
                                                        <div class="exercise-title">
                                                            <h6>Barbell Squat</h6>
                                                            <span class="exercise-target">Target: Quadriceps, Glutes, Hamstrings</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="legsExercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="legsExercise1Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?squat" alt="Barbell Squat" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6>Instructions:</h6>
                                                                    <ol>
                                                                        <li>Stand with feet shoulder-width apart, barbell on upper back.</li>
                                                                        <li>Initiate movement by pushing hips back and bending knees.</li>
                                                                        <li>Lower until thighs are parallel to ground.</li>
                                                                        <li>Drive through heels to return to starting position.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Sets:</span>
                                                                        <span class="parameter-value">4</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Reps:</span>
                                                                        <span class="parameter-value">8-12</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Rest:</span>
                                                                        <span class="parameter-value">3 min</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Weight:</span>
                                                                        <span class="parameter-value">Heavy</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Goblet Squat</span>
                                                                    <span class="alternative-badge">Leg Press</span>
                                                                    <span class="alternative-badge">Front Squat</span>
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

                        <!-- Arms Workouts -->
                        <div id="pre-built-arms-workouts" class="workout-category-section">
                            <!-- Arms Exercises -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Exercises</h5>
                                    <div class="card-actions">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion workout-exercises" id="armsWorkoutExercises">
                                        <!-- Exercise 1 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="armsExercise1Heading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#armsExercise1Collapse" aria-expanded="true" aria-controls="armsExercise1Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">1</span>
                                                        <div class="exercise-title">
                                                            <h6>Barbell Bicep Curls</h6>
                                                            <span class="exercise-target">Target: Biceps, Forearms</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="armsExercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="armsExercise1Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="exercise-image">
                                                                <img src="https://source.unsplash.com/random/400x300/?bicep-curl" alt="Barbell Bicep Curls" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6>Instructions:</h6>
                                                                    <ol>
                                                                        <li>Stand with feet hip-width apart, holding barbell with underhand grip.</li>
                                                                        <li>Keep elbows close to your sides throughout the movement.</li>
                                                                        <li>Curl the barbell up towards your chest.</li>
                                                                        <li>Lower with control back to starting position.</li>
                                                                    </ol>
                                                                </div>
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Sets:</span>
                                                                        <span class="parameter-value">3</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Reps:</span>
                                                                        <span class="parameter-value">10-12</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Rest:</span>
                                                                        <span class="parameter-value">90 sec</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label">Weight:</span>
                                                                        <span class="parameter-value">Moderate</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="exercise-alternatives mt-3">
                                                                <h6>Alternatives:</h6>
                                                                <div class="alternatives-list">
                                                                    <span class="alternative-badge">Dumbbell Curls</span>
                                                                    <span class="alternative-badge">Hammer Curls</span>
                                                                    <span class="alternative-badge">Cable Curls</span>
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
                    </div>
                </div>

                <!-- My Workouts Section -->
                <div class="tab-section" id="my-workouts">
                    <?php if (empty($workouts)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                <h5>No Custom Workouts Yet</h5>
                                <p style="color: var(--secondary) !important;">Create your first custom workout or add pre-built workouts to get started.</p>
                                <a href="workouts-create.php" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New Workout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($workouts as $workout): ?>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mb-4 px-2">
                                    <div class="card workout-card gradient-card h-100 border-0">
                                        <div class="card-body pb-2">
                                            <h5 class="card-title fw-semibold text-white fs-5 mb-2"><?= htmlspecialchars($workout['workout_name']) ?></h5>
                                            
                                            <p class="muted-p mb-2">
                                                <?= nl2br(htmlspecialchars($workout['workout_description'] ?: 'No description provided.')) ?>
                                            </p>

                                            <p class="mb-1 text-white">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= $workout['estimated_duration'] ?? '—' ?> mins
                                            </p>

                                            <p class="mb-0 text-white">
                                                <i class="fas fa-dumbbell me-1"></i>
                                                <?= $workout['exercise_count'] ?? 0 ?> <?= $workout['exercise_count'] == 1 ? 'exercise' : 'exercises' ?>
                                            </p>

                                        </div>

                                        <div class="card-footer bg-transparent text-end border-0 pt-1 mb-2">
                                            <a href="workouts-view.php?id=<?= $workout['workout_id'] ?>" class="btn btn-sm btn-md btn-light px-4 py-2">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mb-4">
                            <a href="workouts-create.php" class="btn btn-primary w-100 py-3 fs-6 rounded-3">
                                <i class="fas fa-plus me-2"></i> Create New Workout
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Workout Tips -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h5 class="card-title">Tips for Success</h5>
                    </div>
                    <div class="card-body">
                        <div class="workout-tips">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Focus on Form</h6>
                                    <p class="muted-p">Always prioritize proper form over lifting heavier weights. This reduces injury risk and ensures you're targeting the right muscles.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Progressive Overload</h6>
                                    <p class="muted-p">Gradually increase weight, reps, or sets as you get stronger. This is key to continued progress.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Rest and Recovery</h6>
                                    <p class="muted-p">Allow 48 hours of rest for muscle groups between workouts. Sleep and nutrition are crucial for recovery.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Warm Up Properly</h6>
                                    <p class="muted-p">Always start with 5-10 minutes of light cardio and dynamic stretching to prepare your body for exercise.</p>
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
    <script src="assets/js/workouts.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>
