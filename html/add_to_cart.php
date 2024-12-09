<?php
// Include database connection
include 'connect.php';

// Check if a product ID was sent via AJAX
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Assuming you have the user's session to get the user_id
    // For now, you can use a static user_id for testing (replace with actual session user ID)
    $user_id = 1; // replace with session or logged-in user ID

    // Insert into cart table
    $query = "INSERT INTO cart (user_id, product_id) VALUES ('$user_id', '$product_id')";
    
    if (mysqli_query($conn, $query)) {
        echo "Product added to cart successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
