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
<?php require_once("./parts/nav.html"); ?>

<main class="container py-4">
    <div class="row g-4">

        <div class="col-lg-7 col-xl-8 order-2 order-lg-1">
            <div class="nav-buttons d-flex flex-column flex-sm-row gap-2 mb-3">
                <button class="btn btn-primary">Alle</button>
                <button class="btn btn-primary">Sport</button>
                <button class="btn btn-primary">Cultuur</button>
                <button class="btn btn-primary">School</button>
                <button class="btn btn-primary">Gamen</button>
            </div>

            <input type="text" id="search-input-top" class="form-control rounded-2" placeholder="Search events..." onkeyup="filterEvents();">

            <div class="accordion mt-3" id="eventsAccordion">
                <?php if (!empty($events)): ?>
                <?php foreach ($events as $index => $event): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                            <?= htmlspecialchars($event->getEventName()) ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#eventsAccordion">
                        <div class="accordion-body">
                            <p><?= htmlspecialchars($event->getEventInfo()) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5 col-xl-4 order-1 order-lg-2 pt-lg-5">
            <div class="calendar p-3 w-100" style="max-width: 100%;">
                <div class="calendar-header d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-light btn-sm" onclick="prevMonth()">&lt;</button>
                    <h3 class="px-2 mb-0" id="calendar-month-year"></h3>
                    <button class="btn btn-outline-light btn-sm" onclick="nextMonth()">&gt;</button>
                </div>
                <table class="table table-borderless text-center mt-3" style="--bs-table-bg: transparent; --bs-table-color: white;">
                    <thead>
                    <tr>
                        <th class="fw-normal text-white-50">ma</th>
                        <th class="fw-normal text-white-50">di</th>
                        <th class="fw-normal text-white-50">wo</th>
                        <th class="fw-normal text-white-50">do</th>
                        <th class="fw-normal text-white-50">vr</th>
                        <th class="fw-normal text-white-50">za</th>
                        <th class="fw-normal text-white-50">zo</th>
                    </tr>
                    </thead>
                    <tbody id="calendar-days">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="../../js/bootstrap.bundle.js"></script>
<script src="../../js/script.js"></script>
<script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="../../js/animaties.js"></script>
<script src="../../js/searchbar.js"></script>
<script src="../../js/calendar.js"></script>
<script>
    function filterEvents() {
        const searchQuery = document.getElementById("search-input-top").value.toLowerCase();
        const accordionItems = document.querySelectorAll(".accordion-item");

        accordionItems.forEach(item => {
            const titleElement = item.querySelector(".accordion-button");
            const descriptionElement = item.querySelector(".accordion-body p");

            if (titleElement && descriptionElement) {
                const title = titleElement.innerText.toLowerCase();
                const description = descriptionElement.innerText.toLowerCase();

                if (title.includes(searchQuery) || description.includes(searchQuery)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            }
        });
    }
</script>
</body>
</html>