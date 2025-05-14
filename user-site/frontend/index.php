<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourFit Journey</title>
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
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="fas fa-bolt logo-icon me-2"></i>
                <span>YourFit<span class="text-gradient">Journey</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features" data-scroll-to="features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials" data-scroll-to="testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing" data-scroll-to="pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact" data-scroll-to="contact">Contact</a></li>
                </ul>
                <div class="auth-buttons d-flex gap-2">
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
                    <p class="hero-subtitle">Personalized workout plans, nutrition tracking, and progress analytics all in one intelligent platform.</p>
                    <div class="hero-buttons">
                        <a href="login.php" class="btn btn-primary btn-lg">Get Started</a>
                        <a href="#features" class="btn btn-outline-primary btn-lg">Learn More</a>
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
                        <h3>Smart Workouts</h3>
                        <p>AI-powered workout plans that adapt to your progress and preferences.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3>Nutrition Tracking</h3>
                        <p>Detailed nutrition analytics and personalized meal recommendations.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Progress Analytics</h3>
                        <p>Visualize your fitness journey with advanced progress tracking.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Smart Calendar</h3>
                        <p>Plan your workouts and meals with our intelligent scheduling system.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Community Support</h3>
                        <p>Connect with like-minded fitness enthusiasts and share your journey.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Mobile Access</h3>
                        <p>Access your fitness data anytime, anywhere with our mobile app.</p>
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
                        <p class="testimonial-text">"YourFit Journey transformed my approach to fitness. The personalized plans and analytics helped me lose 20 pounds in just 3 months!"</p>
                        <div class="testimonial-user">
                            <img src="https://source.unsplash.com/random/100x100/?portrait" alt="User" class="testimonial-avatar">
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
                            <img src="https://source.unsplash.com/random/100x100/?man" alt="User" class="testimonial-avatar">
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
                            <img src="https://source.unsplash.com/random/100x100/?woman" alt="User" class="testimonial-avatar">
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
                                <li><i class="fas fa-check"></i> Personalized workout plans</li>
                                <li><i class="fas fa-check"></i> Basic nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Progress monitoring</li>
                                <li class="disabled"><i class="fas fa-times"></i> Advanced analytics</li>
                                <li class="disabled"><i class="fas fa-times"></i> Coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="signup.html" class="btn btn-outline-primary btn-block">Get Started</a>
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
                                <li><i class="fas fa-check"></i> Personalized workout plans</li>
                                <li><i class="fas fa-check"></i> Advanced nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Detailed progress analytics</li>
                                <li><i class="fas fa-check"></i> Community access</li>
                                <li class="disabled"><i class="fas fa-times"></i> Coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="signup.html" class="btn btn-primary btn-block">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card">
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
                                <li><i class="fas fa-check"></i> Personalized workout plans</li>
                                <li><i class="fas fa-check"></i> Advanced nutrition tracking</li>
                                <li><i class="fas fa-check"></i> Detailed progress analytics</li>
                                <li><i class="fas fa-check"></i> Community access</li>
                                <li><i class="fas fa-check"></i> Personal coach support</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="signup.html" class="btn btn-outline-primary btn-block">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding bg-gradient">
        <div class="container">
            <div class="section-header text-center">
                <h2>Get In <span class="text-gradient">Touch</span></h2>
                <p class="section-subtitle">We'd love to hear from you</p>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-lg-6">
                    <div class="contact-info">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5>Our Location</h5>
                                <p>123 Fitness Street, Health City, 10001</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>Email Us</h5>
                                <p>info@yourfitjourney.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h5>Call Us</h5>
                                <p>+1 (555) 123-4567</p>
                            </div>
                        </div>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form-card">
                        <form id="contact-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-about">
                        <a class="footer-logo" href="index.html">
                            <div class="logo-container">
                                <i class="fas fa-bolt logo-icon"></i>
                                <span>YourFit<span class="text-gradient">Journey</span></span>
                            </div>
                        </a>
                        <p>YourFit Journey is a comprehensive fitness platform designed to help you achieve your health and fitness goals through personalized workouts and nutrition plans.</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="#home">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="#testimonials">Testimonials</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h5>Resources</h5>
                        <ul>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Fitness Tips</a></li>
                            <li><a href="#">Nutrition Guide</a></li>
                            <li><a href="#">Workout Library</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
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
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2023 YourFit Journey. All rights reserved.</p>
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