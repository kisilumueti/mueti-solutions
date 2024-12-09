<?php
// Include the database connection
include 'connect.php';

// Query to get all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Define the file name
$filename = "users_data_" . date("Y-m-d") . ".csv";

// Set the headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Column headings for the CSV file
fputcsv($output, array('User ID', 'Email', 'First Name', 'Last Name', 'Phone Number', 'Role', 'Created At'));

// Fetch and write user data into the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
