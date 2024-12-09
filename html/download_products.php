<?php
// Include the database connection
include 'connect.php';

// Query to get all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Define the file name
$filename = "products_data_" . date("Y-m-d") . ".csv";

// Set the headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Column headings for the CSV file
fputcsv($output, array('Product ID', 'Name', 'Description', 'Price', 'Stock', 'Category', 'Created At', 'Updated At'));

// Fetch and write product data into the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
