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

    <title>EasyEvents | Profiel</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/events.css">
    <link rel="stylesheet" href="/css/profile.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <?php
        $hour = date('H');
        $greeting = ($hour < 12) ? 'Goedemorgen' : (($hour < 18) ? 'Goedemiddag' : 'Goedeavond');
    ?>
    <div class="container-fluid vh-100">
        <?php require_once('./parts/nav.html'); ?>

        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2><?= $greeting, $email; ?></h2>
                <div class="card position-relative mt-5">
                    <div class="card-body text-start ms-5">
                        <img src="./images/profile.png" alt="Profile Picture" class="img-fluid rounded-circle position-absolute" style="width: 150px; height: 150px; top: -75px; left: calc(50% - 75px);">
                        <div class="mt-5 pt-5 row">
                            <div class="col">
                                <div class="contact-info">
                                    <p><i class="bi bi-envelope-fill me-2"></i>Email: <?php echo $email; ?></p>
                                    <p><i class="bi bi-key-fill me-2"></i>Wachtwoord: ******</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="contact-info">
                                    <p><i class="bi bi-telephone-fill me-2"></i>Telefoonnummer: <?= $phone; ?></p>
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary">Bekijk mijn Evenementen</button>
                    <button class="btn btn-danger">Uitloggen</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/searchbar.js"></script>
    <script src="../../js/tabs.js"></script>
    <script src="../../js/calendar.js"></script>
</body>
</html>