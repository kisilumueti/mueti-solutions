<?php
// Include the database connection
include 'connect.php';
include 'admin_nav.php';

// Fetch the product ID from the URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

// If the product ID is not set or invalid, redirect to the manage products page
if (!$product_id) {
    header('Location: manage_products.php');
    exit();
}

// Fetch the product details from the database
$query = "SELECT * FROM products WHERE product_id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Check if the product exists
if (!$product) {
    echo "Product not found.";
    exit();
}

// Process the form submission for editing the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle file upload for image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_dir = 'images/';
        $image_path = $image_dir . basename($image_name);

        // Move the uploaded image to the images folder
        if (move_uploaded_file($image_tmp, $image_path)) {
            $image_url = $image_path;
        } else {
            echo "Failed to upload image.";
            exit();
        }
    } else {
        // If no new image is uploaded, use the existing image
        $image_url = $product['image_url'];
    }

    // Update the product in the database
    $update_query = "UPDATE products SET 
        name = '$name',
        description = '$description',
        price = '$price',
        stock = '$stock',
        category = '$category',
        image_url = '$image_url',
        updated_at = CURRENT_TIMESTAMP
        WHERE product_id = $product_id";

    if (mysqli_query($conn, $update_query)) {
        // Redirect to the manage products page with a success message
        header('Location: manage_products.php?success=Product updated successfully');
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for Edit Product -->
    <link href="edit_product.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2>Edit Product</h2>
        <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price (KES)</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="electronics" <?php echo ($product['category'] == 'electronics') ? 'selected' : ''; ?>>Electronics</option>
                    <option value="fashion" <?php echo ($product['category'] == 'fashion') ? 'selected' : ''; ?>>Fashion</option>
                    <option value="home_appliances" <?php echo ($product['category'] == 'home_appliances') ? 'selected' : ''; ?>>Home Appliances</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="<?php echo $product['image_url']; ?>" alt="Current Image" width="150" class="mt-2">
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
