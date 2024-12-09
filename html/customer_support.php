<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .social-btn {
            font-size: 1.5rem;
            padding: 15px 20px;
            margin: 10px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        
        .social-btn:hover {
            transform: scale(1.1);
            background-color: #007bff;
            color: white;
        }

        .btn-instagram:hover {
            background-color: #E4405F;
            color: white;
        }

        .btn-facebook:hover {
            background-color: #4267B2;
            color: white;
        }

        .btn-whatsapp:hover {
            background-color: #25D366;
            color: white;
        }

        .btn-phone:hover {
            background-color: #34b7f1;
            color: white;
        }

        .btn-email:hover {
            background-color: #D44638;
            color: white;
        }

        .btn-twitter:hover {
            background-color: #1DA1F2;
            color: white;
        }

        /* Sliding Animation */
        .social-icons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }
    </style>
    <title>Customer Support</title>
</head>
<body>
    <!-- Navbar -->
    <?php include 'customer_nav.php'; ?>

    <!-- Main content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Customer Support</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center">You can reach us via the following platforms:</p>

                        <div class="social-icons">
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/techkenya_" class="btn btn-outline-primary social-btn btn-instagram animate__animated animate__fadeIn" target="_blank">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                            
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/techkenya_" class="btn btn-outline-primary social-btn btn-facebook animate__animated animate__fadeIn" target="_blank">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/254716005166" class="btn btn-outline-success social-btn btn-whatsapp animate__animated animate__fadeIn" target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>

                            <!-- Call -->
                            <a href="tel:+254716005166" class="btn btn-outline-info social-btn btn-phone animate__animated animate__fadeIn">
                                <i class="fas fa-phone-alt"></i> Call
                            </a>

                            <!-- Email -->
                            <a href="mailto:muetijohnbosco35@gmail.com" class="btn btn-outline-danger social-btn btn-email animate__animated animate__fadeIn">
                                <i class="fas fa-envelope"></i> Email
                            </a>

                            <!-- Twitter -->
                            <a href="https://twitter.com/johnboscomuueti" class="btn btn-outline-info social-btn btn-twitter animate__animated animate__fadeIn" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <p>If you have any questions, feel free to contact us on any of the platforms above.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
