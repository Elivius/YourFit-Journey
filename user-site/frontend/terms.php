<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/landing-page.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="fas fa-bolt logo-icon me-2"></i>
            <span>YourFit<span class="text-gradient">Journey</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item"><a class="nav-link active" href="index.php#home" data-scroll-to="home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#features" data-scroll-to="features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#testimonials" data-scroll-to="testimonials">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#pricing" data-scroll-to="pricing">Pricing</a></li>
            </ul>
            <div class="auth-buttons d-flex justify-content-center justify-content-lg-end gap-2 mt-3 mt-lg-0">
                <a href="login.php" class="btn btn-outline-primary">Login</a>
                <a href="signup.php" class="btn btn-primary">Sign Up</a>
            </div>
            </div>
        </div>
    </nav>

    <!-- Terms Content -->
    <section class="hero-section">
        <div class="container">

            <div class="mb-5">
                <button onclick="history.back()" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </button>
            </div>

            <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5 bg-white">
                <h1 class="mb-4">Terms of Service</h1>
                <p class="mb-2">Welcome to YourFit Journey. By accessing or using our website, you agree to be bound by these terms:</p>

                <hr>

                <h4 class="mb-3 mt-4">1. Use of Service</h4>
                <p class="mb-4">You must be at least 13 years old. You are responsible for your account's security.</p>

                <h4 class="mb-3 mt-4">2. Health Disclaimer</h4>
                <p class="mb-4">We are not medical professionals. Always consult your doctor before following fitness or diet advice.</p>

                <h4 class="mb-3 mt-4">3. Termination</h4>
                <p class="mb-4">We reserve the right to suspend accounts that misuse the platform or violate the terms.</p>

                <h4 class="mb-3 mt-4">4. Modifications</h4>
                <p class="mb-4">These terms may be updated anytime. Continued use means acceptance of changes.</p>

                <h4 class="mb-3 mt-4">5. Contact</h4>
                <p class="mb-0">Reach us at <a href="mailto:support@yourfitjourney.com">support@yourfitjourney.com</a>.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row gy-4">
                <!-- About Section -->
                <div class="col-lg-6 col-md-12">
                    <div class="footer-about">
                        <div class="footer-logo">
                            <div class="logo-container mb-2">
                                <i class="fas fa-bolt logo-icon"></i>
                                YourFit<span class="text-gradient">Journey
                            </div>
                        </div>
                        <p style="text-align: justify;">
                            YourFit Journey is a comprehensive fitness platform built to support your health goals with customizable workouts and personalized meal plans.
                        </p>
                    </div>
                </div>

                <!-- Subscribe Section -->
                <div class="col-lg-6 col-md-12">
                    <div class="footer-newsletter">
                        <h5>Subscribe to Our Newsletter</h5>
                        <p>Get the latest fitness tips and updates delivered to your inbox.</p>
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address" required>
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Links Section (Vertical Layout) -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php#home" data-scroll-to="home">Home</a></li>
                            <li><a href="index.php#features" data-scroll-to="features">Features</a></li>
                            <li><a href="index.php#testimonials" data-scroll-to="testimonials">Testimonials</a></li>
                            <li><a href="index.php#pricing" data-scroll-to="pricing">Pricing</a></li>
                        </ul>
                    </div>
                </div>
            </div>    
    
            <!-- Footer Bottom -->
            <div class="footer-bottom mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; <?= date('Y') ?> YourFit Journey. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms of Service</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/landing-page.js"></script>    
</body>
</html>