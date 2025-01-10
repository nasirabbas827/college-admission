<?php
include('config.php');
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

$user_id = $_SESSION["id"];

// Fetch user details from the database
$userQuery = "SELECT username, email, phone FROM users WHERE id='$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

// Assign user details to variables
$student_name = $userData["username"];
$email = $userData["email"];
$phone = $userData["phone"];

// Initialize other variables
$program = $degree = $session = $matric_marks = $inter_marks = $previous_degree = $previous_institution = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $program = $_POST["program"];
    $degree = $_POST["degree"];
    $session = $_POST["session"];
    $application_date = date("Y-m-d"); // Current date
    $status = "submitted"; // Default status
    $matric_marks = $_POST["matric_marks"];
    $inter_marks = $_POST["inter_marks"];
    $previous_degree = $_POST["previous_degree"];
    $previous_institution = $_POST["previous_institution"];

    // Validate marks and session year
    if ($matric_marks < 0 || $inter_marks < 0) {
        echo "Marks cannot be negative.";
        exit;
    }
    if (!in_array($session, ['2024', '2025', '2026'])) {
        echo "Invalid session year.";
        exit;
    }

    // Process file upload (PDF file only)
    if (isset($_FILES['transcript']) && $_FILES['transcript']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['transcript']['name'];
        $file_tmp = $_FILES['transcript']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check if the uploaded file is a PDF
        if ($file_ext == 'pdf') {
            move_uploaded_file($file_tmp, "transcript_files/" . $file_name); // Save file to the desired directory
        } else {
            echo "Only PDF files are allowed.";
            exit;
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO application (user_id, student_name, father_name, email, phone, program, degree, session, application_date, status, matric_marks, inter_marks, academic_transcript, previous_degree, previous_institution) 
            VALUES ('$user_id', '$student_name', '$_POST[father_name]', '$email', '$phone', '$program', '$degree', '$session', '$application_date', '$status', '$matric_marks', '$inter_marks', '$file_name', '$previous_degree', '$previous_institution')";

    if (mysqli_query($conn, $sql)) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Application Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .form-floating > label {
            padding-left: 40px;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 2;
        }
        .readonly-field {
            background-color: #f8f9fa !important;
        }
    </style>
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="form-container">
        <div class="text-center mb-4">
            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
            <h2>Application Form</h2>
            <p class="text-muted">Please fill in your application details carefully</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Student Name -->
                    <div class="position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5 readonly-field" id="student_name" name="student_name" 
                                   value="<?php echo htmlspecialchars($student_name); ?>" readonly>
                            <label for="student_name">Student Name</label>
                        </div>
                    </div>

                    <!-- Father's Name -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-user-tie input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5" id="father_name" name="father_name" required>
                            <label for="father_name">Father's Name</label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-envelope input-icon"></i>
                        <div class="form-floating">
                            <input type="email" class="form-control ps-5 readonly-field" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($email); ?>" readonly>
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-phone input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5 readonly-field" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($phone); ?>" readonly>
                            <label for="phone">Phone</label>
                        </div>
                    </div>

                    <!-- Program -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-book input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5" id="program" name="program" required>
                            <label for="program">Program</label>
                        </div>
                    </div>

                    <!-- Degree -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-university input-icon"></i>
                        <div class="form-floating">
                            <select class="form-select ps-5" id="degree" name="degree" required>
                                <option value="BSCS">BSCS</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BSSE">BSSE</option>
                            </select>
                            <label for="degree">Degree</label>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Session -->
                    <div class="position-relative">
                        <i class="fas fa-calendar input-icon"></i>
                        <div class="form-floating">
                            <select class="form-select ps-5" id="session" name="session" required>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                            <label for="session">Session</label>
                        </div>
                    </div>

                    <!-- Matric Marks -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-percentage input-icon"></i>
                        <div class="form-floating">
                            <input type="number" step="0.01" class="form-control ps-5" id="matric_marks" name="matric_marks" required>
                            <label for="matric_marks">Matric Marks</label>
                        </div>
                    </div>

                    <!-- Inter Marks -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-percentage input-icon"></i>
                        <div class="form-floating">
                            <input type="number" step="0.01" class="form-control ps-5" id="inter_marks" name="inter_marks" required>
                            <label for="inter_marks">Intermediate Marks</label>
                        </div>
                    </div>

                    <!-- Previous Degree -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-graduation-cap input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5" id="previous_degree" name="previous_degree">
                            <label for="previous_degree">Previous Degree</label>
                        </div>
                    </div>

                    <!-- Previous Institution -->
                    <div class="position-relative mt-3">
                        <i class="fas fa-school input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control ps-5" id="previous_institution" name="previous_institution">
                            <label for="previous_institution">Previous Institution</label>
                        </div>
                    </div>

                    <!-- Academic Transcript -->
                    <div class="mt-3">
                        <label class="form-label"><i class="fas fa-file-pdf me-2"></i>Academic Transcript (PDF only)</label>
                        <input type="file" class="form-control" id="academic_transcript" name="transcript" required accept=".pdf">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function validateForm() {
        const matricMarks = document.getElementById('matric_marks').value;
        const interMarks = document.getElementById('inter_marks').value;
        const session = document.getElementById('session').value;

        if (matricMarks < 0 || interMarks < 0) {
            alert("Marks cannot be negative.");
            return false;
        }

        if (!['2024', '2025', '2026'].includes(session)) {
            alert("Invalid session year.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>