<?php
require_once "./config/conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="./images/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="./images/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>EasyEvents</title>

    <!-- css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="./images/logo.png" alt="Logo" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>