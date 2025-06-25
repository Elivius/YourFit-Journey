<?php
require_once '../../utils/auth.php';
require_once '../backend/preload_workouts.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($workout_name) ?> - YourFit Journey</title>
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

        <!-- Top Navigation -->
        <main class="main-content">
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

            <div class="dashboard-content">
                <a href="workouts.php?section=my-workouts" class="btn btn-sm btn-outline-primary btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
                
                <div class="row">
                    <div>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-start flex-wrap">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-3"><?= htmlspecialchars($workout_name) ?></h5>
                                    <p class="mb-3 muted-p"><?= htmlspecialchars($workout_description) ?></p>

                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <span class="workout-pill time fs-6">
                                            <i class="fas fa-clock me-1"></i>
                                            <strong><?= htmlspecialchars($estimated_duration) ?></strong> mins
                                        </span>
                                        <span class="workout-pill exercise fs-6">
                                            <i class="fas fa-dumbbell me-1"></i>
                                            <strong><?= count($exercises) ?></strong> exercises
                                        </span>
                                    </div>
                                </div>

                                <div class="card-actions mt-2 mt-sm-0">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="accordion workout-exercises" id="workoutExercisesAccordion">
                                    <?php foreach ($exercises as $index => $ex): ?>
                                        <?php 
                                            $collapseId = 'exerciseCollapse' . $index;
                                            $headingId = 'exerciseHeading' . $index;
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
                                                                <?php
                                                                    $muscles = explode(',', $ex['targeted_muscle']);
                                                                    foreach ($muscles as $muscle):                                                                        
                                                                ?>
                                                                    <span class="workout-pill"><?= htmlspecialchars(trim($muscle)); ?></span>
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
                                                                <img src="https://source.unsplash.com/random/400x300/?fitness,exercise,<?= urlencode($ex['exercise_name']) ?>" alt="<?= htmlspecialchars($ex['exercise_name']) ?>" class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="exercise-details">
                                                                <div class="exercise-instructions">
                                                                    <h6 class="muted-p">Instructions:</h6>
                                                                    <?php
                                                                        $rawInstructions = $ex['instructions'] ?? '';
                                                                        $steps = preg_split('/(?=\d+\.\s)/', $rawInstructions); // split while keeping numbers
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
                                                                <div class="exercise-parameters">
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Sets:</span>
                                                                        <span class="workout-pill sets" style="font-size: 14px;"><strong><?= $ex['sets'] ?></strong></span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Reps:</span>
                                                                        <span class="workout-pill exercise" style="font-size: 14px;"><strong><?= $ex['reps'] ?></strong></span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Rest:</span>
                                                                        <span class="workout-pill time" style="font-size: 14px;"><strong><?= $ex['rest'] ?></strong> secs</span>
                                                                    </div>
                                                                    <div class="parameter">
                                                                        <span class="parameter-label muted-p">Weight:</span>
                                                                        <span class="workout-pill weight" style="font-size: 14px;">
                                                                            <strong><?= !empty($ex['weight']) ? $ex['weight'] . ' kg' : '-' ?></strong>
                                                                        </span>
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
                </div>
            </div>
        </main>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/workouts.js"></script>
    <script src="assets/js/sidebar.js"></script>
</body>
</html>
