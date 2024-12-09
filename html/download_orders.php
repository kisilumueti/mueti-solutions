<?php
// Include the database connection
include 'connect.php';

// Query to get all orders
$query = "SELECT o.order_id, u.email, p.name as product_name, o.amount, o.created_at 
          FROM sales o 
          JOIN users u ON o.user_id = u.user_id
          JOIN products p ON o.product_id = p.product_id";
$result = mysqli_query($conn, $query);

// Define the file name
$filename = "orders_data_" . date("Y-m-d") . ".csv";

// Set the headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Column headings for the CSV file
fputcsv($output, array('Order ID', 'User Email', 'Product Name', 'Amount', 'Order Date'));

// Fetch and write order data into the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
