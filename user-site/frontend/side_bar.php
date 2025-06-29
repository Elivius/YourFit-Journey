<aside class="sidebar collapsed" id="sidebar">
    <div class="sidebar-header">
        <a href="dashboard.php" class="sidebar-logo">
            <div class="logo-container fs-4">
                <i class="fas fa-bolt logo-icon"></i>
                <span>YourFit<span class="text-gradient">Journey</span></span>
            </div>
        </a>
    </div>
    <a href="settings.php" class="sidebar-user">
        <img src="assets/images/profile_picture/<?= $_SESSION['pfp'] ?>" 
            alt="Profile Picture" class="user-avatar">
        <div>
            <h6 class="user-name"><?= $_SESSION['name'] ?></h6>
            <span class="user-status">Standard Member</span>
        </div>
    </a>
    <nav class="sidebar-nav">
        <ul>
            <li class="sidebar-item active" style="--item-index: 0">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item" style="--item-index: 1">
                <a href="workouts.php" class="sidebar-link">
                    <i class="fas fa-dumbbell"></i>
                    <span>Workouts</span>
                </a>
            </li>
            <li class="sidebar-item" style="--item-index: 2">
                <a href="nutrition.php" class="sidebar-link">
                    <i class="fas fa-utensils"></i>
                    <span>Nutrition</span>
                </a>
            </li>
            <li class="sidebar-item" style="--item-index: 3">
                <a href="settings.php" class="sidebar-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../../utils/logout.php" class="sidebar-link logout-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>