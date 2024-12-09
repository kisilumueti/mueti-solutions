<?php
// Include the database connection file
include 'connect.php';
include 'admin_nav.php'; // Include the admin navigation bar (already created)

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Handle search functionality (if search term is provided)
$search_query = "";
if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = " WHERE name LIKE '%$search_term%'";
    $query = "SELECT * FROM products" . $search_query;
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Mueti Solutions</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for product management -->
    <link rel="stylesheet" href="manage_products.css">
</head>
<body>

<div class="container mt-5">
    <!-- Search Bar and Add Product Button -->
    <div class="d-flex justify-content-between mb-4">
        <form class="form-inline" action="manage_products.php" method="GET">
            <input class="form-control" type="text" placeholder="Search Product" name="search" value="<?= isset($search_term) ? $search_term : '' ?>">
            <button class="btn btn-outline-primary ml-2" type="submit"><i class="fas fa-search"></i> Search</button>
        </form>
        <a href="add_product.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Product</a>
    </div>

    <!-- Product Table -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td>KES <?= number_format($product['price'], 2) ?></td>
                        <td><?= $product['stock'] ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['product_id'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete_product.php?id=<?= $product['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination (if needed) -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Assuming pagination logic is implemented -->
                <!-- Add page links here -->
            </ul>
        </nav>
    <?php endif; ?>

</div>

<!-- Bootstrap JS (and jQuery for Bootstrap support) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Optional JS for confirm dialog on Delete -->
<script>
    // Optional JS for Delete confirmation
    $('a.btn-danger').on('click', function(e) {
        if (!confirm("Are you sure you want to delete this product?")) {
            e.preventDefault();
        }
    });
</script>
</body>
</html>
