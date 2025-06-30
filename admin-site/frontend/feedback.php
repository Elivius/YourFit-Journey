<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/feedback.css">
</head>
<body>
<div class="container">
    <a class="back-btn" href="dashboard.php" id="backToDashboardBtn">
        <span class="material-icons" style="font-size:19px;vertical-align:-3px;">arrow_back</span>
        Back to Dashboard
    </a>
    <h2>
        Feedback Management
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
                    <th>Feedback ID</th>
                    <th>User ID</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody id="dataTable"> 
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal-backdrop" id="addBackdrop"></div>
<div class="modal-dialog" id="addModal">
    <div class="modal-content">
        <button class="modal-close" type="button" id="addCloseBtn" aria-label="Close">&times;</button>
        <div class="modal-title">Add New Feedback</div>
        <div class="modal-form-grid">
            <div>
                <label for="addFeedbackId">Feedback ID</label>
                <input type="text" id="addFeedbackId" maxlength="10" placeholder="Enter feedback ID" autocomplete="off"/>
            </div>
            <div>
                <label for="addUserId">User ID</label>
                <input type="text" id="addUserId" maxlength="10" placeholder="Enter user ID" autocomplete="off"/>
            </div>
            <div>
                <label for="addCategory">Category</label>
                <input type="text" id="addCategory" maxlength="50" placeholder="Enter category" autocomplete="off"/>
            </div>
            <div>
                <label for="addSubject">Subject</label>
                <input type="text" id="addSubject" maxlength="100" placeholder="Enter subject" autocomplete="off"/>
            </div>
            <div>
                <label for="addMessage">Message</label>
                <input type="text" id="addMessage" maxlength="500" placeholder="Enter message" autocomplete="off"/>
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
        <div class="modal-title">Edit Feedback</div>
        <div class="modal-form-grid">
            <div>
                <label for="updateFeedbackId">Feedback ID</label>
                <input type="text" id="updateFeedbackId" maxlength="10" placeholder="Enter feedback ID" autocomplete="off"/>
            </div>
            <div>
                <label for="updateUserId">User ID</label>
                <input type="text" id="updateUserId" maxlength="10" placeholder="Enter user ID" autocomplete="off"/>
            </div>
            <div>
                <label for="updateCategory">Category</label>
                <input type="text" id="updateCategory" maxlength="50" placeholder="Enter category" autocomplete="off"/>
            </div>
            <div>
                <label for="updateSubject">Subject</label>
                <input type="text" id="updateSubject" maxlength="100" placeholder="Enter subject" autocomplete="off"/>
            </div>
            <div>
                <label for="updateMessage">Message</label>
                <input type="text" id="updateMessage" maxlength="500" placeholder="Enter message" autocomplete="off"/>
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
<script src="assets/js/feedback.js"></script>
</body>
</html>