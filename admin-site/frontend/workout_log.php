<?php
$requireRole = 'admin';
require_once '../../utils/auth.php';
?>

<?php
require_once '../../utils/connection.php';

$sql = 'SELECT * FROM workout_logs_t';
$results = mysqli_query($connection, $sql);

if (!$results) {
    die('Database error: ' . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Logs - YourFit Journey</title>
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
            Workout Logs
        </h2>
         <div class="toolbar" style="margin-bottom: 16px;">
            <span style="position:relative; display:inline-block;">
                <i class="material-icons" style="position:absolute; left:10px; top:38%; transform:translateY(-50%); color:#b3b3fd; font-size:18px; pointer-events:none;">search</i>
                <input type="text" id="filterInput" placeholder="Name" style="padding:7px 32px 7px 34px; border-radius:8px; border:1.5px solid #d1d7fa; font-size:14px; transition:border-color 0.2s, box-shadow 0.2s;">
                <button id="clearFilterBtn" style="display:none;margin-left:8px;padding:6px 10px;">Clear</button>
            </span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Workout Log ID</th>
                        <th>User ID</th>
                        <th>Workout Name</th>
                        <th>Estimated Duration (mins)</th>
                        <th>Exercise Count</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="dataTable"> 
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['wol_id']) ?></td>
                            <td><?= htmlspecialchars($row['usr_id']) ?></td>
                            <td><?= htmlspecialchars($row['wol_name']) ?></td>
                            <td><?= htmlspecialchars($row['wol_estimated_duration']) ?></td>
                            <td><?= htmlspecialchars($row['wol_exercise_count']) ?></td>
                            <td><?= htmlspecialchars($row['wol_created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'scroll_to_top.php'; ?>

    <script src="assets/js/workout_log.js"></script>
</body>
</html>