<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if application ID is provided in the URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: admin_dashboard.php");
    exit;
}

// Get the application ID from the URL
$application_id = $_GET["id"];

// Retrieve application details
$sql = "SELECT * FROM application WHERE id = '$application_id'";
$result = mysqli_query($conn, $sql);

// Check if application exists
if (mysqli_num_rows($result) == 0) {
    echo "Application not found.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .details-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .info-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .info-header {
            color: #1a237e;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .info-item {
            display: flex;
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        .info-item:hover {
            transform: translateX(5px);
        }
        .info-label {
            min-width: 150px;
            font-weight: 500;
            color: #6c757d;
        }
        .info-value {
            flex: 1;
        }
        .transcript-link {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: #e3f2fd;
            color: #1a237e;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .transcript-link:hover {
            background: #1a237e;
            color: white;
        }
    </style>
</head>
<body class="bg-light">

<?php include('admin_navbar.php'); ?>

<div class="container py-5">
    <div class="details-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-file-alt me-2"></i>Application Details</h2>
                <p class="text-muted mb-0">Comprehensive view of the application</p>
            </div>
            <a href="view_applications.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Applications
            </a>
        </div>

        <!-- Personal Information -->
        <div class="info-section">
            <h3 class="info-header"><i class="fas fa-user me-2"></i>Personal Information</h3>
            <div class="info-item">
                <div class="info-label">Application ID</div>
                <div class="info-value">#<?php echo $row["id"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Student Name</div>
                <div class="info-value"><?php echo $row["student_name"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Father's Name</div>
                <div class="info-value"><?php echo $row["father_name"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value"><?php echo $row["email"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value"><?php echo $row["phone"]; ?></div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="info-section">
            <h3 class="info-header"><i class="fas fa-graduation-cap me-2"></i>Academic Information</h3>
            <div class="info-item">
                <div class="info-label">Program</div>
                <div class="info-value"><?php echo $row["program"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Degree</div>
                <div class="info-value"><?php echo $row["degree"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Session</div>
                <div class="info-value"><?php echo $row["session"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Matric Marks</div>
                <div class="info-value"><?php echo $row["matric_marks"]; ?>%</div>
            </div>
            <div class="info-item">
                <div class="info-label">Inter Marks</div>
                <div class="info-value"><?php echo $row["inter_marks"]; ?>%</div>
            </div>
            <div class="info-item">
                <div class="info-label">Previous Degree</div>
                <div class="info-value"><?php echo $row["previous_degree"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Previous Institution</div>
                <div class="info-value"><?php echo $row["previous_institution"]; ?></div>
            </div>
        </div>

        <!-- Application Status -->
        <div class="info-section">
            <h3 class="info-header"><i class="fas fa-clipboard-check me-2"></i>Application Status</h3>
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <?php 
                    $statusClass = '';
                    switch(strtolower($row["status"])) {
                        case 'submitted': $statusClass = 'status-submitted'; break;
                        case 'under review': $statusClass = 'status-review'; break;
                        case 'accepted': $statusClass = 'status-accepted'; break;
                        case 'rejected': $statusClass = 'status-rejected'; break;
                    }
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <?php echo ucfirst($row["status"]); ?>
                    </span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Application Date</div>
                <div class="info-value"><?php echo date('F j, Y', strtotime($row["application_date"])); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Remarks</div>
                <div class="info-value"><?php echo $row["remarks"]; ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Academic Transcript</div>
                <div class="info-value">
                    <a href="../transcript_files/<?php echo $row["academic_transcript"]; ?>" 
                       target="_blank" 
                       class="transcript-link">
                        <i class="fas fa-file-pdf me-2"></i>
                        View Academic Transcript
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>