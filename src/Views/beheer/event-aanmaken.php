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
        <?php require_once('./parts/nav-beheer.html'); ?>
        <div class="container my-4 pb-4">
            <h1 class="text-center mb-4">Event Aanmaken</h1>
            <form action="" class="needs-validation" novalidate method="POST">
                <div class="mb-3">
                    <label for="eventTitle" class="form-label">Titel <span class="verplicht">*</span></label>
                    <input type="text" class="form-control" id="eventTitle" name="title" placeholder="Event titel" required>
                    <div class="invalid-feedback">Voer een titel in.</div>
                </div>

                <div class="mb-3">
                    <label for="eventDescription" class="form-label">Beschrijving <span class="verplicht">*</span></label>
                    <textarea class="form-control" id="eventDescription" name="description" rows="5" placeholder="Beschrijf het event" required></textarea>
                    <div class="invalid-feedback">Voer een beschrijving in.</div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="eventDate" class="form-label">Datum <span class="verplicht">*</span></label>
                        <input type="date" class="form-control" id="eventDate" name="date" required>
                        <div class="invalid-feedback">Selecteer een datum.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="eventBeginTime" class="form-label">Begintijd <span class="verplicht">*</span></label>
                        <input type="time" class="form-control" id="eventBeginTime" name="begin-time" required>
                        <div class="invalid-feedback">Voer een begintijd in.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="eventEndTime" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                        <input type="time" class="form-control" id="eventEndTime" name="end-time" required>
                        <div class="invalid-feedback">Voer een eindtijd in.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="eventLocation" class="form-label">Locatie <span class="verplicht">*</span></label>
                    <input type="text" class="form-control" id="eventLocation" name="location" placeholder="Event locatie" required>
                    <div class="invalid-feedback">Voer een locatie in.</div>
                </div>

                <div class="mb-3">
                    <label for="eventImage" class="form-label">Afbeelding <span class="verplicht">*</span></label>
                    <input type="file" class="form-control" id="eventImage" name="image" accept="image/png" onchange="previewImage(event)" required>
                    <div class="invalid-feedback">Kies een afbeelding.</div>
                </div>

                <div class="mb-3">
                    <img id="imagePreview" src="#" alt="Afbeelding Preview" class="img-fluid" style="display: none; max-height: 200px; object-fit: cover;">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                    <button type="submit" class="btn btn-primary">Volgende</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/form-validatie.js"></script>
    <script src="/js/image-preview.js"></script>
    <script src="/js/animaties.js"></script>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['fname']);
        if (empty($name)) {
          echo "Name is empty";
        } else {
          echo $name;
        }
      }
?>