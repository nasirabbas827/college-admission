<?php
include('config.php');

// define variables and initialize with empty values
$username = $password = $email = $phone = $age = "";
$username_err = $password_err = $email_err = $phone_err = $age_err = "";

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // check if username already exists in database
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = trim($_POST["username"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
        // check if email already exists in database
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "This email address is already taken.";
        }
    }

// Validate phone number
if (empty(trim($_POST["phone"]))) {
    $phone_err = "Please enter a phone number.";
} else {
    $phone = trim($_POST["phone"]);

    // Check if the phone number is exactly 11 digits and starts with '03'
    if (!preg_match('/^03[0-9]{9}$/', $phone)) {
        $phone_err = "Please enter a valid phone number (e.g., 03001234567).";
    } else {
        // Check if phone number already exists in the database
        $sql = "SELECT id FROM users WHERE phone = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_phone);
        $param_phone = $phone;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            $phone_err = "This phone number is already taken.";
        }
    }
}

    // validate age
    if (empty(trim($_POST["age"]))) {
        $age_err = "Please enter your age.";
    } elseif (!is_numeric($_POST["age"])) {
        $age_err = "Age must be a number.";
    } else {
        $age = trim($_POST["age"]);
        if ($age < 18) {
            $age_err = "You must be at least 18 years old to register.";
        }
    }

    // if no errors, insert user into database
    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($phone_err) && empty($age_err)) {
        $sql = "INSERT INTO users (username, password, email, phone, age) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $param_username, $param_password, $param_email, $param_phone, $param_age);
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_email = $email;
        $param_phone = $phone;
        $param_age = $age;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<div class="alert alert-success" role="alert">User registered successfully.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
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
    </style>
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-container">
                <h2 class="text-center mb-4">Create Account</h2>
                <p class="text-center text-muted mb-4">Please fill in your details to register</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row g-3">
                        <!-- Username -->
                        <div class="col-12 position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <div class="form-floating">
                                <input type="text" name="username" class="form-control ps-5 <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
                                       id="username" placeholder="Username" value="<?php echo $username; ?>">
                                <label for="username">Username</label>
                                <div class="invalid-feedback"><?php echo $username_err; ?></div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 position-relative">
                            <i class="fas fa-phone input-icon"></i>
                            <div class="form-floating">
                                <input type="tel" name="phone" class="form-control ps-5 <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" 
                                       id="phone" placeholder="Phone" value="<?php echo $phone; ?>">
                                <label for="phone">Phone Number</label>
                                <div class="invalid-feedback"><?php echo $phone_err; ?></div>
                            </div>
                        </div>

                        <!-- Age -->
                        <div class="col-md-6 position-relative">
                            <i class="fas fa-birthday-cake input-icon"></i>
                            <div class="form-floating">
                                <input type="number" name="age" class="form-control ps-5 <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" 
                                       id="age" placeholder="Age" value="<?php echo $age; ?>">
                                <label for="age">Age</label>
                                <div class="invalid-feedback"><?php echo $age_err; ?></div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12 position-relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control ps-5 <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                                       id="email" placeholder="Email" value="<?php echo $email; ?>">
                                <label for="email">Email Address</label>
                                <div class="invalid-feedback"><?php echo $email_err; ?></div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-12 position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control ps-5 <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                                       id="password" placeholder="Password" value="<?php echo $password; ?>">
                                <label for="password">Password</label>
                                <div class="invalid-feedback"><?php echo $password_err; ?></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-user-plus me-2"></i>Register Now
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">Already have an account? 
                        <a href="login.php" class="text-primary text-decoration-none">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>