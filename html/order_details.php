<?php
// Include database connection
include 'connect.php';
include 'customer_nav.php';

// Check if the order_id is passed via GET method
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Query to get order details from orders table
    $order_query = "SELECT * FROM orders WHERE order_id = $order_id";
    $order_result = mysqli_query($conn, $order_query);

    // Check if the order exists
    if (mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);

        // Query to get products associated with this order
        $products_query = "SELECT p.name, op.quantity, p.price 
                           FROM order_products op
                           JOIN products p ON op.product_id = p.product_id
                           WHERE op.order_id = $order_id";
        $products_result = mysqli_query($conn, $products_query);
    } else {
        echo "Order not found.";
        exit();
    }
} else {
    echo "Invalid order ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="order_details.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Order Details - Order #<?= $order['order_id'] ?></h2>

    <!-- Order Summary Section -->
    <div class="row">
        <div class="col-md-6">
            <h4>Order Information</h4>
            <p><strong>Order Date:</strong> <?= date("d-m-Y H:i", strtotime($order['order_date'])) ?></p>
            <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
            <p><strong>Total Amount:</strong> KES <?= number_format($order['total_amount'], 2) ?></p>
            <p><strong>MPESA Transaction Number:</strong> <?= $order['mpesa_transaction_number'] ? $order['mpesa_transaction_number'] : 'Not Provided' ?></p>
        </div>
    </div>

    <!-- Products Ordered Section -->
    <h4>Products Ordered</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (KES)</th>
                <th>Total (KES)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($products_result) > 0): ?>
                <?php $total_price = 0; ?>
                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td>KES <?= number_format($product['price'], 2) ?></td>
                        <td>KES <?= number_format($product['price'] * $product['quantity'], 2) ?></td>
                    </tr>
                    <?php $total_price += $product['price'] * $product['quantity']; ?>
                <?php endwhile; ?>
                <tr>
                    <th colspan="4" class="text-right">Total Price</th>
                    <th>KES <?= number_format($total_price, 2) ?></th>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No products found in this order.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Action Buttons (If Order is Pending) -->
    <?php if ($order['status'] == 'pending'): ?>
        <div class="row">
            <div class="col-md-12">
                <a href="customer_orders.php" class="btn btn-primary">Back to My Orders</a>
                <a href="delete_order.php?order_id=<?= $order['order_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                    <i class="fas fa-trash-alt"></i> Delete Order
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
