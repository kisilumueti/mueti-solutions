<?php
// Include database connection
include 'connect.php';
include 'admin_nav.php';
// Handle form submission to add the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Image upload handling
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];
    
    // Validate image upload
    if ($image_error === 0) {
        // Ensure the image is not too large (e.g., 5MB max)
        if ($image_size <= 5000000) {
            // Get the image extension
            $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($image_extension, $allowed_extensions)) {
                // Generate a unique image name
                $image_new_name = uniqid('', true) . '.' . $image_extension;
                $image_destination = 'images/' . $image_new_name;

                // Move the image to the images directory
                if (move_uploaded_file($image_tmp_name, $image_destination)) {
                    // Insert the product into the database
                    $query = "INSERT INTO products (name, price, description, category, stock, image_url, status) 
                              VALUES ('$name', '$price', '$description', '$category', '$stock', '$image_new_name', 'active')";
                    if (mysqli_query($conn, $query)) {
                        $success_message = "Product added successfully!";
                    } else {
                        $error_message = "Failed to add product to the database.";
                    }
                } else {
                    $error_message = "Error uploading the image.";
                }
            } else {
                $error_message = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            $error_message = "The image is too large. Maximum size is 5MB.";
        }
    } else {
        $error_message = "There was an error uploading the image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h3 class="text-center mb-4">Add New Product</h3>
        
        <!-- Display Success or Error Message -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Product Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Price (KSh)</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="snacks">Snacks</option>
                    <option value="stationery">Stationery</option>
                    <option value="electronics">Electronics</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
