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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="login container-fluid vh-100">
        <?php require_once("./parts/nav.html"); ?>
        
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


    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./js/animaties.js"></script>
</body>
</html>