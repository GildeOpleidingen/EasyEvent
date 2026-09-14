<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    <title>EasyEvents | Login</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- reCAPTCHA API -->
    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
</head>
<body>
    <div class="login container-fluid vh-100">
     <?php require_once(__ROOT__."/parts/nav.php"); ?>
        <div class="d-flex justify-content-center align-items-center h-75">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <img src="../../images/logo.png" alt="Easy Events logo" class="logo-img">
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                    <h1 class="text-center text-uppercase ms-6">Login</h1>
                    <p class="text-center ms-6">met je emailadres en wachtwoord</p>

                    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
                    
                    


                    <form action="./login" method="POST" class="w-75" id="captcha-form">
                         <div class="form-floating mb-3">
                            <input type="email" id="emailadres" name="Gebruikersnaam" class="form-control rounded-0" placeholder="Emailadres">
                            <label for="emailadres">Emailadres</label>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" id="wachtwoord" name="wachtwoord"  class="form-control rounded-0" placeholder="Wachtwoord">
                            <label for="wachtwoord">Wachtwoord</label>
                            <i class="bi bi-eye-fill position-absolute icon-eye" onclick="togglePasswordVisibility('wachtwoord', this);"></i>
                        </div>
                        <p class="text-left ms-6 mt-3"><a href="./forgot-password">Wachtwoord vergeten?</a></p>
                        <!-- <div class="g-recaptcha" data-sitekey="6LdGioIqAAAAAD_5qLYFbEWMExrDnDkzDWrw0M8o"></div> -->
                        <button class="btn btn-primary w-100 login-btn mt-3" type="submit">Login</button>
                    </form>
                    <p class="text-center ms-6 mt-3">Geen account? Registreer <a href="./register">hier</a></p>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
</body>
</html>