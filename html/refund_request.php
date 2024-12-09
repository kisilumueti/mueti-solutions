<?php
// Include the database connection and other necessary files
include 'connect.php';
include 'customer_nav.php';

// Retrieve the user_id from the session or GET (for demo, using a hardcoded value)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Replace with actual user session ID

// Handle refund request
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Check if the order belongs to the current user and is in 'pending' status
    $order_check_query = "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id AND status = 'pending'";
    $order_check_result = mysqli_query($conn, $order_check_query);

    if (mysqli_num_rows($order_check_result) > 0) {
        // Update the order status to 'refund_pending'
        $update_status_query = "UPDATE orders SET status = 'refund_pending' WHERE order_id = $order_id";
        if (mysqli_query($conn, $update_status_query)) {
            echo "<div class='alert alert-success'>Your refund request has been submitted. Please be patient as the admin processes it.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: Could not submit refund request. Please try again later.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error: This order is either not yours or cannot be refunded.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No order specified for refund request.</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Refund - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="customer_orders.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Request Refund</h2>

    <p class="text-center">Your refund request has been submitted successfully. Please wait for the admin to process it. You will be notified once it's complete.</p>

    <a href="customer_orders.php" class="btn btn-primary btn-lg d-block mx-auto">Back to Orders</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
