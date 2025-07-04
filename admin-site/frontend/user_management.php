<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
require_once '../../utils/csrf.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM users_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            User Management
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
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Profile Picture</th>
                        <th>Role</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Weight (kg)</th>
                        <th>Height (cm)</th>
                        <th>Activity Level</th>
                        <th>Goal</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?= htmlspecialchars($row['usr_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['usr_id']) ?></td>
                            <td><?= htmlspecialchars($row['usr_first_name']) ?></td>
                            <td><?= htmlspecialchars($row['usr_last_name']) ?></td>
                            <td><?= htmlspecialchars($row['usr_email']) ?></td>
                            <td><?= htmlspecialchars($row['usr_password']) ?></td>
                            <td>
                                <?php if (!empty($row['usr_profile_pic'])) : ?>
                                    <img src="../../user-site/frontend/assets/images/profile_picture/<?= htmlspecialchars($row['usr_profile_pic']) ?>" alt="Profile" width="70" height="70" style="border-radius: 50%; object-fit: cover;">
                                <?php else : ?>
                                    <span>No Profile Picture</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['usr_role']) ?></td>
                            <td><?= htmlspecialchars($row['usr_age']) ?></td>
                            <td><?= htmlspecialchars($row['usr_gender']) ?></td>
                            <td><?= htmlspecialchars($row['usr_weight']) ?></td>
                            <td><?= htmlspecialchars($row['usr_height']) ?></td>
                            <td><?= htmlspecialchars($row['usr_activity_level']) ?></td>
                            <td><?= htmlspecialchars($row['usr_goal']) ?></td>
                            <td><?= htmlspecialchars($row['usr_created_at']) ?></td>
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
            <div class="modal-title">Add New User</div>
            
            <form action="../backend/process_add_user_management.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <div class="modal-form-grid">
                    <div>
                        <label for="addFirstName">First Name</label>
                        <input type="text" name="firstName" id="addFirstName" maxlength="50" placeholder="Enter first name" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addLastName">Last Name</label>
                        <input type="text" name="lastName" id="addLastName" maxlength="50" placeholder="Enter last name" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addEmail">Email</label>
                        <input type="email" name="email" id="addEmail" maxlength="100" placeholder="Enter email" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addPassword">Password</label>
                        <input type="text" name="password" id="addPassword" maxlength="100" placeholder="Enter password" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addProfilePicture">Profile Picture</label>
                        <input type="file" name="pfp" id="addProfilePicture" maxlength="2048" placeholder="Enter profile picture link" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="addRole">Role (Read Only)</label>
                        <input type="text" name="role" id="addRole" placeholder="Enter role" value="User" required readonly />
                    </div>
                    <div>
                        <label for="addWeight">Age</label>
                        <input type="number" name="age" id="addAge" placeholder="Enter age" step="1" min="0" max="999" required />
                    </div>
                    <div>
                        <label for="addGender">Gender</label>
                        <select size="1" name="gender" id="addGender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="addWeight">Weight (kg)</label>
                        <input type="number" name="weight" id="addWeight" placeholder="Enter weight" step="0.1" min="0" max="999.9" required />
                    </div>
                    <div>
                        <label for="addHeight">Height (cm)</label>
                        <input type="number" name="height" id="addHeight" placeholder="Enter height" step="0.1" min="0" max="999.9" required />
                    </div>
                    <div>
                        <label for="addActivityLevel">Activity Level</label>
                        <select size="1" name="activityLevel" id="addActivityLevel" required>
                            <option value="" disabled selected>Select Activity Level</option>
                            <option value="sedentary">Sedentary</option>
                            <option value="light">Light</option>
                            <option value="moderate">Moderate</option>
                            <option value="active">Active</option>
                            <option value="very_active">Very Active</option>
                        </select>
                    </div>
                    <div>
                        <label for="addGoal">Goal</label>
                        <select size="1" name="goal" id="addGoal" required>
                            <option value="" disabled selected>Select Goal</option>
                            <option value="cutting">Cutting</option>
                            <option value="maintain">Maintain</option>
                            <option value="bulking">Bulking</option>
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
            <div class="modal-title">Edit User</div>
            
            <form action="../backend/process_update_user_management.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()); ?>">
                <input type="hidden" name="userId" id="updateUserId">
                <div class="modal-form-grid">
                    <div>
                        <label for="updateFirstName">First Name</label>
                        <input type="text" name="firstName" id="updateFirstName" maxlength="50" placeholder="Enter first name" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateLastName">Last Name</label>
                        <input type="text" name="lastName" id="updateLastName" maxlength="50" placeholder="Enter last name" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateEmail">Email</label>
                        <input type="email" name="email" id="updateEmail" maxlength="100" placeholder="Enter email" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updatePassword">Password</label>
                        <input type="text" name="password" id="updatePassword" maxlength="100" placeholder="Enter password" autocomplete="off" required />
                    </div>
                    <div>
                        <label for="updateProfilePicture">Profile Picture</label>
                        <input type="file" name="pfp" id="updateProfilePicture" maxlength="2048" placeholder="Enter profile picture" autocomplete="off" />
                    </div>
                    <div>
                        <label for="updateRole">Role (Read Only)</label>
                        <input type="text" name="role" id="updateRole" placeholder="Enter role" value="User" readonly required />
                    </div>
                    <div>
                        <label for="updateAge">Age</label>
                        <input type="number" name="age" id="updateAge" placeholder="Enter age" step="1" min="0" max="999" required />
                    </div>
                    <div>
                        <label for="updateGender">Gender</label>
                        <select size="1" name="gender" id="updateGender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="updateWeight">Weight (kg)</label>
                        <input type="number" name="weight" id="updateWeight" placeholder="Enter weight" step="0.1" min="0" max="999.9" required />
                    </div>
                    <div>
                        <label for="updateHeight">Height (cm)</label>
                        <input type="number" name="height" id="updateHeight" placeholder="Enter height" step="0.1" min="0" max="999.9" required />
                    </div>
                    <div>
                        <label for="updateActivityLevel">Activity Level</label>
                        <select size="1" name="activityLevel" id="updateActivityLevel" required>
                            <option value="" disabled selected>Select Activity Level</option>
                            <option value="sedentary">Sedentary</option>
                            <option value="light">Light</option>
                            <option value="moderate">Moderate</option>
                            <option value="active">Active</option>
                            <option value="very_active">Very Active</option>
                        </select>
                    </div>
                    <div>
                        <label for="updateGoal">Goal</label>                        
                        <select size="1" name="goal" id="updateGoal" required>
                            <option value="" disabled selected>Select Goal</option>
                            <option value="cutting">Cutting</option>
                            <option value="maintain">Maintain</option>
                            <option value="bulking">Bulking</option>
                        </select>
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

    <script src="assets/js/user_management.js"></script>
</body>
</html>