<?php
// Start output buffering to avoid header issues
ob_start();

// Include the database connection and other necessary files
include 'connect.php';
include 'customer_nav.php';

// Retrieve the checkout_id passed in the URL
$checkout_id = isset($_GET['checkout_id']) ? $_GET['checkout_id'] : 0;

// Check if the checkout_id exists in the checkout table
if ($checkout_id) {
    $query = "SELECT total_amount, user_id FROM checkout WHERE checkout_id = $checkout_id";
    $result = mysqli_query($conn, $query);
    $checkout_data = mysqli_fetch_assoc($result);
    if ($checkout_data) {
        $total_amount = $checkout_data['total_amount'];
        $user_id = $checkout_data['user_id'];
    } else {
        echo "Invalid checkout ID.";
        exit();
    }
} else {
    echo "Invalid checkout ID.";
    exit();
}

// Handle the Mpesa transaction form submission
if (isset($_POST['submit_payment'])) {
    $mpesa_transaction_number = $_POST['mpesa_transaction_number'];

    // Validate Mpesa transaction number (example of simple validation)
    if (!preg_match("/^(\d{9,10})$/", $mpesa_transaction_number)) {
        echo "Invalid Mpesa transaction number. Please try again.";
        exit();
    } else {
        // Insert the order into the orders table
        $order_query = "INSERT INTO orders (user_id, total_amount, order_date, mpesa_transaction_number, status)
                        VALUES ($user_id, $total_amount, NOW(), '$mpesa_transaction_number', 'pending')";
        
        if (mysqli_query($conn, $order_query)) {
            // Get the inserted order ID
            $order_id = mysqli_insert_id($conn);

            // Debugging step: Check if the order_id is correct
            if ($order_id > 0) {
                // Clear the cart after order placement
                $clear_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
                mysqli_query($conn, $clear_cart_query);

                // Redirect to the delivery address page after successful payment
                header('Location: delivery_address.php?order_id=' . $order_id); 
                exit(); // Ensure no further code is executed
            } else {
                echo "Error: Order ID not returned after insert.";
                exit();
            }
        } else {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="billing.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Billing</h2>

    <!-- Display Till Number -->
    <div class="alert alert-info text-center" style="font-size: 24px;">
        Till Number: <strong>402137</strong>
    </div>

    <!-- Display Total Amount -->
    <div class="alert alert-success text-center" style="font-size: 20px;">
        Total Amount: KES <?= number_format($total_amount, 2) ?>
    </div>

    <!-- Mpesa Payment Form -->
    <form action="billing.php?checkout_id=<?= $checkout_id ?>" method="POST">
        <div class="form-group">
            <label for="mpesa_transaction_number">Mpesa Transaction Number</label>
            <input type="text" class="form-control" id="mpesa_transaction_number" name="mpesa_transaction_number" placeholder="Enter Mpesa Transaction Number" required>
        </div>

        <div class="form-group text-center">
            <button type="submit" name="submit_payment" class="btn btn-primary btn-lg">Submit Payment</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// End output buffering
ob_end_flush();
?>
