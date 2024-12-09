<?php
// Include the database connection
include 'connect.php';

// Initialize order variable
$order = null;

// Fetch the order to edit (assuming a single product per order)
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the orders table
    $order_query = "SELECT orders.*, order_items.*, products.name as product_name, products.price as product_price 
                    FROM orders 
                    JOIN order_items ON orders.order_id = order_items.order_id 
                    JOIN products ON order_items.product_id = products.product_id 
                    WHERE orders.order_id = $order_id";
    $order_result = mysqli_query($conn, $order_query);

    if (mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);
    } else {
        echo "No orders found.";
    }
}

// Handle order update (when form is submitted)
if (isset($_POST['update_order'])) {
    // Get the updated order details
    $order_id = $_POST['order_id'];
    $new_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    
    if ($order) {
        $product_id = $order['product_id']; // Get the product_id from the order details

        // Fetch the product details to get the price
        $product_query = "SELECT * FROM products WHERE product_id = $product_id";
        $product_result = mysqli_query($conn, $product_query);
        $product = mysqli_fetch_assoc($product_result);
        $product_price = $product['price']; // Assume the price is stored in the 'price' column

        // Calculate the total price based on the new quantity
        $total_price = $new_quantity * $product_price;

        // Update the order in the order_items table and orders table
        $update_query = "UPDATE order_items SET quantity = $new_quantity WHERE order_id = $order_id AND product_id = $product_id";
        $order_update_query = "UPDATE orders SET total_amount = $total_price WHERE order_id = $order_id";
        
        if (mysqli_query($conn, $update_query) && mysqli_query($conn, $order_update_query)) {
            $update_message = "Amount settled during delivery.";
        } else {
            echo "Error updating order. Please try again.";
        }
    } else {
        echo "Order details could not be fetched.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Edit Order</h2>

    <!-- Display the current order details if available -->
    <?php if ($order): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><?= isset($order['product_name']) ? $order['product_name'] : 'Product Name' ?></h5>
                <p class="card-text">Current Quantity: <?= isset($order['quantity']) ? $order['quantity'] : 0 ?></p>
                <p class="card-text">Price per Item: KES <?= isset($order['product_price']) ? number_format($order['product_price'], 2) : '0.00' ?></p>
                <p class="card-text">Total Price: KES <?= isset($order['total_amount']) ? number_format($order['total_amount'], 2) : '0.00' ?></p>
            </div>
        </div>

        <!-- Edit Order Form -->
        <form action="edit_order.php" method="POST">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

            <div class="form-group">
                <label for="quantity">Update Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= isset($order['quantity']) ? $order['quantity'] : 1 ?>" min="1" required>
            </div>

            <button type="submit" name="update_order" class="btn btn-success btn-block">Update Order</button>
        </form>

        <!-- Messages after updating order -->
        <?php if (isset($update_message)): ?>
            <div class="alert alert-success mt-4">
                <?= $update_message ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>No order found to edit.</p>
    <?php endif; ?>

    <a href="customer_orders.php" class="btn btn-secondary btn-block mt-3">Back to Orders</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
