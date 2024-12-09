
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/register.css">
    <title>Mueti Solutions - Navigation</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-building"></i> Mueti Solutions</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])) { // If user is logged in ?>
                        <!-- Display "Logout" option if the user is logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                        </li>
                        <!-- Display the user role or name if needed -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-user"></i> <?php echo $_SESSION['email']; ?>
                            </a>
                        </li>
                    <?php } else { // If user is not logged in ?>
                        <!-- Display login and register links if the user is not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php"><i class="fa-solid fa-user-plus"></i> Register</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" href="reset.php"><i class="fa-solid fa-key"></i> Reset Password</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
