<?php
include 'connect.php';

// Check if ID and status are passed
if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $status = $_GET['status'];

    // Update the order status in the database
    $query = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
    if (mysqli_query($conn, $query)) {
        // Redirect back to orders.php after updating
        header("Location: orders.php");
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
