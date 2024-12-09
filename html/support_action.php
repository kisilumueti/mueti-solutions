<?php
// Include the database connection file
include 'connect.php';

// Check if the form was submitted
if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    // Get the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Check if the email exists in the users table
    $email_check_query = "SELECT * FROM users WHERE email = '$email'";
    $email_check_result = mysqli_query($conn, $email_check_query);

    if (mysqli_num_rows($email_check_result) > 0) {
        // Email exists, proceed with inserting the support message
        $insert_query = "INSERT INTO support_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

        if (mysqli_query($conn, $insert_query)) {
            // Message inserted successfully
            header('Location: support.php?success=Your message has been sent successfully.');
            exit();
        } else {
            // Error inserting the message
            header('Location: support.php?error=Error sending your message. Please try again.');
            exit();
        }
    } else {
        // Email doesn't exist in the users table
        header('Location: support.php?error=Your email is not registered. Please register first.');
        exit();
    }
} else {
    // Missing form data
    header('Location: support.php?error=Please fill in all fields.');
    exit();
}
?>
