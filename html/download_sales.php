<?php
// Include the database connection
include 'connect.php';

// Query to get all sales data
$query = "SELECT s.sales_id, p.name as product_name, s.amount, s.created_at 
          FROM sales s 
          JOIN products p ON s.product_id = p.product_id";
$result = mysqli_query($conn, $query);

// Define the file name
$filename = "sales_data_" . date("Y-m-d") . ".csv";

// Set the headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Column headings for the CSV file
fputcsv($output, array('Sales ID', 'Product Name', 'Amount', 'Sales Date'));

// Fetch and write sales data into the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
