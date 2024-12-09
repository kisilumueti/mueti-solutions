<?php
// Include the database connection file
include 'connect.php';

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    // Check if the email exists in the database
    $check_user_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $check_user_result = mysqli_query($conn, $check_user_query);
    
    if (mysqli_num_rows($check_user_result) > 0) {
        // Email found, update the password
        $update_password_query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
        
        if (mysqli_query($conn, $update_password_query)) {
            // Password updated successfully
            header('Location: login.php?success=Password reset successful. Please login.');
            exit();
        } else {
            // Error updating the password
            header('Location: reset.php?error=Error resetting password. Please try again.');
            exit();
        }
    } else {
        // Email not found
        header('Location: reset.php?error=Email not found.');
        exit();
    }
}
?>

<?php include 'reg_nav.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/reset.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Reset Password - Mueti Solutions</title>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Reset Password</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display error or success message -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
                        <?php elseif (isset($_GET['success'])): ?>
                            <div class="alert alert-success"><?= $_GET['success'] ?></div>
                        <?php endif; ?>
                        
                        <!-- Reset Password Form -->
                        <form method="POST" action="reset.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100">Reset Password</button>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <a href="login.php">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
