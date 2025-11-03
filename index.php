<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
session_start();
include 'includes/db_connect.php';

// Get role if user is logged in
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLSU CIT - Borrowing and Inventory Management System</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f4f6fb;
            padding-top: 70px;
        }
        .navbar {
            background: rgba(13, 110, 253, 0.95) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .hero-section {
            position: relative;
            background: url('assets/images/cit.png') no-repeat center center/cover;
            color: white;
            padding: 120px 0 100px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(rgba(0, 32, 96, 0.6), rgba(0, 32, 96, 0.4));
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-section h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .hero-section p.lead {
            font-size: 1.3rem;
            margin-bottom: 32px;
        }
        .feature-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            transition: transform 0.3s, box-shadow 0.3s;
            background: #fff;
            margin-bottom: 30px;
        }
        .feature-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 32px rgba(13,110,253,0.12);
        }
        .feature-card .fa-3x {
            color: #0d6efd;
        }
        .stats-section {
            background: #fff;
            padding: 60px 0 40px 0;
        }
        .stat-card {
            background: #f4f6fb;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            text-align: center;
            padding: 36px 20px 28px 20px;
            margin-bottom: 24px;
        }
        .stat-number {
            font-size: 2.7em;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 1.1em;
            color: #333;
            font-weight: 500;
        }
        .footer {
            background: #222;
            color: #eee;
            padding: 36px 0 18px 0;
            font-size: 1em;
        }
        .footer h5 {
            font-weight: 700;
            margin-bottom: 8px;
        }
        .footer p {
            margin-bottom: 4px;
        }
        @media (max-width: 767px) {
            .hero-section {
                padding: 70px 0 60px 0;
            }
            .hero-section h1 {
                font-size: 2.1rem;
            }
            .stat-card {
                padding: 24px 10px 18px 10px;
            }
        }
        .scroll-indicator {
            position: absolute;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            z-index: 3;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }
        .feature-card .fa-3x {
            transition: transform 0.3s, color 0.3s;
        }
        .feature-card:hover .fa-3x {
            transform: scale(1.2) rotate(-8deg);
            color: #6610f2;
        }
        .svg-wave {
            display: block;
            width: 100%;
            margin-bottom: -2px;
        }
        .stat-icon {
            font-size: 2.2em;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .cta-section {
            background: linear-gradient(90deg, #0d6efd 60%, #6610f2 100%);
            color: #fff;
            padding: 60px 0 50px 0;
            text-align: center;
        }
        .cta-section .btn {
            font-size: 1.2em;
            padding: 12px 36px;
            border-radius: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .footer .social-icons a {
            color: #eee;
            margin: 0 8px;
            font-size: 1.3em;
            transition: color 0.2s;
        }
        .footer .social-icons a:hover {
            color: #0d6efd;
        }
        .footer .quick-links a {
            color: #eee;
            margin-right: 16px;
            text-decoration: none;
        }
        .footer .quick-links a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container ps-0">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/images/citlogo.png" alt="SLSU Logo" height="48" class="me-2 rounded-3 shadow-sm">
                <span>SLSU College of Industrial Technology</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="user_dashboard.php">User Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container hero-content">
            <h1 class="mb-3" data-aos="fade-down">Borrowing and Inventory Management System</h1>
            <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Efficiently manage and track equipment borrowing at SLSU College of Industrial Technology</p>
            <p class="mb-4" data-aos="fade-up" data-aos-delay="200"><em>Empowering students and staff with seamless, secure, and smart inventory solutions.</em></p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user_dashboard.php" class="btn btn-primary btn-lg me-2 shadow" data-aos="zoom-in" data-aos-delay="300">Go to Dashboard</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg me-2 shadow" data-aos="zoom-in" data-aos-delay="300">Borrow Now!</a>
            <?php endif; ?>
        </div>
        <div class="scroll-indicator">
            <i class="fa fa-angle-double-down fa-2x"></i>
        </div>
    </section>
    <svg class="svg-wave" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" fill-opacity="1" d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,53.3C672,43,768,21,864,16C960,11,1056,21,1152,32C1248,43,1344,53,1392,58.7L1440,64L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>

    <!-- Features Section -->
    <section id="features" class="py-5" style="margin-top: 40px;">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold" data-aos="fade-up">System Features</h2>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card feature-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body text-center">
                            <i class="fas fa-qrcode fa-3x mb-3"></i>
                            <h5 class="card-title fw-bold">QR Code Scanning</h5>
                            <p class="card-text">Quick and easy item borrowing through QR code scanning.</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feature1Modal">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card feature-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-body text-center">
                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                            <h5 class="card-title fw-bold">Inventory Lookup</h5>
                            <p class="card-text">Browse and search available equipment for borrowing.</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feature2Modal">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card feature-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body text-center">
                            <i class="fas fa-history fa-3x mb-3"></i>
                            <h5 class="card-title fw-bold">Borrowing History</h5>
                            <p class="card-text">View your complete borrowing history and receipts.</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feature3Modal">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card feature-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-3x mb-3"></i>
                            <h5 class="card-title fw-bold">User Profiles</h5>
                            <p class="card-text">Manage your profile and update your information securely.</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feature4Modal">Learn More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Modals -->
    <div class="modal fade" id="feature1Modal" tabindex="-1" aria-labelledby="feature1ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feature1ModalLabel">QR Code Scanning</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Borrow items quickly and securely by scanning QR codes assigned to each equipment. This reduces manual entry and errors, making the process seamless for both students and staff.
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="feature2Modal" tabindex="-1" aria-labelledby="feature2ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feature2ModalLabel">Inventory Lookup</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Browse and search for available equipment to borrow. See real-time availability and details for each item.
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="feature3Modal" tabindex="-1" aria-labelledby="feature3ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feature3ModalLabel">Borrowing History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            View your borrowing history, download receipts, and keep track of your borrowed items easily.
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="feature4Modal" tabindex="-1" aria-labelledby="feature4ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feature4ModalLabel">User Profiles</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Manage your personal information, update your password, and view your activity in one place.
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5>SLSU College of Industrial Technology</h5>
                    <p>Borrowing and Inventory Management System</p>
                    <div class="social-icons mt-2">
                        <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="quick-links mb-2">
                        <a href="help_about.php">Help</a>
                        <a href="help_about.php">About</a>
                        <a href="mailto:cit@slsu.edu.ph">Contact</a>
                    </div>
                    <p>Contact: <a href="mailto:cit@slsu.edu.ph" class="text-decoration-none text-light">cit@slsu.edu.ph</a></p>
                    <p>© 2025 SLSU CIT. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ once: true });
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
</body>
</html> 