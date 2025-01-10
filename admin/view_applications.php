<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Process form submission to update application status and remarks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $application_id = $_POST["application_id"];
    $status = $_POST["status"];
    $remarks = $_POST["remarks"];

    // Update application status and remarks in the database
    $sql = "UPDATE application SET status='$status', remarks='$remarks' WHERE id='$application_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Application status and remarks updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating application status and remarks: " . mysqli_error($conn) . "</div>";
    }
}

// Retrieve all user applications
$sql = "SELECT * FROM application";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Applications</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 500;
        }
        .status-submitted { background: #fff3cd; color: #856404; }
        .status-review { background: #cce5ff; color: #004085; }
        .status-accepted { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .action-form {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
        .table th {
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: white;
            white-space: nowrap;
        }
    </style>
</head>
<body class="bg-light">

<?php include('admin_navbar.php'); ?>

<div class="container py-5">
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-clipboard-list me-2"></i>All Applications</h2>
                <p class="text-muted mb-0">Manage and review student applications</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-2"></i>ID</th>
                        <th><i class="fas fa-user me-2"></i>Student Name</th>
                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                        <th><i class="fas fa-comments me-2"></i>Remarks</th>
                        <th><i class="fas fa-cogs me-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusClass = '';
                            switch(strtolower($row["status"])) {
                                case 'submitted': $statusClass = 'status-submitted'; break;
                                case 'under review': $statusClass = 'status-review'; break;
                                case 'accepted': $statusClass = 'status-accepted'; break;
                                case 'rejected': $statusClass = 'status-rejected'; break;
                            }
                            ?>
                            <tr>
                                <td>#<?php echo $row["id"]; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <?php echo $row["student_name"]; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($row["status"]); ?>
                                    </span>
                                </td>
                                <td><?php echo $row["remarks"]; ?></td>
                                <td>
                                    <div class="action-form">
                                        <form method="post">
                                            <input type="hidden" name="application_id" value="<?php echo $row["id"]; ?>">
                                            <select class="form-select mb-2" name="status">
                                                <option value="submitted">Submitted</option>
                                                <option value="under review">Under Review</option>
                                                <option value="accepted">Accepted</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                            <textarea class="form-control mb-2" name="remarks" placeholder="Enter remarks" rows="2"></textarea>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary" name="update_status">
                                                    <i class="fas fa-save me-2"></i>Update
                                                </button>
                                                <a href="view_details.php?id=<?php echo $row["id"]; ?>" class="btn btn-secondary">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center py-4">No applications found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>