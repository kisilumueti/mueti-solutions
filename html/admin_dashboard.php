<?php
// Include the database connection file
include 'connect.php';
include 'admin_nav.php'; // Assuming admin_nav.php has the admin navbar

// Query to get total sales from completed orders
$query_sales = "SELECT SUM(total_amount) as total_sales FROM orders WHERE status = 'completed'";
$result_sales = mysqli_query($conn, $query_sales);
$sales_data = mysqli_fetch_assoc($result_sales);
$total_sales = isset($sales_data['total_sales']) ? $sales_data['total_sales'] : 0;

// Query to get total users
$query_users = "SELECT COUNT(*) as total_users FROM users";
$result_users = mysqli_query($conn, $query_users);
$users_data = mysqli_fetch_assoc($result_users);
$total_users = isset($users_data['total_users']) ? $users_data['total_users'] : 0;

// Query to get new users (Registered within the last 30 days)
$query_new_users = "SELECT COUNT(*) as new_users FROM users WHERE created_at >= CURDATE() - INTERVAL 30 DAY";
$result_new_users = mysqli_query($conn, $query_new_users);
$new_users_data = mysqli_fetch_assoc($result_new_users);
$new_users = isset($new_users_data['new_users']) ? $new_users_data['new_users'] : 0;

// Query to get total available products
$query_products = "SELECT COUNT(*) as total_products FROM products";
$result_products = mysqli_query($conn, $query_products);
$products_data = mysqli_fetch_assoc($result_products);
$total_products = isset($products_data['total_products']) ? $products_data['total_products'] : 0;

// Query to get sales data grouped by month for the graph
$query_sales_graph = "
    SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_amount) as monthly_sales
    FROM orders 
    WHERE status = 'completed' 
    GROUP BY DATE_FORMAT(order_date, '%Y-%m')
    ORDER BY DATE_FORMAT(order_date, '%Y-%m') ASC";
$result_sales_graph = mysqli_query($conn, $query_sales_graph);

$sales_graph_labels = [];
$sales_graph_data = [];
while ($row = mysqli_fetch_assoc($result_sales_graph)) {
    $sales_graph_labels[] = $row['month'];
    $sales_graph_data[] = $row['monthly_sales'];
}

// Query to get orders data grouped by month for the graph
$query_orders_graph = "
    SELECT DATE_FORMAT(order_date, '%Y-%m') as month, COUNT(order_id) as total_orders
    FROM orders
    WHERE status = 'completed'
    GROUP BY DATE_FORMAT(order_date, '%Y-%m')
    ORDER BY DATE_FORMAT(order_date, '%Y-%m') ASC";
$result_orders_graph = mysqli_query($conn, $query_orders_graph);

$orders_graph_labels = [];
$orders_graph_data = [];
while ($row = mysqli_fetch_assoc($result_orders_graph)) {
    $orders_graph_labels[] = $row['month'];
    $orders_graph_data[] = $row['total_orders'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_dashboard.css">

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar adjustments */
        .navbar {
            background-color: #343a40;
        }

        .navbar-nav .nav-item .nav-link {
            color: #f8f9fa !important;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #00b5b8 !important;
        }

        /* Card Styles */
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
        }

        .card-text {
            font-size: 1.2rem;
        }

        .container {
            margin-top: 30px;
        }

        .col-md-4 {
            margin-bottom: 30px;
        }

        /* Background colors for each card */
        .card-sales {
            background-color: #28a745; 
            color: #fff;
        }

        .card-users {
            background-color: #007bff;
            color: #fff;
        }

        .card-new-users {
            background-color: #ffc107;
            color: #343a40;
        }

        .card-products {
            background-color: #dc3545;
            color: #fff;
        }

        /* Graph card */
        .card-graph {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
        }

        /* Graph Layout */
        .graph-container {
            display: flex;
            justify-content: space-between;
        }

        .graph-card {
            width: 48%;
        }

        /* Hover effect on cards */
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Total Sales Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-sales">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text">
                        <i class="fas fa-dollar-sign fa-3x mb-3"></i><br>
                        <strong>KES <?= number_format($total_sales, 2) ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-users">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">
                        <i class="fas fa-users fa-3x mb-3"></i><br>
                        <strong><?= number_format($total_users) ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- New Users Card -->
        <div class="col-md-4 mb-4">
            <div class="card card-new-users">
                <div class="card-body text-center">
                    <h5 class="card-title">New Users (Last 30 Days)</h5>
                    <p class="card-text">
                        <i class="fas fa-user-plus fa-3x mb-3"></i><br>
                        <strong><?= number_format($new_users) ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="graph-container">
        <!-- Sales Graph -->
        <div class="graph-card">
            <div class="card card-graph">
                <div class="card-body">
                    <h5 class="card-title text-center">Sales Graph</h5>
                    <canvas id="salesGraph"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders Graph -->
        <div class="graph-card">
            <div class="card card-graph">
                <div class="card-body">
                    <h5 class="card-title text-center">Orders Graph</h5>
                    <canvas id="ordersGraph"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxSales = document.getElementById('salesGraph').getContext('2d');
    var salesGraph = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: <?= json_encode($sales_graph_labels) ?>,
            datasets: [{
                label: 'Monthly Sales (KES)',
                data: <?= json_encode($sales_graph_data) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Sales (KES)'
                    }
                }
            }
        }
    });

    var ctxOrders = document.getElementById('ordersGraph').getContext('2d');
    var ordersGraph = new Chart(ctxOrders, {
        type: 'line',
        data: {
            labels: <?= json_encode($orders_graph_labels) ?>,
            datasets: [{
                label: 'Monthly Orders',
                data: <?= json_encode($orders_graph_data) ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Orders'
                    }
                }
            }
        }
    });
</script>

</body>
</html>
