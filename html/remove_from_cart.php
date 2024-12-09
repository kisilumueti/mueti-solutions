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

// Check if cart_id is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cart_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Remove the item from the cart
    $query = "DELETE FROM cart WHERE cart_id = '$cart_id' AND user_id = '$user_id'";
    mysqli_query($conn, $query);
}

// Redirect to the cart page
header('Location: cart.php');
exit();
?>
