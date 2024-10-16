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

    <title>EasyEvents | Registreer</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/nav.css">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="register container-fluid vh-100">
    <?php require_once(__ROOT__."/parts/nav.html"); ?>
        <div class="d-flex justify-content-center align-items-center h-75">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <img src="../../images/logo.png" alt="Easy Events logo" class="logo-img">
            </div>
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                <h1 class="text-center text-uppercase ms-5">Registreer</h1>
                <p class="text-center ms-5">Maak een nieuw account</p>
                <form style="margin-left: 50px">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" id="voornaam" class="form-control rounded-0" placeholder="Voornaam">
                                <label for="voornaam">Voornaam</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" id="achternaam" class="form-control rounded-0" placeholder="Achternaam">
                                <label for="achternaam">Achternaam</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" id="email" class="form-control rounded-0" placeholder="E-mailadres">
                        <label for="email">E-mailadres</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" id="telefoon" class="form-control rounded-0" placeholder="Telefoonnummer">
                        <label for="telefoon">Telefoonnummer</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="wachtwoord" class="form-control rounded-0" placeholder="Wachtwoord">
                        <label for="wachtwoord">Wachtwoord</label>
                        <i class="bi bi-eye-fill position-absolute icon-eye" onclick="togglePasswordVisibility('wachtwoord', this);"></i>
                    </div>
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" id="herhaalWachtwoord" class="form-control rounded-0" placeholder="Herhaal wachtwoord">
                        <label for="herhaalWachtwoord">Herhaal wachtwoord</label>
                        <i class="bi bi-eye-fill position-absolute icon-eye" onclick="togglePasswordVisibility('herhaalWachtwoord', this);"></i>
                    </div>
                    <button class="btn btn-primary w-100 register-btn" type="submit">Registreer</button>
                </form>
            </div>
        </div>
    </div>

        <script>
            function togglePasswordVisibility(inputId, icon) {
                const input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bi-eye-fill");
                    icon.classList.add("bi-eye-slash-fill");
                } else {
                    input.type = "password";
                    icon.classList.remove("bi-eye-slash-fill");
                    icon.classList.add("bi-eye-fill");
                }
            }
        </script>


    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
</body>

</html>