<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weight Log Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/weight_log.css">
</head>
<body>
<div class="container">
    <a class="back-btn" href="dashboard.php" id="backToDashboardBtn">
        <span class="material-icons" style="font-size:19px;vertical-align:-3px;">arrow_back</span>
        Back to Dashboard
    </a>
    <h2>
        Weight Log Management
    </h2>
    <div class="filter-bar" style="margin-bottom: 16px;">
        <input type="text" id="filterInput" placeholder="Filter by meal name..." style="padding:6px 10px;border:1px solid #d1d7fa;border-radius:4px;">
        <button id="clearFilterBtn" style="display:none;margin-left:8px;padding:6px 10px;">Clear</button>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" aria-label="Select all"/></th>
                    <th>Weight Log ID</th>
                    <th>User ID</th>
                    <th>Weight</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody id="dataTable"> 
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>
</div>
<script src="assets/js/weight_log.js"></script>
</body>
</html>