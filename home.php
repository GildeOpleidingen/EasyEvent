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
    <div class="preloader">
        <img src="./images/logo.png" alt="" id="loader" class="loader">
    </div>

    <div id="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a href="#" class="navbar-brand ms-5"><img src="./images/logo.png" alt="EasyEvents Logo" width="125" height="125"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-5">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">NEWS & UPDATES</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><button class="btn btn-primary">LOGIN</button></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>