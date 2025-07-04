<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
require_once '../../utils/message2.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM meals_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meal Management - YourFit Journey</title>
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
            Meal Management
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
                    <input type="text" id="filterInput" placeholder="Name" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
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
                        <th>Meal ID</th>
                        <th>Meal Name</th>
                        <th>Estimated Preparation Minutes</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?= htmlspecialchars($row['mel_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['mel_id']) ?></td>
                            <td><?= htmlspecialchars($row['mel_name']) ?></td>
                            <td><?= htmlspecialchars($row['mel_estimated_preparation_min']) ?></td>
                            <td>
                                <?php if (!empty($row['mel_image_url'])) : ?>
                                    <img src="<?= htmlspecialchars($row['mel_image_url']) ?>" alt="Meal Image" width="180" height="120" style="border-radius: 8px;">
                                <?php else : ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($row['mel_category']) ?></td>
                            <td><?= htmlspecialchars($row['mel_created_at']) ?></td>
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
            <div class="modal-title">Add New Meal</div>

            <form action="../backend/process_add_meal_management.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <div class="modal-form-grid">
                    <div>
                        <label for="addMealName">Meal Name</label>
                        <input type="text" name="mealName" id="addMealName" maxlength="50" placeholder="Enter meal name" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addEstimatedPrepMinutes">Estimated Preparation Minutes</label>
                        <input type="number" name="estimatedPrepMinutes" id="addEstimatedPrepMinutes" min="1" max="1440" placeholder="Enter preparation minutes" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addImageUrl">Image</label>
                        <input type="text" name="imageUrl" id="addImageUrl" maxlength="2048" placeholder="Enter image url" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addCategory">Category</label>
                        <select size="1" name="category" id="addCategory" required>
                            <option value="" disabled selected>Select a Category</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                        </select>
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
            <div class="modal-title">Edit Meal</div>
            <div class="modal-form-grid">
                <div>
                    <label for="updateMealName">Meal Name</label>
                    <input type="text" id="updateMealName" maxlength="50" placeholder="Enter meal name" autocomplete="off"/>
                </div>
                <div>
                    <label for="updateEstimatedPrepMinutes">Estimated Preparation Minutes</label>
                    <input type="number" id="updateEstimatedPrepMinutes" min="1" max="1440" placeholder="Enter preparation minutes" autocomplete="off"/>
                </div>
                <div>
                    <label for="updateImageUrl">Image</label>
                    <input type="text" id="updateImageUrl" maxlength="2048" placeholder="Enter image url" autocomplete="off"/>
                </div>
                <div>
                    <label for="updateCategory">Category</label>
                    <input type="text" id="updateCategory" maxlength="50" placeholder="Enter category" autocomplete="off"/>
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

    <script src="assets/js/meal_management.js"></script>
</body>
</html>