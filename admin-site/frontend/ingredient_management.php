<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM ingredients_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ingredient Management - YourFit Journey</title>
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
            Ingredient Management
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
                    <input type="text" id="filterInput" placeholder="Ingredient Name" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
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
                        <th>Ingredient ID</th>
                        <th>Ingredient Name</th>
                        <th>Protein per 100g</th>
                        <th>Carbs per 100g</th>
                        <th>Fats per 100g</th>
                        <th>Calories per 100g</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?= htmlspecialchars($row['ing_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['ing_id']) ?></td>
                            <td><?= htmlspecialchars($row['ing_name']) ?></td>
                            <td><?= htmlspecialchars($row['ing_protein_per_100g']) ?></td>
                            <td><?= htmlspecialchars($row['ing_carbs_per_100g']) ?></td>
                            <td><?= htmlspecialchars($row['ing_fats_per_100g']) ?></td>
                            <td><?= htmlspecialchars($row['ing_calories_per_100g']) ?></td>
                            <td><?= htmlspecialchars($row['ing_created_at']) ?></td>
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
            <div class="modal-title">Add New Ingredient</div>

            <form action="../backend/process_add_ingredient_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <div class="modal-form-grid">
                    <div>
                        <label for="addName">Name</label>
                        <input type="text" name="ingredientName" id="addName" maxlength="50" placeholder="e.g. Chicken breast" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addProtein">Protein per 100g</label>
                        <input type="number" name="protein" id="addProtein" maxlength="10" placeholder="e.g. 31" min="0" step="0.01" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addCarbs">Carbs per 100g</label>
                        <input type="number" name="carbs" id="addCarbs" maxlength="10" placeholder="e.g. 15" min="0" step="0.01" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addFats">Fats per 100g</label>
                        <input type="number" name="fats" id="addFats" maxlength="10" placeholder="e.g. 3" min="0" step="0.01" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addCalories">Calories per 100g</label>
                        <input type="number" name="calories" id="addCalories" maxlength="10" placeholder="e.g. 150" min="0" step="0.01" autocomplete="off" required />
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
            <div class="modal-title">Edit Ingredient</div>

            <form action="../backend/process_update_ingredient_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <input type="hidden" name="ingredientId" id="ingredientId">
                <div class="modal-form-grid">
                    <div>
                        <label for="updateName">Name</label>
                        <input type="text" name="ingredientName" id="updateName" maxlength="50" placeholder="e.g. Chicken breast" autocomplete="off" required/>
                    </div>
                    <div>
                        <label for="updateProtein">Protein per 100g</label>
                        <input type="number" name="protein" id="updateProtein" maxlength="10" placeholder="e.g. 31" min="0" step="0.01" autocomplete="off" required/>
                    </div>
                    <div>
                        <label for="updateCarbs">Carbs per 100g</label>
                        <input type="number" name="carbs" id="updateCarbs" maxlength="10" placeholder="e.g. 15" min="0" step="0.01" autocomplete="off" required/>
                    </div>
                    <div>
                        <label for="updateFats">Fats per 100g</label>
                        <input type="number" name="fats" id="updateFats" maxlength="10" placeholder="e.g. 3" min="0" step="0.01" autocomplete="off" required/>
                    </div>
                    <div>
                        <label for="updateCalories">Calories per 100g</label>
                        <input type="number" name="calories" id="updateCalories" maxlength="10" placeholder="e.g. 150" min="0" step="0.01" autocomplete="off" required/>
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

    <script src="assets/js/ingredient_management.js"></script>

    <script>
        // Calculate Calories Automatically based on user input (protein, carbs, fats)
        document.querySelectorAll('#addProtein, #addCarbs, #addFats').forEach(input => {
            input.addEventListener('input', calculateCalories);
        });

        function calculateCalories() {
            const protein = parseFloat(document.getElementById('addProtein').value) || 0;
            const carbs = parseFloat(document.getElementById('addCarbs').value) || 0;
            const fats = parseFloat(document.getElementById('addFats').value) || 0;

            const calories = (protein * 4) + (carbs * 4) + (fats * 9);
            document.getElementById('addCalories').value = calories.toFixed(2);
        }
    </script>
</body>
</html>