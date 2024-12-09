<?php
// Include database connection
include 'connect.php';
include 'customer_nav.php';
// Fetch all active products from the database
$query = "SELECT product_id, name, price, category, stock, image_url FROM products WHERE status = 'active'";
$result = mysqli_query($conn, $query);

// Check if products are fetched
if (mysqli_num_rows($result) > 0) {
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Mueti Solutions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        .product-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        .card-body .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .product-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            text-align: center;
            padding: 1rem;
        }

        .product-card .btn {
            font-size: 1rem;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <!-- Main content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Explore Our Products</h3>
                    </div>
                    <div class="card-body text-center">
                        <p class="welcome-message">Browse and add your favorite items to the cart!</p>

                        <!-- Products Section -->
                        <div class="row" id="product-list">
                            <?php foreach ($products as $product) { ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card product-card">
                                        <!-- Image Path dynamically retrieved from the database -->
                                        <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">

                                        <!-- Product details below the image -->
                                        <div class="card-body">
                                            <div class="product-name"><?php echo $product['name']; ?></div>
                                            <p>KSh <?php echo number_format($product['price'], 2); ?></p>

                                            <div class="btn-container">
                                                <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> See More
                                                </a>
                                                <button class="btn btn-success btn-sm add-to-cart" data-id="<?php echo $product['product_id']; ?>">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (optional) -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Mueti Solutions. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Attach event listener to all "Add to Cart" buttons
        $(document).on('click', '.add-to-cart', function() {
            var productId = $(this).data('id'); // Get the product ID

            // Send AJAX request to add product to the cart
            $.ajax({
                url: 'add_to_cart.php', // The file to handle the request
                type: 'GET',
                data: { id: productId }, // Send the product ID
                success: function(response) {
                    console.log(response); // Optional: log the response to check
                    alert('Product added to cart!'); // Show success message
                },
                error: function(xhr, status, error) {
                    alert('Error adding product to cart. Please try again.');
                }
            });
        });
    </script>
</body>

</html>
