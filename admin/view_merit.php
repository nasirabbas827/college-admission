<?php
include('config.php');

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Retrieve the merit list data from the database
$sql = "SELECT * FROM merit_list ORDER BY matric_marks DESC, inter_marks DESC";
$result = mysqli_query($conn, $sql);

// Handle deletion of the entire merit list
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_list"])) {
    $delete_sql = "DELETE FROM merit_list";
    if (mysqli_query($conn, $delete_sql)) {
        // Redirect back to the merit list page after deletion
        header("Location: view_merit.php");
        exit;
    } else {
        echo "Error deleting merit list: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Merit List Management</title>
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
            margin-bottom: 2rem;
        }
        .rank-badge {
            background: rgba(26, 35, 126, 0.1);
            color: #1a237e;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 600;
        }
        .top-rank {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .delete-btn {
            transition: all 0.3s ease;
        }
        .delete-btn:hover {
            transform: scale(1.05);
        }
        .student-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .student-avatar {
            width: 40px;
            height: 40px;
            background: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a237e;
        }
    </style>
</head>
<body class="bg-light">

<?php include('admin_navbar.php'); ?>

<div class="container py-4">
    <!-- Header Section -->
    <div class="dashboard-container">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="mb-1"><i class="fas fa-list-ol me-2"></i>Merit List Management</h2>
                <p class="text-muted mb-0">View and manage the merit list rankings</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button onclick="window.print()" class="btn btn-outline-primary me-2">
                    <i class="fas fa-print me-2"></i>Print List
                </button>
               
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Total Students</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users fa-2x me-3"></i>
                        <span class="h3 mb-0"><?php echo mysqli_num_rows($result); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Average Matric Marks</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-graduation-cap fa-2x me-3"></i>
                        <span class="h3 mb-0">
                            <?php 
                            $avg_matric = 0;
                            mysqli_data_seek($result, 0);
                            while($row = mysqli_fetch_assoc($result)) {
                                $avg_matric += $row['matric_marks'];
                            }
                            echo number_format($avg_matric/mysqli_num_rows($result), 2);
                            mysqli_data_seek($result, 0);
                            ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h3 class="h6 text-uppercase mb-2">Average Inter Marks</h3>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-school fa-2x me-3"></i>
                        <span class="h3 mb-0">
                            <?php 
                            $avg_inter = 0;
                            mysqli_data_seek($result, 0);
                            while($row = mysqli_fetch_assoc($result)) {
                                $avg_inter += $row['inter_marks'];
                            }
                            echo number_format($avg_inter/mysqli_num_rows($result), 2);
                            mysqli_data_seek($result, 0);
                            ?>%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Merit List Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-medal me-2"></i>Rank</th>
                        <th><i class="fas fa-user me-2"></i>Student Name</th>
                        <th><i class="fas fa-graduation-cap me-2"></i>Matric Marks</th>
                        <th><i class="fas fa-school me-2"></i>Inter Marks</th>
                        <th><i class="fas fa-calculator me-2"></i>Aggregate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rankClass = $rank <= 3 ? 'top-rank' : '';
                        $aggregate = ($row["matric_marks"] * 0.4) + ($row["inter_marks"] * 0.6); // 40% matric + 60% inter
                        ?>
                        <tr>
                            <td>
                                <span class="rank-badge <?php echo $rankClass; ?>">
                                    <?php if($rank <= 3): ?>
                                        <i class="fas fa-trophy me-1"></i>
                                    <?php endif; ?>
                                    #<?php echo $rank++; ?>
                                </span>
                            </td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <?php echo $row["student_name"]; ?>
                                </div>
                            </td>
                            <td><?php echo $row["matric_marks"]; ?>%</td>
                            <td><?php echo $row["inter_marks"]; ?>%</td>
                            <td><?php echo number_format($aggregate, 2); ?>%</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Delete Merit List Form -->
        <div class="text-center mt-4">
            <form method="post" onsubmit="return confirm('Are you sure you want to delete the entire merit list? This action cannot be undone.');">
                <button type="submit" class="btn btn-danger btn-lg delete-btn" name="delete_list">
                    <i class="fas fa-trash-alt me-2"></i>Delete Merit List
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>