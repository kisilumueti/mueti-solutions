<?php
// Include the database connection file
include 'connect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Encrypt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email already exists in the database
    $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $email_check_result = mysqli_query($conn, $email_check_query);
    
    if (mysqli_num_rows($email_check_result) > 0) {
        // Email already exists
        header('Location: manage_users.php?error=Email already exists');
        exit();
    }

    // Insert user data into the database
    $insert_query = "INSERT INTO users (first_name, last_name, email, phone, role, password) 
                     VALUES ('$first_name', '$last_name', '$email', '$phone', '$role', '$hashed_password')";
    
    if (mysqli_query($conn, $insert_query)) {
        // Successful insert, redirect with success message
        header('Location: manage_users.php?success=User added successfully');
        exit();
    } else {
        // Error occurred during insertion
        header('Location: manage_users.php?error=Error adding user. Please try again.');
        exit();
    }
} else {
    // If not a POST request, redirect with error
    header('Location: manage_users.php?error=Invalid request.');
    exit();
}
