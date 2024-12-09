<?php
// Start the session if not already started (to handle logout, etc.)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mueti Solutions - Admin</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ+Jc3QnC1+lSsczLeU8rfjIIjOSqtdlcayP3RZ4p5G51YoDaG9hksbp0TQX" crossorigin="anonymous">
    <!-- Include Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_nav.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Mueti Solutions</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Dashboard link -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <!-- Manage Users link -->
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">
                            <i class="fas fa-users-cog"></i> Manage Users
                        </a>
                    </li>

                    <!-- Manage Products link -->
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">
                            <i class="fas fa-cogs"></i> Manage Products
                        </a>
                    </li>

                    <!-- Orders link -->
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">
                            <i class="fas fa-box"></i> Orders
                        </a>
                    </li>

                    <!-- Records link -->
                    <li class="nav-item">
                        <a class="nav-link" href="records.php">
                            <i class="fas fa-clipboard-list"></i> Records
                        </a>
                    </li>

                    <!-- Admin Support link -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin_support.php">
                            <i class="fas fa-headset"></i> Admin Support
                        </a>
                    </li>

                    <!-- Logout link -->
                    <li class="nav-item">
    <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Include Bootstrap JS (Required for collapsible navbar functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq6dX9z7Xg3XwbAfUBZyYyEma9CRTk2b7mIhzfLtVoK9w" crossorigin="anonymous"></script>
</body>
</html>
