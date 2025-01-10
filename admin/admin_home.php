<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch data for dashboard
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$totalApplications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM application"))['total'];
$pendingApplications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM application WHERE status = 'submitted'"))['total'];
$acceptedApplications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM application WHERE status = 'accepted'"))['total'];

// Get recent applications
$recentApplications = mysqli_query($conn, "SELECT * FROM application ORDER BY application_date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <style>
        .dashboard-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: 2rem;
        }
        .stats-card {
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .recent-activity {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }
        .activity-item {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: white;
            transition: transform 0.3s ease;
        }
        .activity-item:hover {
            transform: translateX(5px);
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
        }
        .status-submitted { background: #fff3cd; color: #856404; }
        .status-accepted { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body class="bg-light">

<?php include('admin_navbar.php'); ?>

<div class="container py-4">
    <!-- Header Section -->
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h2>
                <p class="text-muted mb-0">Welcome back! Here's what's happening</p>
            </div>
            <div>
                <span class="text-muted">
                    <i class="fas fa-calendar-alt me-2"></i><?php echo date('F j, Y'); ?>
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Total Users</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users fa-2x me-3"></i>
                        <span class="h3 mb-0"><?php echo $totalUsers; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Total Applications</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt fa-2x me-3"></i>
                        <span class="h3 mb-0"><?php echo $totalApplications; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Pending Applications</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock fa-2x me-3"></i>
                        <span class="h3 mb-0"><?php echo $pendingApplications; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Accepted Applications</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <span class="h3 mb-0"><?php echo $acceptedApplications; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="recent-activity">
            <h3 class="h5 mb-4"><i class="fas fa-history me-2"></i>Recent Applications</h3>
            <?php while($app = mysqli_fetch_assoc($recentApplications)): ?>
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1"><?php echo $app['student_name']; ?></h6>
                            <small class="text-muted">
                                <i class="fas fa-graduation-cap me-1"></i><?php echo $app['degree']; ?> - 
                                <i class="fas fa-calendar me-1"></i><?php echo date('M j, Y', strtotime($app['application_date'])); ?>
                            </small>
                        </div>
                        <div>
                            <?php
                            $statusClass = '';
                            switch(strtolower($app['status'])) {
                                case 'submitted': $statusClass = 'status-submitted'; break;
                                case 'accepted': $statusClass = 'status-accepted'; break;
                                case 'rejected': $statusClass = 'status-rejected'; break;
                            }
                            ?>
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo ucfirst($app['status']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <div class="text-center mt-4">
                <a href="view_applications.php" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>View All Applications
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>