<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourFit Journey</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
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
            <li class="nav-item"><a class="nav-link active" href="#home" data-scroll-to="home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#features" data-scroll-to="features">Features</a></li>
            <li class="nav-item"><a class="nav-link" href="#testimonials" data-scroll-to="testimonials">Testimonials</a></li>
            <li class="nav-item"><a class="nav-link" href="#pricing" data-scroll-to="pricing">Pricing</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact" data-scroll-to="contact">Contact</a></li>
        </ul>
        <div class="auth-buttons d-flex justify-content-center justify-content-lg-end gap-2 mt-3 mt-lg-0">
            <a href="login.php" class="btn btn-outline-primary">Login</a>
            <a href="signup.php" class="btn btn-primary">Sign Up</a>
        </div>
        </div>
    </div>
    </nav>



    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Transform Your <span class="text-gradient">Fitness Journey</span></h1>
                    <p class="hero-subtitle">Custom workouts, personalized diet plans, and progress tracking all in one intelligent platform.</p>
                    <div class="hero-buttons">
                        <a href="login.php" class="btn btn-primary btn-lg">Get Started</a>
                        <a href="#features" class="btn btn-outline-primary btn-lg" data-scroll-to="features">Learn More</a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <h3>10k+</h3>
                            <p>Active Users</p>
                        </div>
                        <div class="stat-item">
                            <h3>500+</h3>
                            <p>Workout Plans</p>
                        </div>
                        <div class="stat-item">
                            <h3>98%</h3>
                            <p>Satisfaction</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-container">
                        <img src="assets/images/preview-dash.png" alt="Fitness" class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2>Powerful <span class="text-gradient">Features</span></h2>
                <p class="section-subtitle">Everything you need to achieve your fitness goals</p>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3>Prebuilt & Customizable Plans</h3>
                        <p>Choose from expert-designed workouts or create your own tailored routines.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3>Advanced Nutrition Tracking</h3>
                        <p>Track your macros, calories and meals with precision using detailed nutrition insights.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Progress Analytics</h3>
                        <p>Visualize your transformation through graphs and milestone tracking.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Personalized Diet Plan</h3>
                        <p>AI-powered meal plans tailored to your daily macronutrient and calorie needs.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Smart Calendar</h3>
                        <p>A calendar that records your workouts and helps you stay consistent with your goals.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Mobile Access</h3>
                        <p>Stay connected on-the-go with full access across all devices.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="section-padding bg-gradient">
        <div class="container">
            <div class="section-header text-center">
                <h2>What Our <span class="text-gradient">Users Say</span></h2>
                <p class="section-subtitle">Success stories from our community</p>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"YourFit Journey transformed my approach to fitness. The personalized diet plans and analytics helped me lose 20 pounds in just 3 months!"</p>
                        <div class="testimonial-user">
                            <img src="assets/images/testi_1.jpg" alt="User" class="testimonial-avatar">
                            <div>
                                <h5>Sarah Johnson</h5>
                                <p>Lost 20 lbs in 3 months</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"The nutrition tracking feature is a game-changer. I've finally been able to understand my eating habits and make meaningful changes."</p>
                        <div class="testimonial-user">
                            <img src="assets/images/testi_2.jpg" alt="User" class="testimonial-avatar">
                            <div>
                                <h5>Michael Chen</h5>
                                <p>Fitness enthusiast</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"As a busy professional, I love how YourFit Journey adapts to my schedule. The workouts are effective and I can do them anywhere!"</p>
                        <div class="testimonial-user">
                            <img src="assets/images/testi_3.jpg" alt="User" class="testimonial-avatar">
                            <div>
                                <h5>Emma Wilson</h5>
                                <p>Busy professional</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2>Simple <span class="text-gradient">Pricing</span></h2>
                <p class="section-subtitle">Choose the plan that fits your needs</p>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3>Basic</h3>
                            <div class="pricing-price">
                                <span class="currency">$</span>
                                <span class="amount">9</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="pricing-features">
                            <ul>
                                <li><i class="fas fa-check"></i> Prebuilt workout plans</li>
                                <li><i class="fas fa-check"></i> Basic nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Basic Progress monitoring</li>
                                <li class="disabled"><i class="fas fa-times"></i> Personalized Diet Plan</li>
                                <li class="disabled"><i class="fas fa-times"></i> Community access</li>
                                <li class="disabled"><i class="fas fa-times"></i> Coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="signup.php" class="btn btn-outline-primary btn-block">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card featured">
                        <div class="pricing-badge">Popular</div>
                        <div class="pricing-header">
                            <h3>Pro</h3>
                            <div class="pricing-price">
                                <span class="currency">$</span>
                                <span class="amount">19</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="pricing-features">
                            <ul>
                                <li><i class="fas fa-check"></i> Prebuilt & customizable workout plans</li>
                                <li><i class="fas fa-check"></i> Advanced nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Detailed progress analytics</li>
                                <li><i class="fas fa-check"></i> Personalized Diet Plan</li>
                                <li class="disabled"><i class="fas fa-times"></i> Community access</li>
                                <li class="disabled"><i class="fas fa-times"></i> Coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="signup.php" class="btn btn-primary btn-block">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card coming-soon">
                        <div class="coming-soon-badge">Coming Soon</div>
                        <div class="pricing-header">
                            <h3>Premium</h3>
                            <div class="pricing-price">
                                <span class="currency">$</span>
                                <span class="amount">39</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="pricing-features">
                            <ul>
                                <li><i class="fas fa-check"></i> Prebuilt & customizable workout plans</li>
                                <li><i class="fas fa-check"></i> Advanced nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Detailed progress analytics</li>
                                <li><i class="fas fa-check"></i> Personalized Diet Plan</li>
                                <li><i class="fas fa-check"></i> Community access</li>
                                <li><i class="fas fa-check"></i> Coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a class="btn btn-secondary btn-block disabled">Coming Soon</a>
                        </div>
                    </div>
                </div>

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
                        <a class="footer-logo" href="index.html">
                            <div class="logo-container">
                                <i class="fas fa-bolt logo-icon"></i>
                                <span>YourFit<span class="text-gradient">Journey</span></span>
                            </div>
                        </a>
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
                            <li><a href="#home" data-scroll-to="home">Home</a></li>
                            <li><a href="#features" data-scroll-to="features">Features</a></li>
                            <li><a href="#testimonials" data-scroll-to="testimonials">Testimonials</a></li>
                            <li><a href="#pricing" data-scroll-to="pricing">Pricing</a></li>
                            <li><a href="#contact" data-scroll-to="contact">Contact</a></li>
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
                        <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <?php include 'scroll_to_top.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/landing-page.js"></script>
</body>
</html>