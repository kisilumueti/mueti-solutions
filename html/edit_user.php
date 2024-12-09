<?php
// Include the database connection file
include 'connect.php';

// Check if user_id is provided
if (!isset($_GET['user_id'])) {
    header('Location: manage_users.php?error=User ID not provided');
    exit();
}

// Get the user_id from the URL parameter
$user_id = $_GET['user_id'];

// Fetch the user data from the database
$query_user = "SELECT * FROM users WHERE user_id = $user_id";
$result_user = mysqli_query($conn, $query_user);

// Check if the user exists
if (mysqli_num_rows($result_user) == 0) {
    header('Location: manage_users.php?error=User not found');
    exit();
}

// Get the user data from the query result
$user_data = mysqli_fetch_assoc($result_user);

// Assign user data to variables for form population
$first_name = $user_data['first_name'];
$last_name = $user_data['last_name'];
$email = $user_data['email'];
$phone = $user_data['phone'];
$role = $user_data['role'];

?>

<!-- HTML Form to Edit User Information -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/manage_user.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Edit User</title>
</head>
<body>
    <div class="container py-5">
        <h3>Edit User: <?= $first_name . ' ' . $last_name ?></h3>
        <form method="POST" action="edit_user_action.php" class="mt-4">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="customer" <?= $role == 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep unchanged)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
        <div class="mt-3">
            <a href="manage_users.php" class="btn btn-secondary">Back to Users List</a>
        </div>
    </div>
</body>
</html>
