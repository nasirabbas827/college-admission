<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Retrieve application status for the logged-in user
$sql = "SELECT * FROM application WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .status-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(to right, #1a237e, #0d47a1);
            color: white;
        }
        .status-pending { color: #f59e0b; }
        .status-approved { color: #10b981; }
        .status-rejected { color: #ef4444; }
    </style>
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="status-card">
        <div class="p-4 text-center">
            <i class="fas fa-clipboard-check fa-3x text-primary mb-3"></i>
            <h2 class="mb-4">Application Status</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-header">
                    <tr>
                        <th class="px-4 py-3">
                            <i class="fas fa-hashtag me-2"></i>Application ID
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-user me-2"></i>Student Name
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-info-circle me-2"></i>Status
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-comments me-2"></i>Remarks
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusClass = '';
                            $statusIcon = '';
                            
                            switch(strtolower($row["status"])) {
                                case 'pending':
                                    $statusClass = 'status-pending';
                                    $statusIcon = 'clock';
                                    break;
                                case 'approved':
                                    $statusClass = 'status-approved';
                                    $statusIcon = 'check-circle';
                                    break;
                                case 'rejected':
                                    $statusClass = 'status-rejected';
                                    $statusIcon = 'times-circle';
                                    break;
                            }
                            
                            echo "<tr>";
                            echo "<td class='px-4 py-3'>#" . $row["id"] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row["student_name"] . "</td>";
                            echo "<td class='px-4 py-3'><i class='fas fa-{$statusIcon} me-2 {$statusClass}'></i>" . $row["status"] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row["remarks"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4'>No applications found.</td></tr>";
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