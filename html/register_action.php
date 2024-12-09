<?php
// Include the database connection file
include 'connect.php';

// Get form data from the POST request
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

// Check if email already exists
$email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$email_check_result = mysqli_query($conn, $email_check_query);
$email_check = mysqli_fetch_assoc($email_check_result);

if ($email_check) {
    // Email already exists
    header('Location: register.php?error=Email already exists');
    exit();
}

// Insert user data into the database
$password_hash = $password;  // We're using plain text for simplicity, but in production, it's highly recommended to hash passwords
$insert_query = "INSERT INTO users (first_name, last_name, email, password, phone, role) 
                 VALUES ('$first_name', '$last_name', '$email', '$password_hash', '$phone', '$role')";

if (mysqli_query($conn, $insert_query)) {
    // Registration successful
    header('Location: login.php?success=Registration successful! Please login.');
    exit();
} else {
    // Registration failed
    header('Location: register.php?error=Registration failed. Please try again.');
    exit();
}
?>
