<?php
// Include database connection and customer navigation
include 'connect.php';
include 'customer_nav.php';

// Check if the product ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch product details from the database
    $query = "SELECT product_id, name, description, price, stock, category, image_url FROM products WHERE product_id = '$product_id' AND status = 'active'";
    $result = mysqli_query($conn, $query);

    // Check if the product exists
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        $product = null;
        $error_message = "Product not found.";
    }
} else {
    $error_message = "Invalid product ID.";
    $product = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        .product-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-details {
            margin-top: 20px;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <!-- Display error if no product found -->
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger text-center">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <?php if ($product) { ?>
            <!-- Product Details Section -->
            <div class="row product-details">
                <!-- Product Image -->
                <div class="col-md-6">
                    <img src="images/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                </div>
                <!-- Product Information -->
                <div class="col-md-6">
                    <h2><?php echo $product['name']; ?></h2>
                    <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
                    <p><strong>Price:</strong> KES <?php echo number_format($product['price'], 2); ?></p>
                    <p><strong>Stock Available:</strong> <?php echo $product['stock']; ?> units</p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo nl2br($product['description']); ?></p>

                    <!-- Add to Cart Button -->
                    <div class="btn-container">
                        <a href="add_to_cart.php?id=<?php echo $product['product_id']; ?>" class="btn btn-success btn-lg">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
