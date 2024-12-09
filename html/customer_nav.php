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

    <!-- Custom CSS for Hover Animations and Styling -->
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #000000; /* Black background */
            padding: 10px 0;
            font-size: 18px;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Navbar links styling */
        .nav-link {
            color: #ffffff !important;
            transition: all 0.3s ease-in-out;
        }

        /* Hover effect for navbar links */
        .nav-link:hover {
            color: #ffd700 !important; /* Gold color on hover */
            transform: scale(1.1);
        }

        /* Navbar collapsed items */
        .navbar-toggler-icon {
            background-color: #ffffff;
        }

        /* Active link */
        .nav-item.active .nav-link {
            color: #ffd700 !important;
        }

        /* Responsive navbar styling */
        .navbar-collapse {
            display: flex;
            justify-content: flex-end;
        }

        /* Slide in animation for mobile menu */
        @keyframes slideIn {
            0% { transform: translateX(100%); }
            100% { transform: translateX(0); }
        }

        .navbar-collapse.collapse {
            animation: slideIn 0.5s ease-out forwards;
        }

        /* Custom card styling */
        .dashboard-card {
            margin: 20px 0;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dashboard-card .card-body {
            text-align: center;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        /* Button styling */
        .btn-dashboard {
            width: 100%;
            font-size: 1.2rem;
            padding: 10px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo/Header -->
            <a class="navbar-brand" href="customer_dashboard.php">Mueti Solutions</a>
            
            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Home Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="customer_dashboard.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <!-- Orders Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="customer_orders.php"><i class="fas fa-box"></i> Orders</a>
                    </li>
                    <!-- Products Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><i class="fas fa-cogs"></i> Products</a>
                    </li>
                    <!-- Checkout Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="checkout.php"><i class="fas fa-credit-card"></i> Checkout</a>
                    </li>
                    <!-- Support Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="customer_support.php"><i class="fas fa-life-ring"></i> Support</a>
                    </li>
                    <!-- Logout Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Below Navbar -->

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
