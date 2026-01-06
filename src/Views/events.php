<?php 
use App\Models\SectorModel;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>EasyEvents | Events</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/events.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<div class="container py-4">
    <?php require_once("./parts/nav.php"); ?>

    <div class="row g-4">
        
        <!-- Category Buttons -->
        <div class="col-12">
            <div class="nav-buttons d-flex mb-3">
                <button class="btn btn-primary">Alle</button>

                <?php foreach (SectorModel::getAllSectors() as $key => $sector) {
                    echo '<button class="btn btn-primary">' . $sector->getSector() . '</button>';
                } ?>
            </div>
        </div>

        <!-- Event List Column -->
        <div class="col-lg-8">
            <input type="text"
                   id="search-input-top"
                   class="form-control rounded-2 mb-3"
                   placeholder="Search events..."
                   onkeyup="filterEvents();">
            
            <?php if (!empty($events)): ?>
                <div class="accordion" id="eventsAccordion">
                    <?php foreach ($events as $index => $event): ?>
                        <div class="accordion-item ev-item">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?= $index ?>"
                                        aria-expanded="false"
                                        aria-controls="collapse<?= $index ?>">
                                    <?= htmlspecialchars($event->getEventName()) ?>
                                </button>
                            </h2>

                            <div id="collapse<?= $index ?>"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#eventsAccordion">
                                <div class="accordion-body">
                                    <p><?= htmlspecialchars($event->getEventInfo()) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Calendar Column -->
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
                        <!-- JS will generate calendar days here -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- JS -->
<script src="../../js/bootstrap.bundle.js"></script>
<script src="../../js/script.js"></script>
<script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" crossorigin="anonymous"></script>
<script src="../../js/animaties.js"></script>
<script src="../../js/searchbar.js"></script>
<script src="../../js/tabs.js"></script>
<script src="../../js/calendar.js"></script>

<script>
    function filterEvents() {
        const query = document.getElementById("search-input-top").value.toLowerCase();
        const events = document.querySelectorAll(".ev-item");

        events.forEach(event => {
            const title = event.querySelector(".accordion-button").innerText.toLowerCase();
            const description = event.querySelector("p").innerText.toLowerCase();

            event.style.display = (title.includes(query) || description.includes(query))
                ? "block"
                : "none";
        });
    }
</script>

</body>
</html>
