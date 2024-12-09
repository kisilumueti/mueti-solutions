<?php
// Start output buffering
ob_start();

// Include the database connection and other necessary files
include 'connect.php';
include 'customer_nav.php';

// Retrieve the order_id from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// Check if the order_id is valid
if (!$order_id) {
    echo "Invalid order ID.";
    exit();
}

// Fetch order details (for confirmation)
$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Handle delivery address form submission
if (isset($_POST['submit_address'])) {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $landmark = mysqli_real_escape_string($conn, $_POST['landmark']);

    // Insert the delivery address into the delivery_addresses table
    $insert_address_query = "INSERT INTO delivery_addresses (order_id, address, landmark) 
                             VALUES ($order_id, '$address', '$landmark')";
    if (mysqli_query($conn, $insert_address_query)) {
        // Update the order status to 'completed'
        $update_order_query = "UPDATE orders SET status = 'completed' WHERE order_id = $order_id";
        mysqli_query($conn, $update_order_query);

        // Redirect to the dashboard after completion
        header('Location: customer_dashboard.php');
        exit();
    } else {
        echo "Error saving delivery address: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Address - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="billing.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Delivery Address</h2>

    <!-- Display Order Summary -->
    <div class="alert alert-info">
        <p><strong>Order ID:</strong> <?= $order_data['order_id'] ?></p>
        <p><strong>Total Amount:</strong> KES <?= number_format($order_data['total_amount'], 2) ?></p>
        <p><strong>Mpesa Transaction Number:</strong> <?= $order_data['mpesa_transaction_number'] ?></p>
    </div>

    <!-- Delivery Address Form -->
    <form action="delivery_address.php?order_id=<?= $order_id ?>" method="POST">
        <div class="form-group">
            <label for="address">Delivery Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your delivery address" required></textarea>
        </div>

        <div class="form-group">
            <label for="landmark">Best Landmark</label>
            <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Enter your landmark" required>
        </div>

        <div class="form-group text-center">
            <button type="submit" name="submit_address" class="btn btn-primary btn-lg">Submit Address</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// End output buffering and flush output
ob_end_flush();
?>
