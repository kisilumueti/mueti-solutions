<?php 
// Include database connection
include 'connect.php';
include 'customer_nav.php';
// Fetch products from the database
$query = "SELECT product_id, name, price, category, stock, image_url FROM products WHERE status = 'active' LIMIT 10";
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
    <title>Customer Dashboard - Mueti Solutions</title>
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
            margin-bottom: 1rem;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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

        .welcome-message {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #f7c08b;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #f5a623;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .highlight-text {
            color: #f7c08b;
            font-weight: bold;
        }

        /* Animation styles */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-right {
            opacity: 0;
            transform: translateX(20px);
            animation: fadeRight 1s forwards;
        }

        @keyframes fadeRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-left {
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeLeft 1s forwards;
        }

        @keyframes fadeLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

    </style>
</head>

<body>
    <!-- Main content -->
    <div class="container py-5">
        <div class="row">
            <!-- Welcome Section -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="highlight-text">Welcome to Mueti Solutions!</h3>
                    </div>
                    <div class="card-body text-center">
                        <p class="welcome-message">Explore our wide range of products tailored for everyone! Best quality, best prices! Check out our latest products below.</p>

                        <!-- Products Section -->
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="product-list">
                            <?php foreach ($products as $product) { ?>
                                <div class="col fade-up">
                                    <div class="card product-card">
                                        <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">

                                        <div class="card-body">
                                            <div class="product-name"><?php echo $product['name']; ?></div>
                                            <p>KSh <?php echo $product['price']; ?></p>

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

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center mt-5">
                            <a href="customer_orders.php" class="btn btn-primary m-2">
                                <i class="fas fa-box"></i> View Orders
                            </a>
                            <a href="checkout.php" class="btn btn-primary m-2">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Mueti Solutions. All Rights Reserved. Trusted by thousands, delivering the best products for all ages.</p>
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
