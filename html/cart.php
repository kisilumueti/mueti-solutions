<?php
// Start session
session_start();

// Include the database connection
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the items in the cart
$query = "SELECT c.cart_id, p.name, p.image_url, p.price, c.quantity
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = '$user_id'";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-item img {
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h2>Your Cart</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="cart-item">
                            <td>
                                <img src="images/<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>"> 
                                <?php echo $row['name']; ?>
                            </td>
                            <td>KSh <?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>KSh <?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                            <td>
                                <a href="remove_from_cart.php?id=<?php echo $row['cart_id']; ?>" class="btn btn-danger btn-sm">
                                    Remove
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Total Price -->
            <div class="text-end">
                <h4>Total: KSh <?php echo number_format($total, 2); ?></h4>
                <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
            </div>
        <?php } else { ?>
            <p>Your cart is empty. <a href="index.php">Start shopping</a>.</p>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
