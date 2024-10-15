<?php
use App\Conn;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>EasyEvents</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="preloader">
        <img src="../../images/logo.png" alt="" id="loader" class="loader">
    </div>

    <div id="content">
        <?php require_once(__ROOT__."/parts/nav.html"); ?>

        <section class="hero d-flex align-items-center justify-content-center" style="min-height: 75vh;">
            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-6 text-lg-start text-center mb-5 mb-lg-0">
                        <h1 class="display-4 fw-bold">PLAN <br> MET <br> EASY <br> EVENTS</h1>
                        <a href="#" class="btn btn-primary text-white mt-3">Installeer als app</a>
                    </div>
                    
                    <div class="col-lg-6">
                        <p class="lead text-start">Welkom op ons evenementenplatform! Hier kun je eenvoudig solliciteren voor allerlei soorten evenementen, van concerten en festivals tot workshops en conferenties. Blader door ons aanbod, kies de evenementen die jou interesseren en dien je aanmelding in met slechts een paar klikken. Het is jouw alles-in-één oplossing om nieuwe en spannende evenementen te ontdekken en mee te doen!</p>
                        <p class="lead text-start">Of je nu op zoek bent naar een grote conferentie of een intieme workshop, ons platform maakt het aanmelden makkelijk en snel.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
</body>
</html>