<?php
// Include the database connection file
include 'connect.php';

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details to get the image URL
    $query = "SELECT image_url FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    // Check if the product exists
    if ($product) {
        // Get the image URL for deletion
        $image_url = $product['image_url'];

        // Start a transaction to delete product and image
        mysqli_begin_transaction($conn);

        try {
            // Delete the product from the products table
            $delete_query = "DELETE FROM products WHERE product_id = $product_id";
            if (!mysqli_query($conn, $delete_query)) {
                throw new Exception("Error deleting product from database: " . mysqli_error($conn));
            }

            // Check if image exists and delete it from the server
            if ($image_url && file_exists($image_url)) {
                if (!unlink($image_url)) {
                    throw new Exception("Error deleting image file: $image_url");
                }
            }

            // Commit the transaction
            mysqli_commit($conn);

            // Redirect to manage products page with success message
            header('Location: manage_products.php?success=Product deleted successfully');
            exit();
        } catch (Exception $e) {
            // Rollback the transaction if something goes wrong
            mysqli_rollback($conn);
            echo "Error: " . $e->getMessage();
            exit();
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID specified!";
    exit();
}
?>
