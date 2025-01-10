<?php
include('config.php');

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Define default minimum marks for matric and inter
$min_matric_marks = 00;
$min_inter_marks = 00;

// Process form submission to set minimum marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_min_marks"])) {
    $min_matric_marks = $_POST["min_matric_marks"];
    $min_inter_marks = $_POST["min_inter_marks"];
}

// Retrieve applicants who have scored equal to or above the defined minimum marks
$sql = "SELECT * FROM application 
        WHERE matric_marks >= $min_matric_marks 
        AND inter_marks >= $min_inter_marks 
        ORDER BY matric_marks DESC, inter_marks DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Merit List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .merit-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .criteria-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }
        .table th {
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: white;
            white-space: nowrap;
        }
        .rank-badge {
            background: rgba(26, 35, 126, 0.1);
            color: #1a237e;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
        }
        .top-rank {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
        .marks-input {
            position: relative;
        }
        .marks-input .form-control {
            padding-left: 40px;
        }
        .marks-input i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">

<?php include('admin_navbar.php'); ?>

<div class="container py-5">
    <div class="merit-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-list-ol me-2"></i>Generate Merit List</h2>
                <p class="text-muted mb-0">Set criteria and generate merit list for admissions</p>
            </div>
        </div>

        <!-- Minimum Marks Criteria -->
        <div class="criteria-card mb-4">
            <h5 class="mb-4"><i class="fas fa-filter me-2"></i>Set Minimum Criteria</h5>
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <div class="marks-input">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="min_matric_marks" 
                                   name="min_matric_marks" value="<?php echo $min_matric_marks; ?>" 
                                   placeholder="Minimum Matric Marks" required>
                            <label for="min_matric_marks">Minimum Matric Marks (%)</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="marks-input">
                        <i class="fas fa-school"></i>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="min_inter_marks" 
                                   name="min_inter_marks" value="<?php echo $min_inter_marks; ?>" 
                                   placeholder="Minimum Intermediate Marks" required>
                            <label for="min_inter_marks">Minimum Intermediate Marks (%)</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="set_min_marks">
                        <i class="fas fa-check me-2"></i>Set Minimum Marks
                    </button>
                </div>
            </form>
        </div>

        <!-- Merit List Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th><i class="fas fa-medal me-2"></i>Rank</th>
                        <th><i class="fas fa-user me-2"></i>Student Name</th>
                        <th><i class="fas fa-graduation-cap me-2"></i>Matric Marks</th>
                        <th><i class="fas fa-school me-2"></i>Intermediate Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rankClass = $rank <= 3 ? 'top-rank' : '';
                        echo "<tr>";
                        echo "<td><span class='rank-badge {$rankClass}'>#" . $rank++ . "</span></td>";
                        echo "<td>" . $row["student_name"] . "</td>";
                        echo "<td>" . $row["matric_marks"] . "%</td>";
                        echo "<td>" . $row["inter_marks"] . "%</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Post Merit List Form -->
        <div class="text-center mt-4">
            <form method="post" action="post_merit_list.php">
                <input type="hidden" name="min_matric_marks" value="<?php echo $min_matric_marks; ?>">
                <input type="hidden" name="min_inter_marks" value="<?php echo $min_inter_marks; ?>">
                <button type="submit" class="btn btn-success btn-lg" name="post_merit_list">
                    <i class="fas fa-share-square me-2"></i>Post Merit List
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>