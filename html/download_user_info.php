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

        // Prepare the user data to be downloaded as a text file
        $user_data = "User Information:\n\n";
        $user_data .= "First Name: " . $user['first_name'] . "\n";
        $user_data .= "Last Name: " . $user['last_name'] . "\n";
        $user_data .= "Email: " . $user['email'] . "\n";
        $user_data .= "Phone: " . $user['phone'] . "\n";
        $user_data .= "Role: " . $user['role'] . "\n";
        $user_data .= "Created At: " . date('Y-m-d H:i:s', strtotime($user['created_at'])) . "\n";

        // Set headers to download the file
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="user_' . $user_id . '_info.txt"');

        // Output the user data to the file
        echo $user_data;
        exit();
    } else {
        // If user not found, redirect with an error message
        header('Location: manage_users.php?error=User not found');
        exit();
    }
} else {
    // If no user_id is provided, redirect with an error message
    header('Location: manage_users.php?error=Invalid user ID');
    exit();
}
