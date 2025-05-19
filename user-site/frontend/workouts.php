<?php require_once '../../utils/auth.php'; ?>


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
                    <h1 class="page-title">Workouts</h1>
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

            <!-- Workout Content -->
            <div class="dashboard-content">
                <!-- Workout Options -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="workout-options">
                            <button class="btn btn-primary active">Pre-built Plans</button>
                            <button class="btn btn-outline-primary">My Workouts</button>
                            <button class="btn btn-outline-primary">Create Custom</button>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="workout-filters card-actions">
                            <select class="form-select">
                                <option selected>Experience Level</option>
                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Advanced</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Workout Categories -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="workout-category-card active">
                            <div class="workout-category-icon">
                                <i class="fas fa-child"></i>
                            </div>
                            <h4>Full Body</h4>
                            <p>Complete workout for all muscle groups</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="workout-category-card">
                            <div class="workout-category-icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <h4>Legs</h4>
                            <p>Focus on quadriceps, hamstrings, and calves</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="workout-category-card">
                            <div class="workout-category-icon">
                                <i class="fas fa-fist-raised"></i>
                            </div>
                            <h4>Chest</h4>
                            <p>Target pectoral muscles and shoulders</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="workout-category-card">
                            <div class="workout-category-icon">
                                <i class="fas fa-swimmer"></i>
                            </div>
                            <h4>Back</h4>
                            <p>Strengthen your back and improve posture</p>
                        </div>
                    </div>
                </div>

                <!-- Selected Workout Plan -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Beginner Full Body Workout Plan</h5>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Add to My Workouts
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="workout-plan-info">
                            <div class="workout-plan-detail">
                                <i class="fas fa-clock"></i>
                                <span>45-60 minutes</span>
                            </div>
                            <div class="workout-plan-detail">
                                <i class="fas fa-calendar-alt"></i>
                                <span>3 days/week</span>
                            </div>
                            <div class="workout-plan-detail">
                                <i class="fas fa-fire"></i>
                                <span>300-400 calories</span>
                            </div>
                            <div class="workout-plan-detail">
                                <i class="fas fa-signal"></i>
                                <span>Beginner</span>
                            </div>
                        </div>
                        <div class="workout-plan-description">
                            <p>This beginner-friendly full body workout is designed to help you build strength and endurance across all major muscle groups. Perfect for those new to fitness, this plan focuses on proper form and technique with appropriate rest periods to prevent overtraining.</p>
                        </div>
                    </div>
                </div>

                <!-- Workout Exercises -->
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
                        <div class="accordion workout-exercises" id="workoutExercises">
                            <!-- Exercise 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exercise1Heading">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#exercise1Collapse" aria-expanded="true" aria-controls="exercise1Collapse">
                                        <div class="exercise-header">
                                            <span class="exercise-number">1</span>
                                            <div class="exercise-title">
                                                <h6>Barbell Squat</h6>
                                                <span class="exercise-target">Target: Quadriceps, Glutes, Hamstrings</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="exercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="exercise1Heading">
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
                                                            <li>Stand with feet shoulder-width apart, barbell resting on upper back.</li>
                                                            <li>Bend knees and lower hips as if sitting in a chair, keeping chest up.</li>
                                                            <li>Lower until thighs are parallel to ground (or as low as comfortable).</li>
                                                            <li>Push through heels to return to starting position.</li>
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
                                                            <span class="parameter-value">Light to moderate</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="exercise-alternatives mt-3">
                                                    <h6>Alternatives:</h6>
                                                    <div class="alternatives-list">
                                                        <span class="alternative-badge">Bodyweight Squat</span>
                                                        <span class="alternative-badge">Dumbbell Goblet Squat</span>
                                                        <span class="alternative-badge">Leg Press Machine</span>
                                                        <span class="alternative-badge">Smith Machine Squat</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exercise 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exercise2Heading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exercise2Collapse" aria-expanded="false" aria-controls="exercise2Collapse">
                                        <div class="exercise-header">
                                            <span class="exercise-number">2</span>
                                            <div class="exercise-title">
                                                <h6>Dumbbell Bench Press</h6>
                                                <span class="exercise-target">Target: Chest, Shoulders, Triceps</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="exercise2Collapse" class="accordion-collapse collapse" aria-labelledby="exercise2Heading">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="exercise-image">
                                                    <img src="https://source.unsplash.com/random/400x300/?bench-press" alt="Dumbbell Bench Press" class="img-fluid rounded">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="exercise-details">
                                                    <div class="exercise-instructions">
                                                        <h6>Instructions:</h6>
                                                        <ol>
                                                            <li>Lie on a flat bench with a dumbbell in each hand at chest level.</li>
                                                            <li>Press the dumbbells upward until arms are extended, but not locked.</li>
                                                            <li>Lower the dumbbells back to chest level with control.</li>
                                                            <li>Repeat for the recommended repetitions.</li>
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
                                                            <span class="parameter-value">Light to moderate</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="exercise-alternatives mt-3">
                                                    <h6>Alternatives:</h6>
                                                    <div class="alternatives-list">
                                                        <span class="alternative-badge">Push-ups</span>
                                                        <span class="alternative-badge">Barbell Bench Press</span>
                                                        <span class="alternative-badge">Chest Press Machine</span>
                                                        <span class="alternative-badge">Incline Dumbbell Press</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exercise 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exercise3Heading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exercise3Collapse" aria-expanded="false" aria-controls="exercise3Collapse">
                                        <div class="exercise-header">
                                            <span class="exercise-number">3</span>
                                            <div class="exercise-title">
                                                <h6>Lat Pulldown</h6>
                                                <span class="exercise-target">Target: Back, Biceps</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="exercise3Collapse" class="accordion-collapse collapse" aria-labelledby="exercise3Heading">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="exercise-image">
                                                    <img src="https://source.unsplash.com/random/400x300/?pulldown" alt="Lat Pulldown" class="img-fluid rounded">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="exercise-details">
                                                    <div class="exercise-instructions">
                                                        <h6>Instructions:</h6>
                                                        <ol>
                                                            <li>Sit at a lat pulldown machine with thighs secured under the pads.</li>
                                                            <li>Grasp the bar with hands wider than shoulder-width apart.</li>
                                                            <li>Pull the bar down to chest level while squeezing shoulder blades together.</li>
                                                            <li>Slowly return to starting position with arms fully extended.</li>
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
                                                            <span class="parameter-value">Light to moderate</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="exercise-alternatives mt-3">
                                                    <h6>Alternatives:</h6>
                                                    <div class="alternatives-list">
                                                        <span class="alternative-badge">Pull-ups (assisted)</span>
                                                        <span class="alternative-badge">Resistance Band Pulldowns</span>
                                                        <span class="alternative-badge">Seated Cable Row</span>
                                                        <span class="alternative-badge">Dumbbell Rows</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exercise 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exercise4Heading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exercise4Collapse" aria-expanded="false" aria-controls="exercise4Collapse">
                                        <div class="exercise-header">
                                            <span class="exercise-number">4</span>
                                            <div class="exercise-title">
                                                <h6>Dumbbell Shoulder Press</h6>
                                                <span class="exercise-target">Target: Shoulders, Triceps</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="exercise4Collapse" class="accordion-collapse collapse" aria-labelledby="exercise4Heading">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="exercise-image">
                                                    <img src="https://source.unsplash.com/random/400x300/?shoulder-press" alt="Dumbbell Shoulder Press" class="img-fluid rounded">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="exercise-details">
                                                    <div class="exercise-instructions">
                                                        <h6>Instructions:</h6>
                                                        <ol>
                                                            <li>Sit on a bench with back support, holding dumbbells at shoulder height.</li>
                                                            <li>Press the dumbbells upward until arms are extended, but not locked.</li>
                                                            <li>Lower the dumbbells back to shoulder height with control.</li>
                                                            <li>Repeat for the recommended repetitions.</li>
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
                                                            <span class="parameter-value">Light to moderate</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="exercise-alternatives mt-3">
                                                    <h6>Alternatives:</h6>
                                                    <div class="alternatives-list">
                                                        <span class="alternative-badge">Barbell Shoulder Press</span>
                                                        <span class="alternative-badge">Machine Shoulder Press</span>
                                                        <span class="alternative-badge">Pike Push-ups</span>
                                                        <span class="alternative-badge">Resistance Band Shoulder Press</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exercise 5 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="exercise5Heading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exercise5Collapse" aria-expanded="false" aria-controls="exercise5Collapse">
                                        <div class="exercise-header">
                                            <span class="exercise-number">5</span>
                                            <div class="exercise-title">
                                                <h6>Plank</h6>
                                                <span class="exercise-target">Target: Core, Shoulders</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="exercise5Collapse" class="accordion-collapse collapse" aria-labelledby="exercise5Heading">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="exercise-image">
                                                    <img src="https://source.unsplash.com/random/400x300/?plank" alt="Plank" class="img-fluid rounded">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="exercise-details">
                                                    <div class="exercise-instructions">
                                                        <h6>Instructions:</h6>
                                                        <ol>
                                                            <li>Start in a push-up position, then bend your elbows 90° and rest your weight on your forearms.</li>
                                                            <li>Keep your body in a straight line from head to heels.</li>
                                                            <li>Engage your core and hold the position.</li>
                                                            <li>Breathe normally throughout the exercise.</li>
                                                        </ol>
                                                    </div>
                                                    <div class="exercise-parameters">
                                                        <div class="parameter">
                                                            <span class="parameter-label">Sets:</span>
                                                            <span class="parameter-value">3</span>
                                                        </div>
                                                        <div class="parameter">
                                                            <span class="parameter-label">Duration:</span>
                                                            <span class="parameter-value">30-60 sec</span>
                                                        </div>
                                                        <div class="parameter">
                                                            <span class="parameter-label">Rest:</span>
                                                            <span class="parameter-value">60 sec</span>
                                                        </div>
                                                        <div class="parameter">
                                                            <span class="parameter-label">Intensity:</span>
                                                            <span class="parameter-value">Moderate</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="exercise-alternatives mt-3">
                                                    <h6>Alternatives:</h6>
                                                    <div class="alternatives-list">
                                                        <span class="alternative-badge">Side Plank</span>
                                                        <span class="alternative-badge">Mountain Climbers</span>
                                                        <span class="alternative-badge">Ab Crunches</span>
                                                        <span class="alternative-badge">Dead Bug Exercise</span>
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

                <!-- Workout Tips -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Tips for Beginners</h5>
                    </div>
                    <div class="card-body">
                        <div class="workout-tips">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Focus on Form</h6>
                                    <p>Always prioritize proper form over lifting heavier weights. This reduces injury risk and ensures you're targeting the right muscles.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Progressive Overload</h6>
                                    <p>Gradually increase weight, reps, or sets as you get stronger. This is key to continued progress.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Rest and Recovery</h6>
                                    <p>Allow 48 hours of rest for muscle groups between workouts. Sleep and nutrition are crucial for recovery.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Warm Up Properly</h6>
                                    <p>Always start with 5-10 minutes of light cardio and dynamic stretching to prepare your body for exercise.</p>
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