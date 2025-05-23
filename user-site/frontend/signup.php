<?php
session_start();
require_once '../../utils/csrf.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - YourFit Journey</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="auth-page">    
    <!-- Signup Form -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="index.php" class="close-btn" aria-label="Close">
                    <i class="fas fa-xmark"></i>
                </a>

                <a href="index.html" class="auth-logo">
                    <div class="logo-container">
                        <i class="fas fa-bolt logo-icon"></i>
                        <span>YourFit<span class="text-gradient">Journey</span></span>
                    </div>
                </a>

                <h2>Create Account</h2>
                <p>Start your fitness journey today</p>
            </div>
            <div class="auth-body">
                <form id="signup-form" action="../backend/process_signup.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="first-name" class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="first-name" class="form-control" id="first-name" placeholder="John" value="<?= htmlspecialchars($_SESSION['first-name'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="last-name" class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Doe" value="<?= htmlspecialchars($_SESSION['last-name'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="confirm-password" class="form-control" id="confirm-password" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gender</label>
                        <div class="gender-options">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= ($_SESSION['gender'] ?? '') === 'male' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= ($_SESSION['gender'] ?? '') === 'female' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                    </div>

                    <?php require_once '../../utils/message.php'; ?>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                    </div>
                </form>
                
                <div class="auth-divider">
                    <span>or sign up with</span>
                </div>
                
                <div class="social-auth">
                    <button class="btn btn-outline-light social-btn">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </button>
                    <button class="btn btn-outline-light social-btn">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                </div>
            </div>
            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>