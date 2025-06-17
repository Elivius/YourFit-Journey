<?php
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../backend/preload_exercises.php';
?>

<?php
// Group the exercises by category
$groupedExercises = [];
foreach ($exercises as $exercise) {
    $category = $exercise['category'];
    $groupedExercises[$category][] = $exercise;
}
?>


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
        <?php require_once '../../utils/message.php'; ?>

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
                    <div class="header-right">
                        <div class="theme-switch-container">
                            <div class="theme-switch">
                                <input type="checkbox" id="theme-toggle" class="theme-switch-input">
                                <label for="theme-toggle" class="theme-switch-label">
                                    <span class="theme-switch-slider">
                                        <span class="switch-handle sun-shape"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>                
                </div>
            </header>
            
            <!-- Workout Content -->
            <div class="dashboard-content">
                <a href="workouts.php?section=my-workouts" class="btn btn-sm btn-outline-primary btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
                <div class="row">
                    <div>
                        <form id="saveWorkoutForm" action="../backend/process_save_workouts.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
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
                                            <label for="estimated_duration" class="form-label">Estimated Duration (minutes)</label>
                                            <input type="number" class="form-control" id="estimated_duration" name="estimated_duration" min="10" max="180" placeholder="Optional">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="workout_description" class="form-label">Description</label>
                                            <textarea class="form-control" id="workout_description" name="workout_description" rows="3" placeholder="Describe your workout... (Optional)"></textarea>
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
                                    
                                    <div id="exercise-results">
                                        <!-- Display exercises grouped by category -->
                                        <?php foreach ($groupedExercises as $category => $exercises): ?>
                                            <div class="sticky-category-header">
                                                <h5 class="mb-3"><?= htmlspecialchars(ucfirst($category)); ?>  <hr></h5>
                                            </div>

                                            <?php if (empty($exercises)): ?>
                                                <p class="muted-p">No exercises found in this category.</p>
                                            <?php endif; ?>

                                            <?php foreach ($exercises as $exercise): ?>
                                                <div class="card mb-3 custom-hover-card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div style="max-width: 800px; word-wrap: break-word;">
                                                                <!-- Added spacing below the exercise name -->
                                                                <h6 class="mb-3"><?= htmlspecialchars($exercise['exercise_name']); ?></h6>
                                                                
                                                                <!-- More spacing below the label -->
                                                                <p class="mb-2 muted-p small">Target muscles:</p>
                                                                
                                                                <!-- More spacing between badges and button -->
                                                                <div class="d-flex flex-wrap gap-2 mb-3">
                                                                    <?php 
                                                                        $muscles = explode(',', $exercise['targeted_muscle']); 
                                                                        foreach ($muscles as $muscle): 
                                                                    ?>
                                                                        <span class="alternative-badge"><?= htmlspecialchars(trim($muscle)); ?></span>
                                                                    <?php endforeach; ?>
                                                                </div>

                                                                <!-- Exercise instructions -->
                                                                <p class="mb-2 muted-p small">Instructions:</p>

                                                                <?php
                                                                $rawInstructions = $exercise['instructions'] ?? '';
                                                                $steps = preg_split('/(?=\d+\.\s)/', $rawInstructions); // split while keeping numbers
                                                                ?>

                                                                <?php if (!empty($steps)): ?>
                                                                    <?php foreach ($steps as $step): ?>
                                                                        <?php if (trim($step)): ?>
                                                                            <p class="small mb-1"><?= htmlspecialchars(trim($step)) ?></p>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <p class="text-muted small mb-0 fst-italic">No instructions provided.</p>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <div>
                                                                <button type="button" class="btn btn-sm btn-primary add-exercise-btn"
                                                                data-id="<?= htmlspecialchars($exercise['exercise_id']); ?>"
                                                                data-name="<?= htmlspecialchars($exercise['exercise_name']); ?>"
                                                                data-target-muscles="<?= htmlspecialchars($exercise['targeted_muscle']); ?>">
                                                                    <i class="fas fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
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
                                        <!-- Place for JS to temporary display user selected exercises -->
                                        <div class="accordion workout-exercises" id="selectedExercises">
                                            <p id="no-exercises-msg" class="text-muted">No exercises added yet.</p>
                                            <div class="accordion workout-exercises" id="selectedExercises"></div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <div class="form-message" id="myWorkoutsFormMessage"></div>
                                        <button type="button" class="btn btn-danger" id="remove-all-btn">
                                            <i class="fas fa-trash-alt"></i> Remove All
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Save Workout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Workout Tips -->
                        <div class="card mt-5">
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
                                            <p class="muted-p">Include exercises that target different muscle groups for a well-rounded workout.</p>
                                        </div>
                                    </div>
                                    <div class="tip-item">
                                        <div class="tip-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="tip-content">
                                            <h6>Rest Periods</h6>
                                            <p class="muted-p">Adjust rest periods based on your goals - shorter for endurance, longer for strength.</p>
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
    
    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/confirmation-modal.js"></script>
    <script src="assets/js/add-exercise-temp.js"></script>
</body>
</html>
