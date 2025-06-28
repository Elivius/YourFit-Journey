<?php
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../../utils/message2.php';
require_once '../backend/preload_prebuilt_workouts.php';
require_once '../backend/preload_all_workouts.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
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
                                    <h4>Chest</h4>
                                    <p>Target pectoral muscles and shoulders</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="back">
                                    <h4>Back</h4>
                                    <p>Strengthen your back and improve posture</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="legs">
                                    <h4>Legs</h4>
                                    <p>Focus on quadriceps, hamstrings, and calves</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="workout-category-card" data-category="arms">
                                    <h4>Arms</h4>
                                    <p>Target biceps, triceps, and shoulders</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workout Category Sections -->
                    <div class="workout-category-sections">
                        <!-- Chest Workouts -->
                        <?php foreach (['chest', 'back', 'arms', 'legs'] as $category): ?>
                            <?php 
                                $data = $prebuiltWorkouts[$category] ?? null;
                                $isActive = ($category === 'chest');
                                if ($data && !empty($data['exercises'])):
                                    $exercises = $data['exercises'];
                            ?>
                            <div id="pre-built-<?= $category ?>-workouts" class="workout-category-section <?= $isActive ? 'active' : '' ?>">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title mb-2"><?= htmlspecialchars($data['name']) ?></h5>
                                            <p class="muted-p mb-0"><?= htmlspecialchars($data['description']) ?></p>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion workout-exercises" id="accordion-<?= $category ?>">
                                            <?php foreach ($exercises as $index => $ex): ?>
                                                <!-- Your existing accordion code for exercises -->
                                                <?php 
                                                    $collapseId = "exerciseCollapse{$category}{$index}";
                                                    $headingId = "exerciseHeading{$category}{$index}";
                                                ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="<?= $headingId ?>">
                                                        <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                                                            <div class="exercise-header">
                                                                <span class="exercise-number"><?= $index + 1 ?></span>
                                                                <div class="exercise-title">
                                                                    <h6 class="mb-2"><?= htmlspecialchars($ex['exercise_name']) ?></h6>
                                                                    <p class="mb-2 muted-p small">Target muscles:</p>
                                                                    <div class="d-flex flex-wrap gap-2 mb-0">
                                                                        <?php foreach (explode(',', $ex['targeted_muscle']) as $muscle): ?>
                                                                            <span class="workout-pill"><?= htmlspecialchars(trim($muscle)) ?></span>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="<?= $headingId ?>">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="exercise-image">
                                                                        <img src="<?= htmlspecialchars($ex['image_url']) ?>" alt="<?= htmlspecialchars($ex['exercise_name']) ?>" class="img-fluid rounded">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="exercise-details">
                                                                        <h6 class="muted-p">Instructions:</h6>
                                                                        <?php
                                                                            $steps = preg_split('/(?=\d+\.\s)/', $ex['instructions'] ?? '');
                                                                        ?>
                                                                        <?php if (!empty($steps)): ?>
                                                                            <?php foreach ($steps as $step): ?>
                                                                                <?php if (trim($step)): ?>
                                                                                    <p class="small mb-2"><?= htmlspecialchars(trim($step)) ?></p>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <p class="text-muted small fst-italic">No instructions provided.</p>
                                                                        <?php endif; ?>

                                                                        <div class="exercise-parameters mt-3">
                                                                            <div class="parameter">
                                                                                <span class="parameter-label muted-p">Sets:</span>
                                                                                <span class="workout-pill sets"><strong><?= $ex['sets'] ?></strong></span>
                                                                            </div>
                                                                            <div class="parameter">
                                                                                <span class="parameter-label muted-p">Reps:</span>
                                                                                <span class="workout-pill exercise"><strong><?= $ex['reps'] ?></strong></span>
                                                                            </div>
                                                                            <div class="parameter">
                                                                                <span class="parameter-label muted-p">Rest:</span>
                                                                                <span class="workout-pill time"><strong><?= $ex['rest'] ?></strong> secs</span>
                                                                            </div>
                                                                            <div class="parameter">
                                                                                <span class="parameter-label muted-p">Weight:</span>
                                                                                <span class="workout-pill weight"><strong><?= !empty($ex['weight']) ? $ex['weight'] : '-' ?></strong></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
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
                                    <div class="card workout-card gradient-card h-100 d-flex flex-column border-0">
                                        <div class="card-header d-flex justify-content-between align-items-center pb-2 pt-2">
                                            <div class="flex-grow-1" style="min-width: 0;">
                                                <h5 class="card-title mb-0 text-truncate" title="<?= htmlspecialchars($workout['workout_name']) ?>">
                                                    <?= htmlspecialchars($workout['workout_name']) ?>
                                                </h5>
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <a href="workouts-create.php?edit=<?= $workout['workout_id'] ?>" class="btn btn-sm btn-icon">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form action="../backend/process_delete_workouts.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this workout?');" class="d-inline">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                                                    <input type="hidden" name="workout_id" value="<?= $workout['workout_id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-icon">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center pt-2 pb-2">
                                            <p class="muted-p mb-2">
                                                <?= nl2br(htmlspecialchars($workout['workout_description'] ?: 'No description provided.')) ?>
                                            </p>

                                            <div class="pill-row d-flex flex-wrap justify-content-center gap-2">
                                                <p class="workout-pill time mb-0">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <strong><?= $workout['estimated_duration'] ?? '—' ?></strong> mins
                                                </p>
                                                <p class="workout-pill exercise mb-0">
                                                    <i class="fas fa-dumbbell me-1"></i>
                                                    <strong><?= $workout['exercise_count'] ?? 0 ?></strong> <?= $workout['exercise_count'] == 1 ? 'exercise' : 'exercises' ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="card-footer bg-transparent text-end border-0 pt-1 mb-2 px-4">
                                            <a href="workouts-view.php?id=<?= $workout['workout_id'] ?>" class="btn btn-sm btn-md custom-view-btn px-4 py-2">View</a>
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
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/workouts.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>
