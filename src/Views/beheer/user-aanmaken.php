<?php
use App\Models\EventsModel;
use App\Models\UserModel;
use App\Models\KledingModel;
use App\Models\RolModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>Beheer | Gebruikers aanmaken</title>

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
        <?php require_once('./parts/nav.html'); ?>
        <div class="container my-4 pb-4">
            <h1 class="text-center mb-4">Gebruiker aanmaken</h1>

            <!-- Form 1: Event Details -->
            <form id="formEventDetails" class="needs-validation" novalidate action="<?php $_PHP_SELF ?>" method="POST">
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="voorNaam" class="form-label">Voornaam <span class="verplicht">*</span></label>
                        <input type="text" class="form-control" id="voorNaam" name="voorNaam" placeholder="Voornaam" required>
                        <div class="invalid-feedback">Voer een voornaam in.</div>
                    </div>
                    <div class="col-md-3">
                        <label for="achterNaam" class="form-label">Achternaam <span class="verplicht">*</span></label>
                        <input type="text" class="form-control" id="achterNaam" name="achterNaam" placeholder="Achternaam" required>
                        <div class="invalid-feedback">Voer een achternaam in.</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="verplicht">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email@example.com" required>
                    <div class="invalid-feedback">Voer een (geldig) email-adres in.</div>
                </div>
                <div class="mb-3">
                    <label for="telefoon" class="form-label">Telefoon <span class="verplicht">*</span></label>
                    <input type="text" class="form-control" id="telefoon" name="telefoon" placeholder="" required>
                    <div class="invalid-feedback">Voer een telefoonnummer in.</div>
                </div>
                <div class="mb-3">
                    <label for="postcode" class="form-label">Postcode</label>
                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="1234 AB">
                    <div class="invalid-feedback">Voer een geldig postcode in.</div>
                </div>
                <div class="mb-3">
                    <label for="huisnummer" class="form-label">Huisnummer</label>
                    <input type="text" class="form-control" id="huisnummer" name="huisnummer" placeholder="123">
                    <div class="invalid-feedback">Voer een geldig huisnummer in.</div>
                </div>
                <div class="mb-3">
                    <label for="plaatsnaam" class="form-label">Plaatsnaam</label>
                    <input type="text" class="form-control" id="plaatsnaam" name="plaatsnaam" placeholder="">
                    <div class="invalid-feedback">Voer een locatie in.</div>
                </div>
                <div class="mb-3">
                    <label for="wachtwoord" class="form-label">Wachtwoord <span class="verplicht">*</span></label>
                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">Voer een wachtwoord in.</div>
                </div>
                
                <?php
                    $rol = new RolModel();
                    $allRoles = $rol->getAllRoles();
                ?>
         
<div class="mb-3">
    <label class="form-label">Rol <span class="verplicht">*</span></label>
    <div id="rol" class="form-check-group">
        <?php foreach($allRoles as $key => $rol): ?>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="rol_<?= $rol->getID() ?>" 
                    name="rol[]" 
                    value="<?= $rol->getID() ?>" 
                    required
                >
                <label 
                    class="form-check-label" 
                    for="rol_<?= $rol->getID() ?>"
                >
                    <?= htmlspecialchars($rol->getName()) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="invalid-feedback">Selecteer minstens één rol.</div>
</div>

                <?php
                    $kleding = new kledingModel();
                    $allKleding = $kleding->getAllKledingMaten();
                ?>
                <div class="mb-3">
                    <label for="kledingmaat" class="form-label">Kledingmaat</label>
                    <select class="form-control" id="kledingmaat" name="kledingmaat">
                        <option value="" disabled selected>Selecteer een kledingmaat</option>
                        <?php foreach($allKleding as $key => $kledingmaat): ?>?>
                            <option value="<?=$kledingmaat->getID() ?>"><?=$kledingmaat->getKledingmaat() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecteer een kledingmaat.</div>
                </div>
                
                <!-- <div class="mb-3">
                    <label for="profielfoto" class="form-label">Profielfoto</label>
                    <input type="file" class="form-control" id="profielfoto" name="profielfoto" accept="image/png" onchange="previewImage(event)">
                    <div class="invalid-feedback">Kies een profielfoto.</div>
                </div>

                <div class="mb-3">
                    <img id="imagePreview" src="#" alt="Afbeelding Preview" class="img-fluid" style="display: none; max-height: 200px; object-fit: cover;">
                </div> -->

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                    <button type="submit" class="btn btn-primary" id="btnToForm2">Opslaan</button>
                </div>
            </form>

            <div id="successMessage" style="display:none;" class="alert alert-success mt-4">
                🎉 
                Gebruiker succesvol aangemaakt!
            </div>
            <div id="successMessage" style="display:none;" class="alert alert-danger mt-4">
                Fout bij het aanmaken van de gebruiker. Probeer het later opnieuw.
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
        document.getElementById("addDay").addEventListener("click", function() {
            const container = document.getElementById("userDatesContainer");
            const newDay = document.createElement("div");
            newDay.classList.add("mb-3", "row");
            newDay.innerHTML = `
                <div class="col-md-4">
                    <label for="eventDate" class="form-label">Datum <span class="verplicht">*</span></label>
                    <input type="date" class="form-control" name="date[]" required>
                    <div class="invalid-feedback">Selecteer een datum.</div>
                </div>
                <div class="col-md-4">
                    <label for="eventBeginTime" class="form-label">Begintijd <span class="verplicht">*</span></label>
                    <input type="time" class="form-control" name="begin-time[]" required>
                    <div class="invalid-feedback">Voer een begintijd in.</div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="flex-grow-1">
                        <label for="eventEndTime" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                        <input type="time" class="form-control" name="end-time[]" required>
                        <div class="invalid-feedback">Voer een eindtijd in.</div>
                    </div>
                    <button class="btn btn-danger ms-2 remove-day"><i class="bi bi-trash text-white"></i></button>
                </div>
            `;
            container.appendChild(newDay);
        });

        document.getElementById("userDatesContainer").addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-day") || event.target.closest(".remove-day")) {
                event.target.closest(".row").remove();
            }
        });
    </script>
</body>
</html>

