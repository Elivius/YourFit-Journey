<?php
$requireRole = 'user';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../../utils/sanitize.php';
require_once '../backend/preload_exercises.php';
?>

<?php
// Group the exercises by category
$groupedExercises = [];
foreach ($exercises as $exercise) {
    $category = $exercise['exe_category'];
    $groupedExercises[$category][] = $exercise;
}

// Detect if user is creating or editing workouts
$isEditing = false;
$workout_id = null;

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $workout_id = sanitizeInt($_GET['edit']);
    $isEditing = true;
    require_once '../backend/preload_workouts.php';
}
?>

<!-- Prelaod user exercise relate dot the workout_id (Edit feature) -->
<?php if ($isEditing): ?>
<script>
    const preloadedExercises = <?= json_encode($exercises, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    localStorage.setItem("selectedExercises", JSON.stringify(
        preloadedExercises.map((ex) => ({
            id: ex.exe_id ?? "", 
            name: ex.exe_name,
            muscles: ex.exe_targeted_muscle,
            sets: ex.we_sets,
            reps: ex.we_reps,
            rest: ex.we_rest,
            weight: ex.we_weight,
        }))
    ));
</script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEditing ? 'Edit Workout' : 'Create Workout' ?> - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
        <?php require_once '../../utils/message.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="btn-toggle-sidebar" id="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title"><?= $isEditing ? 'Edit' : 'Create New' ?> Workout</h1>
                </div>
                <div class="header-right">
                    <div class="theme-switch-container me-1">
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
                            <!-- If user is editing, need workout_id for update purpose -->
                            <?php if ($isEditing): ?>
                                <input type="hidden" name="workout_id" value="<?= $workout_id ?>">
                            <?php endif; ?>
                            <!-- Workout Basic Info -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Workout Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="workout_name" class="form-label">Workout Name *</label>
                                            <input type="text" class="form-control" id="workout_name"
                                                name="workout_name" placeholder="Chest day" required
                                                <?php if ($isEditing): ?>
                                                    value="<?= htmlspecialchars($workout_name) ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="estimated_duration" class="form-label">Estimated Duration (minutes)</label>
                                            <input type="number" class="form-control" id="estimated_duration" 
                                                name="estimated_duration" min="0" max="180" placeholder="Optional"
                                                <?php if ($isEditing): ?>
                                                    value="<?= htmlspecialchars($estimated_duration) ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="workout_description" class="form-label">Description</label>
                                            <textarea class="form-control" id="workout_description" 
                                                name="workout_description" rows="3" placeholder="Describe your workout... (Optional)"><?= $isEditing ? htmlspecialchars($workout_description) : '' ?></textarea>
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
                                        <div class="col-md-12 d-flex">
                                            <div class="position-relative" style="max-width: 180px; width: 100%;">
                                                <select class="form-control pe-5" id="category-filter">
                                                    <option value="">All Categories</option>
                                                    <option value="Arms">Arms</option>
                                                    <option value="Chest">Chest</option>
                                                    <option value="Back">Back</option>
                                                    <option value="Legs">Legs</option>
                                                </select>
                                                <i class="bi bi-chevron-down position-absolute select-chevron" id="select-chevron"
                                                style="top: 50%; right: 15px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mx-2" id="exercise-results">
                                        <!-- Display exercises grouped by category -->
                                        <?php foreach ($groupedExercises as $category => $exercises): ?>
                                            <div class="exercise-category-section" data-category="<?= htmlspecialchars($category); ?>">
                                                <div class="sticky-category-header">
                                                    <h5 class="mb-3"><?= htmlspecialchars(ucfirst($category)); ?>  <hr></h5>
                                                </div>

                                                <?php if (empty($exercises)): ?>
                                                    <p class="muted-p">No exercises found in this category.</p>
                                                <?php endif; ?>

                                                <div class="accordion workout-exercises mb-4" id="accordion<?= htmlspecialchars($category) ?>">
                                                    <?php foreach ($exercises as $index => $exercise): ?>
                                                        <?php 
                                                            $collapseId = 'exerciseCollapse' . $index;
                                                            $headingId = 'exerciseHeading' . $index;
                                                        ?>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="<?= $headingId ?>">
                                                                <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                                        <div class="exercise-header me-2">
                                                                            <span class="exercise-number"><?= $index + 1 ?></span>
                                                                            <div class="exercise-title">
                                                                                <h6 class="mb-2"><?= htmlspecialchars($exercise['exe_name']) ?></h6>
                                                                                <p class="mb-2 muted-p small">Target muscles:</p>

                                                                                <div class="d-flex flex-wrap gap-2 mb-0">
                                                                                    <?php
                                                                                        $muscles = explode(',', $exercise['exe_targeted_muscle']);
                                                                                        foreach ($muscles as $muscle):                                                                        
                                                                                    ?>
                                                                                        <span class="workout-pill"><?= htmlspecialchars(trim($muscle)); ?></span>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>                                                  
                                                                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="<?= $headingId ?>">
                                                                <div class="accordion-body p-3">
                                                                    <div class="row g-3 align-items-stretch">
                                                                        <div class="col-md-4">
                                                                            <div class="exercise-image">
                                                                            <img src="<?= htmlspecialchars($exercise['exe_image_url']); ?>"
                                                                                alt="<?= htmlspecialchars($exercise['exe_name']) ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 d-flex flex-column justify-content-between">
                                                                            <div class="exercise-details mb-0">
                                                                            <h6 class="muted-p">Instructions:</h6>
                                                                            <?php
                                                                                $rawInstructions = $exercise['exe_instructions'] ?? '';
                                                                                $steps = preg_split('/(?=\d+\.\s)/', $rawInstructions);
                                                                            ?>
                                                                            <?php if (!empty($steps)): ?>
                                                                                <?php foreach ($steps as $step): ?>
                                                                                <?php if (trim($step)): ?>
                                                                                    <p class="small mb-2"><?= htmlspecialchars(trim($step)) ?></p>
                                                                                <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php else: ?>
                                                                                <p class="text-muted small mb-0 fst-italic">No instructions provided.</p>
                                                                            <?php endif; ?>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <button type="button" class="btn btn-sm btn-primary w-100 add-exercise-btn"
                                                                                        data-id="<?= htmlspecialchars($exercise['exe_id']); ?>"
                                                                                        data-name="<?= htmlspecialchars($exercise['exe_name']); ?>"
                                                                                        data-target-muscles="<?= htmlspecialchars($exercise['exe_targeted_muscle']); ?>">
                                                                                    <i class="fas fa-plus me-1"></i> Add
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
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
                                            <!-- <div class="accordion workout-exercises" id="selectedExercises"></div> -->
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
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/confirmation-modal.js"></script>
    <script src="assets/js/add-exercise-temp.js"></script>
    <script src="assets/js/workouts.js"></script>
</body>
</html>
