<?php
// Include the database connection and other necessary files
include 'connect.php';
include 'customer_nav.php';

// Retrieve the user_id from the session or GET (for demo, using a hardcoded value)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Replace with actual user session ID

// Fetch orders for the logged-in user
$order_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$order_result = mysqli_query($conn, $order_query);

// Handle order deletion
if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];
    $order_check_query = "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id";
    $order_check_result = mysqli_query($conn, $order_check_query);
    if (mysqli_num_rows($order_check_result) > 0) {
        $delete_order_query = "DELETE FROM orders WHERE order_id = $order_id";
        mysqli_query($conn, $delete_order_query);
        header('Location: customer_orders.php');
        exit();
    } else {
        echo "Error: Order does not belong to you or cannot be deleted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="customer_orders.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">My Orders</h2>

    <!-- Orders Table -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Order Date</th>
                <th>Total Amount (KES)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($order_result) > 0): ?>
                <?php while ($order = mysqli_fetch_assoc($order_result)): ?>
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= date("d-m-Y H:i", strtotime($order['order_date'])) ?></td>
                        <td>KES <?= number_format($order['total_amount'], 2) ?></td>
                        <td><?= ucfirst($order['status']) ?></td>
                        <td>
                            <!-- View Order Details Button -->
                            <a href="order_details.php?order_id=<?= $order['order_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            


                            <!-- Delete Order Button (Only if Status is Pending) -->
                            <?php if ($order['status'] == 'pending'): ?>
                                <a href="customer_orders.php?delete=<?= $order['order_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
