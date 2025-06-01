<?php require_once '../../utils/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Workout - YourFit Journey</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/my-workouts.css">
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
                    <h1 class="page-title">Create New Workout</h1>
                </div>
                <div class="header-right">
                    <button id="theme-toggle" class="btn btn-icon">
                        <i class="fas fa-moon"></i>
                    </button>                    
                </div>
            </header>
            
            <!-- Workout Content -->
            <div class="dashboard-content">
                <a href="workouts.php?section=my-workouts" class="btn btn-sm btn-outline-primary btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Workout Basic Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Workout Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="workout_name" class="form-label">Workout Name *</label>
                                        <input type="text" class="form-control" id="workout_name" name="workout_name" placeholder="Chest day" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="estimated_duration" class="form-label">Estimated Duration (minutes) *</label>
                                        <input type="number" class="form-control" id="estimated_duration" name="estimated_duration" min="10" max="180" value="60">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="workout_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="workout_description" name="workout_description" rows="3" placeholder="Describe your workout..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exercise Search -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Find Exercises</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <div class="search-box">
                                            <input type="text" class="form-control" id="exercise-search" placeholder="Search exercises...">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="category-filter">
                                            <option value="">All Categories</option>
                                            <option value="chest">Chest</option>
                                            <option value="back">Back</option>
                                            <option value="legs">Legs</option>
                                            <option value="arms">Arms</option>
                                            <option value="shoulders">Shoulders</option>
                                            <option value="core">Core</option>
                                            <option value="cardio">Cardio</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Exercise Results -->
                                <div id="exercise-results">
                                    <!-- Sample Exercise Card -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Barbell Bench Press</h6>
                                                    <p class="mb-1 text-muted">Chest, Shoulders, Triceps</p>
                                                    <div class="d-flex gap-2">
                                                        <span class="alternative-badge">chest</span>
                                                        <span class="alternative-badge">intermediate</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Push-ups</h6>
                                                    <p class="mb-1 text-muted">Chest, Shoulders, Triceps</p>
                                                    <div class="d-flex gap-2">
                                                        <span class="alternative-badge">chest</span>
                                                        <span class="alternative-badge">beginner</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Exercises -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Selected Exercises</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="selected-exercises">
                                    <!-- Sample Selected Exercise -->
                                    <div class="accordion workout-exercises" id="selectedExercises">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="exercise1Heading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#exercise1Collapse" aria-expanded="true" aria-controls="exercise1Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">1</span>
                                                        <div class="exercise-title">
                                                            <h6>Barbell Bench Press</h6>
                                                            <span class="exercise-target">Target: Chest, Shoulders, Triceps</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="exercise1Collapse" class="accordion-collapse collapse show" aria-labelledby="exercise1Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="exercise-parameters">
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Sets:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="number" class="form-control form-control-sm" value="3" min="1">
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Reps:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="text" class="form-control form-control-sm" value="10-12">
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Rest:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="number" class="form-control form-control-sm" value="60" min="0"> sec
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Weight:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="text" class="form-control form-control-sm" placeholder="Optional">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label class="form-label">Notes:</label>
                                                                <textarea class="form-control" rows="2" placeholder="Add notes for this exercise..."></textarea>
                                                            </div>
                                                            <div class="mt-3 text-end">
                                                                <button class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="exercise2Heading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exercise2Collapse" aria-expanded="false" aria-controls="exercise2Collapse">
                                                    <div class="exercise-header">
                                                        <span class="exercise-number">2</span>
                                                        <div class="exercise-title">
                                                            <h6>Push-ups</h6>
                                                            <span class="exercise-target">Target: Chest, Shoulders, Triceps</span>
                                                        </div>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                </button>
                                            </h2>
                                            <div id="exercise2Collapse" class="accordion-collapse collapse" aria-labelledby="exercise2Heading">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="exercise-parameters">
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Sets:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="number" class="form-control form-control-sm" value="3" min="1">
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Reps:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="text" class="form-control form-control-sm" value="15">
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Rest:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="number" class="form-control form-control-sm" value="45" min="0"> sec
                                                                    </span>
                                                                </div>
                                                                <div class="parameter">
                                                                    <span class="parameter-label">Weight:</span>
                                                                    <span class="parameter-value">
                                                                        <input type="text" class="form-control form-control-sm" placeholder="Optional">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label class="form-label">Notes:</label>
                                                                <textarea class="form-control" rows="2" placeholder="Add notes for this exercise..."></textarea>
                                                            </div>
                                                            <div class="mt-3 text-end">
                                                                <button class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Remove
                                                                </button>
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

                    <div class="col-lg-4">
                        <!-- Workout Preview -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Workout Preview</h5>
                            </div>
                            <div class="card-body">
                                <h6 id="preview-name">Upper Body Strength</h6>
                                <div class="workout-plan-info">
                                    <div class="workout-plan-detail">
                                        <i class="fas fa-tag"></i>
                                        <span id="preview-category">Chest</span>
                                    </div>
                                    <div class="workout-plan-detail">
                                        <i class="fas fa-signal"></i>
                                        <span id="preview-difficulty">Intermediate</span>
                                    </div>
                                    <div class="workout-plan-detail">
                                        <i class="fas fa-clock"></i>
                                        <span id="preview-duration">45 minutes</span>
                                    </div>
                                    <div class="workout-plan-detail">
                                        <i class="fas fa-dumbbell"></i>
                                        <span id="preview-exercise-count">2 exercises</span>
                                    </div>
                                </div>
                                <div class="workout-plan-description">
                                    <p id="preview-description">A comprehensive upper body workout focusing on chest, shoulders, and triceps.</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Workout
                                    </button>
                                    <a href="workouts.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Add Exercises -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Quick Add</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary text-start">
                                        <i class="fas fa-plus"></i> Push-ups
                                    </button>
                                    <button type="button" class="btn btn-outline-primary text-start">
                                        <i class="fas fa-plus"></i> Squats
                                    </button>
                                    <button type="button" class="btn btn-outline-primary text-start">
                                        <i class="fas fa-plus"></i> Plank
                                    </button>
                                    <button type="button" class="btn btn-outline-primary text-start">
                                        <i class="fas fa-plus"></i> Lunges
                                    </button>
                                    <button type="button" class="btn btn-outline-primary text-start">
                                        <i class="fas fa-plus"></i> Burpees
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Workout Tips -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Tips</h5>
                            </div>
                            <div class="card-body">
                                <div class="workout-tips">
                                    <div class="tip-item">
                                        <div class="tip-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="tip-content">
                                            <h6>Balance Your Workout</h6>
                                            <p>Include exercises that target different muscle groups for a well-rounded workout.</p>
                                        </div>
                                    </div>
                                    <div class="tip-item">
                                        <div class="tip-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="tip-content">
                                            <h6>Rest Periods</h6>
                                            <p>Adjust rest periods based on your goals - shorter for endurance, longer for strength.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Exercise Details Modal -->
    <div class="modal fade" id="exerciseModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Exercise Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="exercise-image">
                                <img src="https://source.unsplash.com/random/400x300/?bench-press" alt="Exercise" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6>Barbell Bench Press</h6>
                            <p><strong>Category:</strong> Chest</p>
                            <p><strong>Muscle Groups:</strong> Chest, Shoulders, Triceps</p>
                            <p><strong>Equipment:</strong> Barbell, Bench</p>
                            <p><strong>Difficulty:</strong> Intermediate</p>
                            
                            <div class="mt-3">
                                <h6>Instructions:</h6>
                                <ol>
                                    <li>Lie on a flat bench with feet firmly on the ground.</li>
                                    <li>Grip the barbell slightly wider than shoulder-width.</li>
                                    <li>Lower the bar to your chest with control.</li>
                                    <li>Press the bar back up to starting position.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add to Workout</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>
