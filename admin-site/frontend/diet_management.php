<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../../utils/message2.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM meal_ingredients_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}

$mealQuery = "SELECT mel_id, mel_name FROM meals_t WHERE mel_id NOT IN (SELECT mel_id FROM meal_ingredients_t)";
$mealResult = mysqli_query($connection, $mealQuery);

$ingredientQuery = "SELECT ing_id, ing_name FROM ingredients_t";
$ingredientResult = mysqli_query($connection, $ingredientQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Diet Management - YourFit Journey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/diet.css">
</head>
<body>
    <div class="container">
        <a class="back-btn" href="dashboard.php" id="backToDashboardBtn">
            <span class="material-icons" style="font-size:19px;vertical-align:-3px;">arrow_back</span>
            Back to Dashboard
        </a>
        <h2>
            Diet Management
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
                    <input type="text" id="filterInput" placeholder="Base Grams" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
                    <button id="clearFilterBtn" type="button" style="position:absolute; right:6px; top:50%; transform:translateY(-50%); background:none; border:none; color:#b3b3fd; font-size:16px; cursor:pointer; display:none;" tabindex="-1" aria-label="Clear filter">
                        <i class="material-icons">close</i>
                    </button>
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
                        <th>Meal Ingredient ID</th>
                        <th>Meal ID</th>
                        <th>Ingredient ID</th>
                        <th>Base Grams</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?= htmlspecialchars($row['mi_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['mi_id']) ?></td>
                            <td><?= htmlspecialchars($row['mel_id']) ?></td>
                            <td><?= htmlspecialchars($row['ing_id']) ?></td>
                            <td><?= htmlspecialchars($row['mi_base_grams']) ?></td>
                            <td><?= htmlspecialchars($row['mi_created_at']) ?></td>
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
            <div class="modal-title">Add New Ingredients and Meals</div>

            <form action="../backend/process_add_diet_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <div class="horizontal-bar">
                    <div class="meal-select-wrapper">
                        <label for="addMeal">Select Meal</label>
                        <select id="addMeal" name="melId" required>
                            <option value="" disabled selected>Select a meal</option>
                            <?php while ($meal = mysqli_fetch_assoc($mealResult)) : ?>
                                <option value="<?= htmlspecialchars($meal['mel_id']) ?>">
                                    <?= htmlspecialchars($meal['mel_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <button type="button" id="addIngredientRowBtn" class="add-btn-inline mb-3">
                        <span class="material-icons" style="font-size:20px;vertical-align:-4px;">add_circle</span>
                        Add Ingredient
                    </button>
                </div>

                <div id="ingredientRowsContainer" class="ingredient-container"></div>

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
            <div class="modal-title">Edit Ingredients and Meals</div>
            <div class="modal-form-grid">
                <div>
                    <label for="updateBaseGrams">Base Grams</label>
                    <input type="text" id="updateBaseGrams" maxlength="50" placeholder="Enter Base Grams" autocomplete="off"/>
                </div>
                <div>
                    <label for="updateCreatedAt">Created At</label>
                    <input type="text" id="updateCreatedAt" maxlength="25" placeholder="Enter creation date" autocomplete="off"/>
                </div>
            </div>
            <div class="modal-actions">
                <input type="submit" value="Update" id="updateSubmit">
                <button type="button" class="cancel-popup" id="updateCancel">Cancel</button>
            </div>
        </div>
    </div>
    <div class="toast" id="toast"></div>

    <?php include 'scroll_to_top.php'; ?>

    <script src="assets/js/meal_ingredient.js"></script>
    <script>
        // Handle more than 1 ingredient row addition
        let ingredientRowIndex = 0;
        const container = document.getElementById("ingredientRowsContainer");

        const ingredientOptions = `<?php
        mysqli_data_seek($ingredientResult, 0);
        while ($ing = mysqli_fetch_assoc($ingredientResult)) {
            echo '<option value="' . htmlspecialchars($ing['ing_id']) . '">' . htmlspecialchars($ing['ing_name']) . '</option>';
        }
        ?>`;

        document.getElementById("addIngredientRowBtn").addEventListener("click", () => {
            ingredientRowIndex++;
            const row = document.createElement("div");
            row.className = "ingredient-row";
            row.innerHTML = `
                <div>
                    <label for="ingredients_${ingredientRowIndex}">Ingredient ${ingredientRowIndex}</label>
                    <select name="ingId[]" id="ingredients_${ingredientRowIndex}" required>
                        <option value="" disabled selected>Select ingredient</option>
                        ${ingredientOptions}
                    </select>
                </div>
                <div>
                    <label for="grams_${ingredientRowIndex}">Base Grams</label>
                    <input type="number" name="baseGrams[]" id="grams_${ingredientRowIndex}" min="1" step="0.01" required>
                </div>
                <button type="button" class="btn removeRowBtn" aria-label="Remove ingredient row" style="align-self:end;">Remove</button>
            `;

            row.querySelector(".removeRowBtn").addEventListener("click", () => {
                row.remove();
            });

            container.appendChild(row);
        });
    </script>
</body>
</html>