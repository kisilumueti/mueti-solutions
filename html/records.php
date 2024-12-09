<?php
// Include the necessary files for database connection, header, and navigation
include('connect.php');
include('admin_nav.php');

// Pagination variables
$records_per_page = 10;  // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch total records for pagination
function get_total_pages($conn, $table) {
    $query = "SELECT COUNT(*) AS total_records FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return ceil($row['total_records'] / 10);  // Adjust this value for the pagination limit
}

// Fetching Orders with customer name, order date, total amount, and status
$query_orders = "
    SELECT o.order_id, o.order_date, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, o.total_amount, o.status
    FROM orders o 
    JOIN users u ON o.user_id = u.user_id
    LIMIT $records_per_page OFFSET $offset
";

$result_orders = mysqli_query($conn, $query_orders);

// Fetching Users data
$query_users = "
    SELECT user_id, first_name, last_name, email, phone, role, created_at
    FROM users
    LIMIT $records_per_page OFFSET $offset
";

$result_users = mysqli_query($conn, $query_users);

// Fetching Products data
$query_products = "
    SELECT p.product_id, p.name, p.description, p.price, p.stock, 
           p.category, p.image_url, p.rating, p.status, p.is_featured, 
           c.category_name AS category_name, p.created_at, p.updated_at
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LIMIT $records_per_page OFFSET $offset
";

$result_products = mysqli_query($conn, $query_products);

// Handle any query errors
if (!$result_products) {
    die('Error in query: ' . mysqli_error($conn));
}
// Fetching Sales data
$query_sales = "
    SELECT s.sale_id, p.name AS product_name, s.quantity, (s.amount * s.quantity) AS total_price, s.sale_date
    FROM sales s
    JOIN products p ON s.product_id = p.product_id
    LIMIT $records_per_page OFFSET $offset
";

$result_sales = mysqli_query($conn, $query_sales);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records - Mueti Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- FontAwesome Icons -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for print/download functionality -->
</head>
<body>

    <div class="container mt-4">
        <h2>Records</h2>

        <!-- Records Cards Section -->
        <div class="row">
            <!-- Orders Card -->
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Orders</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Orders</h5>
                        <p class="card-text">View, print, or download order records.</p>
                        <button class="btn btn-light" onclick="printOrderData()"><i class="fas fa-print"></i> Print Orders</button>
                        <button class="btn btn-light" onclick="downloadOrderData()"><i class="fas fa-download"></i> Download Orders</button>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View, print, or download user records.</p>
                        <button class="btn btn-light" onclick="printUserData()"><i class="fas fa-print"></i> Print Users</button>
                        <button class="btn btn-light" onclick="downloadUserData()"><i class="fas fa-download"></i> Download Users</button>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Products</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Products</h5>
                        <p class="card-text">View, print, or download product records.</p>
                        <button class="btn btn-light" onclick="printProductData()"><i class="fas fa-print"></i> Print Products</button>
                        <button class="btn btn-light" onclick="downloadProductData()"><i class="fas fa-download"></i> Download Products</button>
                    </div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Sales</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Sales</h5>
                        <p class="card-text">View, print, or download sales records.</p>
                        <button class="btn btn-light" onclick="printSalesData()"><i class="fas fa-print"></i> Print Sales</button>
                        <button class="btn btn-light" onclick="downloadSalesData()"><i class="fas fa-download"></i> Download Sales</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="mb-4">
            <h3>Orders</h3>
            <table id="orderTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_orders)) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>KES " . number_format($row['total_amount'], 2) . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Users Table -->
        <div class="mb-4">
            <h3>Users</h3>
            <table id="userTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_users)) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Products Table -->
        <div class="mb-4">
            <h3>Products</h3>
            <table id="productTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_products)) {
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>KES " . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . $row['stock'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Sales Table -->
        <div class="mb-4">
            <h3>Sales</h3>
            <table id="salesTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Sale Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_sales)) {
                        echo "<tr>";
                        echo "<td>" . $row['sale_id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>KES " . number_format($row['total_price'], 2) . "</td>";
                        echo "<td>" . $row['sale_date'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                $total_pages_orders = get_total_pages($conn, 'orders');
                $total_pages_users = get_total_pages($conn, 'users');
                $total_pages_products = get_total_pages($conn, 'products');
                $total_pages_sales = get_total_pages($conn, 'sales');

                for ($i = 1; $i <= $total_pages_orders; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='records.php?page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <script>
        // Print functions for each section
        function printOrderData() {
            var printContents = document.getElementById('orderTable').outerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Orders</title></head><body>');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }

        function printUserData() {
            var printContents = document.getElementById('userTable').outerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Users</title></head><body>');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }

        function printProductData() {
            var printContents = document.getElementById('productTable').outerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Products</title></head><body>');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }

        function printSalesData() {
            var printContents = document.getElementById('salesTable').outerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Sales</title></head><body>');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }

        // Download functions for each section
        function downloadOrderData() {
            var table = document.getElementById('orderTable');
            var rows = table.rows;
            var csvContent = "Order ID, Order Date, Customer Name, Total Amount, Status\n";
            
            for (var i = 1; i < rows.length; i++) {
                var cols = rows[i].cells;
                csvContent += cols[0].innerText + ',' + cols[1].innerText + ',' + cols[2].innerText + ',' + cols[3].innerText + ',' + cols[4].innerText + '\n';
            }
            
            var link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
            link.download = 'orders.csv';
            link.click();
        }

        function downloadUserData() {
            var table = document.getElementById('userTable');
            var rows = table.rows;
            var csvContent = "User ID, Name, Email, Phone, Role, Created At\n";
            
            for (var i = 1; i < rows.length; i++) {
                var cols = rows[i].cells;
                csvContent += cols[0].innerText + ',' + cols[1].innerText + ',' + cols[2].innerText + ',' + cols[3].innerText + ',' + cols[4].innerText + ',' + cols[5].innerText + '\n';
            }
            
            var link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
            link.download = 'users.csv';
            link.click();
        }

        function downloadProductData() {
            var table = document.getElementById('productTable');
            var rows = table.rows;
            var csvContent = "Product ID, Name, Description, Price, Stock, Category, Status, Created At\n";
            
            for (var i = 1; i < rows.length; i++) {
                var cols = rows[i].cells;
                csvContent += cols[0].innerText + ',' + cols[1].innerText + ',' + cols[2].innerText + ',' + cols[3].innerText + ',' + cols[4].innerText + ',' + cols[5].innerText + ',' + cols[6].innerText + ',' + cols[7].innerText + '\n';
            }
            
            var link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
            link.download = 'products.csv';
            link.click();
        }

        function downloadSalesData() {
            var table = document.getElementById('salesTable');
            var rows = table.rows;
            var csvContent = "Sale ID, Product Name, Quantity, Total Price, Sale Date\n";
            
            for (var i = 1; i < rows.length; i++) {
                var cols = rows[i].cells;
                csvContent += cols[0].innerText + ',' + cols[1].innerText + ',' + cols[2].innerText + ',' + cols[3].innerText + ',' + cols[4].innerText + '\n';
            }
            
            var link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
            link.download = 'sales.csv';
            link.click();
        }
    </script>
</body>
</html>
