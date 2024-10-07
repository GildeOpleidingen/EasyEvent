<?php
require_once './config/conn.php';
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

    <title>EasyEvents | Login</title>

    <!-- css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="login container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-lg-5 d-flex align-items-center justify-content-center">
                <img src="./images/logo.png" alt="Easy Events logo" class="logo-img">
            </div>
            <div class="col-lg-5 d-flex flex-column align-items-center justify-content-center">
                <h1 class="text-center text-uppercase ms-5">Login</h1>
                <p class="text-center ms-5">Log in met je persoonlijke gebruikersnaam en wachtwoord</p>
                <form style="margin-left: -150px">
                    <div class="form-floating mb-3">
                        <input type="text" id="gebruikersnaam" class="form-control rounded-0 w-100" placeholder="Gebruikersnaam">
                        <label for="gebruikersnaam">Gebruikersnaam</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="wachtwoord" class="form-control rounded-0" placeholder="Wachtwoord">
                        <label for="wachtwoord">Wachtwoord</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
                <p class="text-center ms-5 mt-3">Geen account? Registreer <a href="./registreer">hier</a></p>
            </div>
        </div>
    </div>


    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./js/animaties.js"></script>
</body>
</html>