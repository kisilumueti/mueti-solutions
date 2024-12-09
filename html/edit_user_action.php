<?php
// Include the database connection file
include 'connect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and sanitize
    $user_id = $_POST['user_id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // If password is provided, hash it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_update = ", password = '$hashed_password'";
    } else {
        $password_update = ''; // No password update
    }
    
    // Update user data in the database
    $update_query = "UPDATE users 
                     SET first_name = '$first_name', last_name = '$last_name', email = '$email', 
                         phone = '$phone', role = '$role' $password_update
                     WHERE user_id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        // Redirect with success message
        header('Location: manage_users.php?success=User updated successfully');
        exit();
    } else {
        // Redirect with error message
        header('Location: manage_users.php?error=Error updating user. Please try again.');
        exit();
    }
} else {
    // If not a POST request, redirect with error
    header('Location: manage_users.php?error=Invalid request.');
    exit();
}
?>
