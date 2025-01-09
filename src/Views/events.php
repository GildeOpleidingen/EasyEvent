<?php
use App\Conn;
use App\Models\EventsModel;

$events = EventsModel::generateEvents();

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

    <title>EasyEvents | Events</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/events.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid vh-100">
        <?php require_once("./parts/nav.html"); ?>
        
        <!-- tab 1 - Evementenlijst en kalender -->
        <div class="row g-4">
            <!-- Event List -->
            <div class="nav-buttons d-flex mb-3">
                <button class="btn btn-primary">Alle</button>
                <button class="btn btn-primary">Sport</button>
                <button class="btn btn-primary">Cultuur</button>
                <button class="btn btn-primary">School</button>
                <button class="btn btn-primary">Gamen</button>
            </div>
            <div class="container col-lg-8">
                <input type="text" id="search-input-top" class="form-control rounded-2 mb-3" placeholder="Search events..." onkeyup="filterEvents();">
                <!-- Event Items -->
                <?php foreach ($events as $event): ?>
                    <div class="event-item" style="background-image: url('../../images/<?= htmlspecialchars($event->getEventBanner()) ?>');">
                        <div class="event-date"><?= htmlspecialchars($event->getEventTime()[0]['date'] ?? 'Datum onbekend') ?></div>
                        <h3><?= htmlspecialchars($event->getEventName()) ?></h3>
                        <p><?= htmlspecialchars($event->getEventInfo()) ?></p>
                        <div class="more-info">
                            <a href="./event-info" class="btn btn-primary">Leer meer <i class="bi bi-chevron-right text-white"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Calendar -->
            <div class="col-lg-4 d-flex justify-content-center">
                <div class="calendar p-3">
                    <div class="calendar-header d-flex justify-content-between align-items-center">
                        <button class="btn btn-outline-light btn-sm" onclick="prevMonth()">&lt;</button>
                        <h3 class="px-2" id="calendar-month-year"></h3>
                        <button class="btn btn-outline-light btn-sm" onclick="nextMonth()">&gt;</button>
                    </div>
                    <table class="calendar-grid mt-4">
                        <tr>
                            <th>ma</th>
                            <th>di</th>
                            <th>wo</th>
                            <th>do</th>
                            <th>vr</th>
                            <th>za</th>
                            <th>zo</th>
                        </tr>
                        <tbody id="calendar-days">
                            <!-- JavaScript gaat hier de kalenderdagen genereren -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
    <script src="../../js/searchbar.js"></script>
    <script src="../../js/tabs.js"></script>
    <script src="../../js/calendar.js"></script>
    <script>
        function filterEvents() {
            const searchQuery = document.getElementById("search-input-top").value.toLowerCase();
            const events = document.querySelectorAll(".event-item");

            events.forEach(event => {
                const title = event.querySelector("h3").innerText.toLowerCase();
                const description = event.querySelector("p").innerText.toLowerCase();

                if (title.includes(searchQuery) || description.includes(searchQuery)) {
                    event.style.display = "block";
                } else {
                    event.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
