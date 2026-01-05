<?php
use App\Models\EventsModel;
?>
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
    <link rel="stylesheet" href="/css/event-aanmaken.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container-fluid vh-100 d-flex flex-column">
        <?php require_once('./parts/nav.php'); ?>
        <div class="container my-4 pb-4">
            <h1 class="text-center mb-4">Event Aanmaken</h1>

            <!-- Form 2: Activities -->
            <form id="formActivities" class="needs-validation" novalidate method="POST">
                <div id="activitiesContainer">
                    <div class="activity-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="activityName1" class="form-label">Naam <span class="verplicht">*</span></label>
                                <input type="text" class="form-control" id="activityName1" name="activity-name[]" placeholder="Activiteit Naam" required>
                                <div class="invalid-feedback">Voer een activiteit naam in.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="activityBeginTime1" class="form-label">Begintijd <span class="verplicht">*</span></label>
                                <input type="time" class="form-control" id="activityBeginTime1" name="activity-begintime[]" required>
                                <div class="invalid-feedback">Voer een activiteit begin tijd in.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="activityEndTime1" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                                <input type="time" class="form-control" id="activityEndTime1" name="activity-endtime[]" required>
                                <div class="invalid-feedback">Voer een activiteit eind tijd in.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="activityPeople1" class="form-label">Aantal personen <span class="verplicht">*</span></label>
                                <input type="number" class="form-control" id="activityPeople1" name="activity-people[]" placeholder="Aantal personen" required>
                                <div class="invalid-feedback">Voer het aantal personen in voor de activiteit</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary mb-3" id="addActivity">
                    <i class="bi bi-plus"></i> Voeg Activiteit Toe
                </button>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="btnToForm1">Terug</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>

            <div id="successMessage" style="display:none;" class="alert alert-success mt-4">
                🎉 Evenement succesvol aangemaakt!
            </div>
            <div id="successMessage" style="display:none;" class="alert alert-danger mt-4">
                Fout bij het aanmaken van een evenement. Probeer het later opnieuw.
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/form-validatie.js"></script>
    <script src="/js/image-preview.js"></script>
    <script src="/js/animaties.js"></script>
    <script src="/js/activiteit-toevoegen.js"></script>

    <script>
        document.getElementById("formActivities").addEventListener("submit", function() {
            document.getElementById("successMessage").style.display = "block";
        });

        document.getElementById("eventDatesContainer").addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-day") || event.target.closest(".remove-day")) {
                event.target.closest(".row").remove();
            }
        });
    </script>
</body>
</html>