<?php
// Include necessary files
include('connect.php');
include('admin_nav.php');

// Pagination variables
$records_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search_query = '';
if (isset($_POST['search'])) {
    $search_value = $_POST['search_value'];
    $search_query = "WHERE o.order_id LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR o.status LIKE '%$search_value%'";
}

// Fetch orders with pagination and search functionality
$query_orders = "
    SELECT o.order_id, o.order_date, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, o.total_amount, o.status, o.address, o.landmark, o.category
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    $search_query
    ORDER BY o.order_date DESC
    LIMIT $records_per_page OFFSET $offset
";

$result_orders = mysqli_query($conn, $query_orders);

// Fetch total records for pagination
function get_total_pages($conn, $search_query = '') {
    $query = "SELECT COUNT(*) AS total_records FROM orders o JOIN users u ON o.user_id = u.user_id $search_query";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return ceil($row['total_records'] / 10);
}

// Delete completed orders older than 48 hours
$query_delete_old_completed_orders = "
    DELETE FROM orders 
    WHERE status = 'completed' AND order_date < NOW() - INTERVAL 48 HOUR
";
mysqli_query($conn, $query_delete_old_completed_orders);

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $query_update_status = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
    mysqli_query($conn, $query_update_status);
}

// Handle order deletion
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $query_delete_order = "DELETE FROM orders WHERE order_id = $order_id";
    mysqli_query($conn, $query_delete_order);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<div class="container mt-4">
    <h2>Manage Orders</h2>

    <!-- Search Form -->
    <form method="POST" action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search_value" placeholder="Search Orders by ID, Name, or Status">
            <button class="btn btn-primary" type="submit" name="search"><i class="fas fa-search"></i> Search</button>
        </div>
    </form>

    <!-- Orders Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Address</th>
                <th>Landmark</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result_orders)) {
                $order_id = $row['order_id'];
                $status = $row['status'];
                $order_date = $row['order_date'];
                $address = $row['address'];
                $landmark = $row['landmark'];
                $category = $row['category'];
                $customer_name = $row['customer_name'];
                $total_amount = $row['total_amount'];
            ?>
                <tr>
                    <td><?php echo $order_id; ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td>KES <?php echo number_format($total_amount, 2); ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo ($status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo ($status == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm mt-2">Update</button>
                        </form>
                    </td>
                    <td><?php echo $address; ?></td>
                    <td><?php echo $landmark; ?></td>
                    <td><?php echo $category; ?></td>
                    <td>
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="delete_order" class="btn btn-danger btn-sm">Delete</button>
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <ul class="pagination">
            <?php
            $total_pages = get_total_pages($conn, $search_query);
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
