<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/modal.css">
</head>
<body>    
    <footer class="footer py-5">
        <div class="container">
            <div class="row gy-4 align-items-start">
                <!-- About Section -->
                <div class="col-lg-6 col-md-12 pe-lg-5">
                    <div class="footer-about">
                        <div class="sidebar-logo">
                            <div class="logo-container fs-4">
                                <i class="fas fa-bolt logo-icon"></i>
                                <span>YourFit<span class="text-gradient">Journey</span></span>
                            </div>
                        </div>
                        <p class="text-justify small mb-0">
                            YourFit Journey is a comprehensive fitness platform built to support your health goals with customizable workouts and personalized meal plans.
                        </p>
                    </div>
                </div>
    
                <!-- Quick Links Section -->
                <div class="col-lg-3 col-md-6 offset-lg-1">
                    <div class="footer-links">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><a href="dashboard.php" class="text-decoration-none" style="font-size: 14px;">Dashboard</a></li>
                            <li class="mb-2"><a href="workouts.php" class="text-decoration-none" style="font-size: 14px;">Workouts</a></li>
                            <li class="mb-2"><a href="nutrition.php" class="text-decoration-none" style="font-size: 14px;">Nutrition</a></li>
                            <li class="mb-2"><a href="settings.php" class="text-decoration-none"  style="font-size: 14px;">Settings</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <hr class="border-secondary mt-5">
    
            <!-- Footer Bottom -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> YourFit Journey. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end small">
                    <a href="#" onclick="openPrivacyModal(); return false;" class="text-decoration-none me-2">Privacy Policy</a>
                    |
                    <a href="#" onclick="openTermsModal(); return false;" class="text-decoration-none ms-2">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <?php include 'privacy-terms.php'; ?>

    <!-- JS to open Terms and Privacy Modal -->
    <script src="assets/js/privacy-terms.js"></script>
</body>
</html>
