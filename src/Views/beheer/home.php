<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>Beheer | Event Aanmaken</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/event-info.css">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="/css/beheer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column">
        <?php require_once('./parts/nav-beheer.html'); ?>
        <div class="container mt-4">
            <h1 class="mb-2" id="greeting"></h1>
            <p class="mb-4">Bekijk wat je kan doen als &lt;rol&gt;</p>
            <div class="row g-3">
                <a class="col-6 col-md-4 text-decoration-none" href="#">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-calendar3 mb-2 fs-1"></i>
                        <h5>Bekijk evenementen</h5>
                    </div>
                </a>
                <a class="col-6 col-md-4 text-decoration-none" href="#">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-people mb-2 fs-1"></i>
                        <h5>Bekijk verenigingen</h5>
                    </div>
                </a>
                <a class="col-6 col-md-4 text-decoration-none" href="#">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-person mb-2 fs-1"></i>
                        <h5>Bekijk gebruikers</h5>
                    </div>
                </a>
                <a class="col-6 col-md-4 text-decoration-none" href="./event-aanmaken">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-calendar-plus mb-2 fs-1"></i>
                        <h5>Maak een nieuw evenement aan</h5>
                    </div>
                </a>
                <a class="col-6 col-md-4 text-decoration-none" href="#">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-plus-square mb-2 fs-1"></i>
                        <h5>Voeg een nieuwe vereniging toe</h5>
                    </div>
                </a>
                <a class="col-6 col-md-4 text-decoration-none" href="#">
                    <div class="p-4 bg-light text-center shadow rounded">
                        <i class="bi bi-person-plus mb-2 fs-1"></i>
                        <h5>Maak een nieuwe gebruiker aan</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/form-validatie.js"></script>
    <script src="/js/image-preview.js"></script>
    <script src="/js/animaties.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const greetingElement = document.getElementById("greeting");
            const currentHour = new Date().getHours();
            let greetingText = "Goedemorgen";

            if (currentHour >= 12 && currentHour < 18) {
                greetingText = "Goedemiddag";
            } else if (currentHour >= 18 || currentHour < 6) {
                greetingText = "Goedenavond";
            }

            greetingElement.textContent = `${greetingText}, <naam>`;
        });
    </script>

</body>
</html>