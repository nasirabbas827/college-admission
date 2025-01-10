<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <i class="fas fa-graduation-cap me-2"></i>CAMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
                    echo '<li class="nav-item"><a class="nav-link" href="home.php"><i class="fas fa-home me-1"></i>Home</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="update_profile.php"><i class="fas fa-user-edit me-1"></i>Update Profile</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_application.php"><i class="fas fa-file-alt me-1"></i>Application Status</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="merit_list.php"><i class="fas fa-list-ol me-1"></i>View Merit List</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="merit_list.php"><i class="fas fa-list-ol me-1"></i>View Merit List</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php"><i class="fas fa-user-plus me-1"></i>Register</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="./admin/admin_login.php"><i class="fas fa-user-shield me-1"></i>Admin Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>