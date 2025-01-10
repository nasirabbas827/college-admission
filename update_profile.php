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

// Fetch user details from the database
$sql = "SELECT id, username, email, age, phone FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fetched_id, $username, $email, $age, $phone);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Initialize error variables
$email_err = $phone_err = $age_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["username"];
    $newEmail = $_POST["email"];
    $newAge = $_POST["age"];
    $newPhone = $_POST["phone"];

    // Validate email
    if (empty(trim($newEmail))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($newEmail);
        $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $param_email, $user_id);
        $param_email = $email;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $email_err = "This email address is already taken.";
        }
        mysqli_stmt_close($stmt);
    }

    // Validate phone number
    if (empty(trim($newPhone))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($newPhone);
        // Check if the phone number is exactly 11 digits and starts with '03'
        if (!preg_match('/^03[0-9]{9}$/', $phone)) {
            $phone_err = "Please enter a valid phone number (e.g., 03001234567).";
        } else {
            $sql = "SELECT id FROM users WHERE phone = ? AND id != ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "si", $param_phone, $user_id);
            $param_phone = $phone;
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $phone_err = "This phone number is already taken.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate age
    if (empty(trim($newAge))) {
        $age_err = "Please enter your age.";
    } elseif (!is_numeric($newAge)) {
        $age_err = "Age must be a number.";
    } else {
        $age = trim($newAge);
        if ($age < 18) {
            $age_err = "You must be at least 18 years old to register.";
        }
    }

    // If no errors, update user profile
    if (empty($email_err) && empty($phone_err) && empty($age_err)) {
        $update_query = "UPDATE users 
                         SET username = ?, email = ?, age = ?, phone = ? 
                         WHERE id = ?";
        
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "ssisi", $newUsername, $newEmail, $newAge, $newPhone, $user_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo "Profile updated successfully!";
            // Update session data if needed
            $_SESSION["username"] = $newUsername;
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }

        mysqli_stmt_close($update_stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
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
            max-width: 600px;
            margin: 0 auto;
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
    </style>
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="form-container">
        <div class="text-center mb-4">
            <i class="fas fa-user-edit fa-3x text-primary mb-3"></i>
            <h2>Update Profile</h2>
            <p class="text-muted">Update your personal information</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Username -->
            <div class="position-relative mb-4">
                <i class="fas fa-user input-icon"></i>
                <div class="form-floating">
                    <input type="text" class="form-control ps-5" name="username" id="username" 
                           value="<?php echo $username; ?>" required>
                    <label for="username">Username</label>
                </div>
            </div>

            <!-- Email -->
            <div class="position-relative mb-4">
                <i class="fas fa-envelope input-icon"></i>
                <div class="form-floating">
                    <input type="email" class="form-control ps-5 <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                           name="email" id="email" value="<?php echo $email; ?>" required>
                    <label for="email">Email</label>
                    <?php if (!empty($email_err)): ?>
                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Age -->
            <div class="position-relative mb-4">
                <i class="fas fa-birthday-cake input-icon"></i>
                <div class="form-floating">
                    <input type="number" class="form-control ps-5 <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" 
                           name="age" id="age" value="<?php echo $age; ?>" required>
                    <label for="age">Age</label>
                    <?php if (!empty($age_err)): ?>
                        <div class="invalid-feedback"><?php echo $age_err; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Phone -->
            <div class="position-relative mb-4">
                <i class="fas fa-phone input-icon"></i>
                <div class="form-floating">
                    <input type="text" class="form-control ps-5 <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" 
                           name="phone" id="phone" value="<?php echo $phone; ?>" required>
                    <label for="phone">Phone Number</label>
                    <?php if (!empty($phone_err)): ?>
                        <div class="invalid-feedback"><?php echo $phone_err; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-save me-2"></i>Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>