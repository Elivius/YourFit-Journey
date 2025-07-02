<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM feedbacks_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Feedbacks - YourFit Journey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/feedback.css">
</head>
<body>
<div class="container">
    <a class="back-btn" href="dashboard.php" id="backToDashboardBtn">
        <span class="material-icons" style="font-size:19px;vertical-align:-3px;">arrow_back</span>
        Back to Dashboard
    </a>
    <h2>
        User Feedbacks
    </h2>
    <div class="toolbar">
        <div class="toolbar-actions-left">
            <!-- Filter and Clear Function -->
            <span style="position:relative; display:inline-block; margin-left:10px;">
                <i class="material-icons" style="position:absolute; left:10px; top:38%; transform:translateY(-50%); color:#b3b3fd; font-size:18px; pointer-events:none;">search</i>
                <input type="text" id="filterInput" placeholder="Name or Email" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
                <button id="clearFilterBtn" type="button" style="position:absolute; right:6px; top:50%; transform:translateY(-50%); background:none; border:none; color:#b3b3fd; font-size:16px; cursor:pointer; display:none;" tabindex="-1" aria-label="Clear filter">
                    <i class="material-icons">close</i>
                </button>
            </span>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Feedback ID</th>
                    <th>User ID</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody id="dataTable"> 
                <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['fdb_id']) ?></td>
                        <td><?= htmlspecialchars($row['usr_id']) ?></td>
                        <td><?= htmlspecialchars($row['fdb_category']) ?></td>
                        <td><?= htmlspecialchars($row['fdb_subject']) ?></td>
                        <td><?= htmlspecialchars($row['fdb_message']) ?></td>
                        <td><?= htmlspecialchars($row['fdb_created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="toast" id="toast"></div>

<?php include 'scroll_to_top.php'; ?>

<script src="assets/js/feedback.js"></script>
</body>
</html>