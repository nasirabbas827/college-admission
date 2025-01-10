<?php
include('config.php');

// Check if the user is logged in as an admin
session_start();


// Retrieve the merit list data from the database
$sql = "SELECT * FROM merit_list ORDER BY matric_marks DESC, inter_marks DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Merit List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .merit-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(to right, #1a237e, #0d47a1);
            color: white;
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
    </style>
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="merit-card">
        <div class="p-4 text-center">
            <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
            <h2 class="mb-4">Merit List</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-header">
                    <tr>
                        <th class="px-4 py-3">
                            <i class="fas fa-medal me-2"></i>Rank
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-user me-2"></i>Student Name
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-graduation-cap me-2"></i>Matric Marks
                        </th>
                        <th class="px-4 py-3">
                            <i class="fas fa-school me-2"></i>Intermediate Marks
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rankClass = $rank <= 3 ? 'top-rank' : '';
                        echo "<tr>";
                        echo "<td class='px-4 py-3'><span class='rank-badge {$rankClass}'>#" . $rank++ . "</span></td>";
                        echo "<td class='px-4 py-3'>" . $row["student_name"] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row["matric_marks"] . "%</td>";
                        echo "<td class='px-4 py-3'>" . $row["inter_marks"] . "%</td>";
                        echo "</tr>";
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