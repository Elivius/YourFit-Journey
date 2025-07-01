<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
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
    <link rel="stylesheet" href="assets/css/user.css">
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
                <input type="text" id="filterInput" placeholder="Name or Email" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
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
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Profile Picture</th>
                    <th>Role</th>
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
        <div class="modal-form-grid">
            <div>
                <label for="addFirstName">First Name</label>
                <input type="text" id="addFirstName" maxlength="50" placeholder="Enter first name" autocomplete="off"/>
            </div>
            <div>
                <label for="addLastName">Last Name</label>
                <input type="text" id="addLastName" maxlength="50" placeholder="Enter last name" autocomplete="off"/>
            </div>
            <div>
                <label for="addEmail">Email</label>
                <input type="email" id="addEmail" maxlength="100" placeholder="Enter email" autocomplete="off"/>
            </div>
            <div>
                <label for="addPassword">Password</label>
                <input type="text" id="addPassword" maxlength="100" placeholder="Enter password" autocomplete="off"/>
            </div>
            <div>
                <label for="addProfilePicture">Profile Picture</label>
                <input type="text" id="addProfilePicture" maxlength="2048" placeholder="Enter profile picture link" autocomplete="off"/>
            </div>
            <div>
                <label for="addRole">Role</label>
                <input type="text" id="addRole" maxlength="20" placeholder="Enter role" autocomplete="off"/>
            </div>
            <div>
                <label for="addGender">Gender</label>
                <input type="text" id="addGender" maxlength="10" placeholder="Enter gender" autocomplete="off"/>
            </div>
            <div>
                <label for="addWeight">Weight</label>
                <input type="text" id="addWeight" maxlength="5" placeholder="Enter weight" autocomplete="off"/>
            </div>
            <div>
                <label for="addHeight">Height</label>
                <input type="text" id="addHeight" maxlength="5" placeholder="Enter height" autocomplete="off"/>
            </div>
            <div>
                <label for="addActivityLevel">Activity Level</label>
                <input type="text" id="addActivityLevel" maxlength="30" placeholder="Enter activity level" autocomplete="off"/>
            </div>
            <div>
                <label for="addGoal">Goal</label>
                <input type="text" id="addGoal" maxlength="50" placeholder="Enter goal" autocomplete="off"/>
            </div>
            <div>
                <label for="addCreatedAt">Created At</label>
                <input type="text" id="addCreatedAt" maxlength="25" placeholder="Enter creation date" autocomplete="off"/>
            </div>
        </div>
        <div class="modal-actions">
            <input type="submit" value="Add" id="addSubmit">
            <button type="button" class="cancel-popup" id="addCancel">Cancel</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-backdrop" id="updateBackdrop"></div>
<div class="modal-dialog" id="updateModal">
    <div class="modal-content">
        <button class="modal-close" type="button" id="updateCloseBtn" aria-label="Close">&times;</button>
        <div class="modal-title">Edit User</div>
        <div class="modal-form-grid">
            <div>
                <label for="updateFirstName">First Name</label>
                <input type="text" id="updateFirstName" maxlength="50" placeholder="Enter first name" autocomplete="off"/>
            </div>
            <div>
                <label for="updateLastName">Last Name</label>
                <input type="text" id="updateLastName" maxlength="50" placeholder="Enter last name" autocomplete="off"/>
            </div>
            <div>
                <label for="updateEmail">Email</label>
                <input type="email" id="updateEmail" maxlength="100" placeholder="Enter email" autocomplete="off"/>
            </div>
            <div>
                <label for="updatePassword">Password</label>
                <input type="text" id="updatePassword" maxlength="100" placeholder="Enter password" autocomplete="off"/>
            </div>
            <div>
                <label for="updateProfilePicture">Profile Picture</label>
                <input type="text" id="updateProfilePicture" maxlength="2048" placeholder="Enter profile picture link" autocomplete="off"/>
            </div>
            <div>
                <label for="updateRole">Role</label>
                <input type="text" id="updateRole" maxlength="20" placeholder="Enter role" autocomplete="off"/>
            </div>
            <div>
                <label for="updateGender">Gender</label>
                <input type="text" id="updateGender" maxlength="10" placeholder="Enter gender" autocomplete="off"/>
            </div>
            <div>
                <label for="updateWeight">Weight</label>
                <input type="text" id="updateWeight" maxlength="5" placeholder="Enter weight" autocomplete="off"/>
            </div>
            <div>
                <label for="updateHeight">Height</label>
                <input type="text" id="updateHeight" maxlength="5" placeholder="Enter height" autocomplete="off"/>
            </div>
            <div>
                <label for="updateActivityLevel">Activity Level</label>
                <input type="text" id="updateActivityLevel" maxlength="30" placeholder="Enter activity level" autocomplete="off"/>
            </div>
            <div>
                <label for="updateGoal">Goal</label>
                <input type="text" id="updateGoal" maxlength="50" placeholder="Enter goal" autocomplete="off"/>
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

<script src="assets/js/user.js"></script>
</body>
</html>