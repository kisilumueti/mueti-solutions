<?php
include 'connect.php';

// Check if ID is passed
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Delete the order from the database
    $query = "DELETE FROM orders WHERE order_id = $order_id";
    if (mysqli_query($conn, $query)) {
        // Redirect back to orders.php after deleting
        header("Location: orders.php");
    } else {
        echo "Error deleting order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
