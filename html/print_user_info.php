<?php
// Include the database connection file
include 'connect.php';

// Check if the user_id is provided in the URL
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        // Redirect if no user found
        header('Location: manage_users.php?error=User not found');
        exit();
    }
} else {
    // Redirect if no user_id is provided
    header('Location: manage_users.php?error=Invalid user ID');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/print_user_info.css" rel="stylesheet"> <!-- Link to your custom CSS -->
</head>
<body>
    <!-- Header and Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="admin_dashboard.php">Mueti Solutions</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="records.php">Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_support.php">Admin Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- User Info Card -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">User Information</h4>
                    </div>
                    <div class="card-body">
                        <!-- User Details Table -->
                        <table class="table table-bordered">
                            <tr>
                                <th>First Name</th>
                                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                            </tr>
                        </table>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="manage_users.php" class="btn btn-secondary">Back to Users</a>
                            <a href="edit_user.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-warning">Edit User</a>
                            <a href="print_user_info.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-info" target="_blank">Print Info</a>
                            <a href="download_user_info.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-success">Download Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
