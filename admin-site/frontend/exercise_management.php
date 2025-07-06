<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM exercises_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise Management - YourFit Journey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/management.css">
</head>
<body>
    <div class="container">
        <a class="back-btn" href="dashboard.php" id="backToDashboardBtn">
            <span class="material-icons" style="font-size:19px;vertical-align:-3px;">arrow_back</span>
            Back to Dashboard
        </a>
        <h2>
            Exercise Management
        </h2>
        <div class="toolbar">
            <div class="toolbar-actions-left">
                <button type="button" id="addBtn">
                    <span class="material-icons" style="font-size:20px;vertical-align:-4px;">add_circle</span>
                    Add
                </button>
                <!-- Filter and Clear Function -->
                <span style="position:relative; display:inline-block; margin-left:10px;">
                    <i class="material-icons" style="position:absolute; left:10px; top:38%; transform:translateY(-50%); color:#b3b3fd; font-size:18px; pointer-events:none;">search</i>
                    <input type="text" id="filterInput" placeholder="Workout Name or Muscle" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
                    <button id="clearFilterBtn" style="display:none;margin-left:8px;padding:6px 10px;">Clear</button>
                </span>
            </div>
            <div class="toolbar-actions-right">
                <button type="button" id="editBtn" class="edit" disabled>
                    <span class="material-icons" style="font-size:20px;vertical-align:-4px;">edit</span>
                    Edit
                </button>
                <button type="button" id="deleteBtn" class="delete" disabled>
                    <span class="material-icons" style="font-size:20px;vertical-align:-4px;">delete</span>
                    Delete
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" aria-label="Select all"/></th>
                        <th>Exercise ID</th>
                        <th>Exercise Name</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Targeted Muscle</th>
                        <th style="width:1000px;">Instructions</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?= htmlspecialchars($row['exe_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['exe_id']) ?></td>
                            <td><?= htmlspecialchars($row['exe_name']) ?></td>
                            <td>
                                <?php if (!empty($row['exe_image_url'])) : ?>
                                    <img src="<?= htmlspecialchars($row['exe_image_url']) ?>" alt="Exercise Image" width="180" height="120" style="border-radius: 8px;">
                                <?php else : ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['exe_category']) ?></td>
                            <td>
                                <?php
                                $muscles = explode(',', $row['exe_targeted_muscle']);
                                foreach ($muscles as $muscle) {
                                    echo '<div style="margin-bottom: 9px;">• ' . htmlspecialchars(trim($muscle)) . '</div>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $instructions = preg_split('/(?=\d+\.\s)/', $row['exe_instructions'], -1, PREG_SPLIT_NO_EMPTY);
                                foreach ($instructions as $step) {
                                    echo '<div style="margin-bottom: 9px;">' . htmlspecialchars(trim($step)) . '</div>';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['exe_created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal-backdrop" id="addBackdrop"></div>

    <div class="modal-dialog" id="addModal">
        <div class="modal-content">
            <button class="modal-close" type="button" id="addCloseBtn" aria-label="Close">&times;</button>
            <div class="modal-title">Add New Exercise</div>
            
            <form action="../backend/process_add_exercise_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <div class="modal-form-grid">
                    <div>
                        <label for="addExerciseName">Exercise Name</label>
                        <input type="text" name="exerciseName" id="addExerciseName" maxlength="50" placeholder="e.g. Pushups" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addImageUrl">Image</label>
                        <input type="text" name="imageUrl" id="addImageUrl" maxlength="2048" placeholder="e.g. https://raw.githubusercontent.com/pushups.jpg" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addCategory">Category</label>
                        <select size="1" name="category" id="addCategory" required>
                            <option value="" disabled selected>Select a Category</option>
                            <option value="Arms">Arms</option>
                            <option value="Chest">Chest</option>
                            <option value="Back">Back</option>
                            <option value="Legs">Legs</option>
                        </select>
                    </div>
                    <div>
                        <label for="addTargetedMuscle">Targeted Muscle</label>
                        <input type="text" name="targetMuscle" id="addTargetedMuscle" maxlength="60" placeholder="e.g. Chest, Biceps, Shoulder" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addInstructions">Instructions</label>
                        <textarea name="instructions" id="addInstructions" maxlength="500" placeholder="" autocomplete="off" required style="height: 100px; resize: vertical; max-height: 200px; overflow: auto;"></textarea>
                    </div>
                </div>    
                <div class="modal-actions">
                    <input type="submit" value="Add" id="addSubmit">
                    <button type="button" class="cancel-popup" id="addCancel">Cancel</button>
                </div>
            </form>
        </div>
    </div> 

    <!-- Edit Modal -->
    <div class="modal-backdrop" id="updateBackdrop"></div>

    <div class="modal-dialog" id="updateModal">
        <div class="modal-content">
            <button class="modal-close" type="button" id="updateCloseBtn" aria-label="Close">&times;</button>
            <div class="modal-title">Edit Exercise</div>

            <form action="../backend/process_update_exercise_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <input type="hidden" name="exerciseId" id="updateExerciseId">
                <div class="modal-form-grid">
                    <div>
                        <label for="updateExerciseName">Exercise Name</label>
                        <input type="text" name="exerciseName" id="updateExerciseName" maxlength="50" placeholder="e.g. Pushups" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateImageUrl">Image</label>
                        <input type="text" name="imageUrl" id="updateImageUrl" maxlength="2048" placeholder="e.g. https://raw.githubusercontent.com/pushups.jpg" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateCategory">Category</label>
                        <select size="1" name="category" id="updateCategory" required>
                            <option value="" disabled selected>Select a Category</option>
                            <option value="Arms">Arms</option>
                            <option value="Chest">Chest</option>
                            <option value="Back">Back</option>
                            <option value="Legs">Legs</option>
                        </select>
                    </div>
                    <div>
                        <label for="updateTargetedMuscle">Targeted Muscle</label>
                        <input type="text" name="targetMuscle" id="updateTargetedMuscle" maxlength="60" placeholder="e.g. Chest, Biceps, Shoulder" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateInstructions">Instructions</label>
                        <textarea name="instructions" id="updateInstructions" maxlength="500" placeholder="" autocomplete="off" required style="height: 100px; resize: vertical; max-height: 200px; overflow: auto;"></textarea>
                    </div>
                </div>    
                <div class="modal-actions">
                    <input type="submit" value="Update" id="updateSubmit">
                    <button type="button" class="cancel-popup" id="updateCancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div class="toast" id="toast"></div>
    
    <?php include '../../utils/message2.php'; ?>

    <script src="assets/js/exercise_management.js"></script>
    <!-- Placeholder Script for Instructions -->
    <script>
        document.getElementById("addInstructions").placeholder = "e.g. \n1. Sit on the bench\n2. Grab the bar";
        document.getElementById("updateInstructions").placeholder = "e.g. \n1. Sit on the bench\n2. Grab the bar";
    </script>
</body>
</html>