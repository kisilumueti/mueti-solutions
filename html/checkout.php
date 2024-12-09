<?php
// Start output buffering
ob_start();

// Include database connection and other necessary files
include 'connect.php';
include 'customer_nav.php';

// For now, we assume that the user_id is directly passed (e.g., hardcoded or via URL parameter)
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 1; // You can replace this with the actual user ID mechanism.

// Fetch cart items for the user (no session check now)
$query = "SELECT c.cart_id, c.product_id, c.quantity, p.name, p.price, p.image_url
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

// Handle item quantity update
if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Update the quantity in the cart table
    $update_query = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id";
    mysqli_query($conn, $update_query);
    header('Location: checkout.php?user_id=' . $user_id);
    exit();
}

// Handle item deletion from the cart
if (isset($_GET['delete'])) {
    $cart_id = $_GET['delete'];
    $delete_query = "DELETE FROM cart WHERE cart_id = $cart_id";
    mysqli_query($conn, $delete_query);
    header('Location: checkout.php?user_id=' . $user_id);
    exit();
}

// Handle order completion and insert into checkout table
if (isset($_POST['complete_order'])) {
    // Calculate the total amount for the order
    $total_amount = 0;
    $cart_query = "SELECT c.quantity, p.price
                   FROM cart c
                   JOIN products p ON c.product_id = p.product_id
                   WHERE c.user_id = $user_id";
    $cart_result = mysqli_query($conn, $cart_query);
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $total_amount += $row['quantity'] * $row['price'];
    }

    // Insert the checkout record into the checkout table (auto_increment checkout_id handled by MySQL)
    $checkout_query = "INSERT INTO checkout (user_id, total_amount)
                       VALUES ($user_id, $total_amount)";
    mysqli_query($conn, $checkout_query);

    // Get the inserted checkout_id
    $checkout_id = mysqli_insert_id($conn);

    // Redirect to the billing page and pass the checkout_id
    header('Location: billing.php?checkout_id=' . $checkout_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for Checkout -->
    <link rel="stylesheet" href="checkout.css">
</head>
<body>

<div class="container mt-5">
    <h2>Checkout</h2>

    <!-- Cart Items Table -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($cart_item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $cart_item['cart_id'] ?></td>
                        <td><?= $cart_item['name'] ?></td>
                        <td>KES <?= number_format($cart_item['price'], 2) ?></td>
                        <td>
                            <form action="checkout.php?user_id=<?= $user_id ?>" method="POST">
                                <input type="hidden" name="cart_id" value="<?= $cart_item['cart_id'] ?>">
                                <input type="number" name="quantity" value="<?= $cart_item['quantity'] ?>" min="1" required>
                                <button type="submit" name="update_quantity" class="btn btn-warning btn-sm">Update</button>
                            </form>
                        </td>
                        <td>KES <?= number_format($cart_item['quantity'] * $cart_item['price'], 2) ?></td>
                        <td>
                            <a href="checkout.php?delete=<?= $cart_item['cart_id'] ?>&user_id=<?= $user_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Your cart is empty</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Total Amount -->
    <div class="d-flex justify-content-end mb-4">
        <h4>Total Amount: 
            <?php 
            $total_amount = 0;
            $cart_query = "SELECT c.quantity, p.price
                           FROM cart c
                           JOIN products p ON c.product_id = p.product_id
                           WHERE c.user_id = $user_id";
            $cart_result = mysqli_query($conn, $cart_query);
            while ($row = mysqli_fetch_assoc($cart_result)) {
                $total_amount += $row['quantity'] * $row['price'];
            }
            echo "KES " . number_format($total_amount, 2);
            ?>
        </h4>
    </div>

    <!-- Complete Order Button -->
    <form action="checkout.php?user_id=<?= $user_id ?>" method="POST">
        <button type="submit" name="complete_order" class="btn btn-success btn-lg btn-block">Complete Order</button>
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
