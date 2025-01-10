<!DOCTYPE html>
<html>
<head>
    <title>CAMS - College Admission Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('./images/hotel.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            display: flex;
            align-items: center;
        }

        /* Features Cards */
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: white;
            padding: 5rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        /* Timeline Section */
        .timeline-section {
            position: relative;
            padding: 5rem 0;
        }

        .timeline-item {
            padding: 2rem;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('./images/hotel.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
        }

        /* Footer */
        .footer {
            background: #1a237e;
            color: white;
            padding: 3rem 0;
        }

        .social-links a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-3 fw-bold mb-4">Welcome to College Admission Management System</h1>
                <p class="lead mb-4">Streamline your college admission process with our comprehensive management system. Apply, track, and succeed in your academic journey.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="login.php" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                    <a href="register.php" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Why Choose CAMS?</h2>
            <p class="lead text-muted">Experience a seamless admission process with our features</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card p-4">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="h4 text-center mb-3">Online Application</h3>
                    <p class="text-muted text-center">Apply to your desired programs from anywhere, anytime. Our system makes it easy to submit your application online.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card p-4">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="h4 text-center mb-3">Track Progress</h3>
                    <p class="text-muted text-center">Monitor your application status in real-time. Stay updated with notifications about your admission progress.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card p-4">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="h4 text-center mb-3">Secure Process</h3>
                    <p class="text-muted text-center">Your data is safe with us. We ensure complete security of your personal and academic information.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4" data-aos="fade-up">
                <div class="stat-item">
                    <div class="stat-number">5000+</div>
                    <div class="h5">Students Enrolled</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <div class="stat-number">20+</div>
                    <div class="h5">Programs Offered</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="h5">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admission Process Timeline -->
<section class="timeline-section bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Admission Process</h2>
            <p class="lead text-muted">Follow these simple steps to begin your journey</p>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="timeline-item" data-aos="fade-up">
                    <h4><i class="fas fa-user-plus text-primary me-2"></i>1. Register</h4>
                    <p class="text-muted">Create your account with basic information</p>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                    <h4><i class="fas fa-file-alt text-primary me-2"></i>2. Fill Application</h4>
                    <p class="text-muted">Complete your application with academic details</p>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                    <h4><i class="fas fa-upload text-primary me-2"></i>3. Submit Documents</h4>
                    <p class="text-muted">Upload required documents and transcripts</p>
                </div>
                <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                    <h4><i class="fas fa-check-circle text-primary me-2"></i>4. Track Status</h4>
                    <p class="text-muted">Monitor your application status</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-4">Ready to Begin Your Journey?</h2>
                <p class="lead mb-4">Join thousands of students who have successfully enrolled through our platform</p>
                <a href="register.php" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-rocket me-2"></i>Get Started Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="h5 mb-3">About CAMS</h4>
                <p class="mb-0">College Admission Management System streamlines the admission process for students and institutions alike.</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="h5 mb-3">Quick Links</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="h5 mb-3">Connect With Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-light">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> CAMS. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
</body>
</html>