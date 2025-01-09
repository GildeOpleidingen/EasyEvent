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
        <?php require_once('./parts/nav-beheer.html'); ?>
        <div class="container my-4 pb-4">
            <h1 class="text-center mb-4">Event Aanmaken</h1>

            <div class="progress mb-4 fixed-top rounded-0">
                <div class="progress-bar rounded-0" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    Stap 1 van de 2
                </div>
            </div>
            
            <!-- Form 1: Event Details -->
            <form id="formEventDetails" class="needs-validation" novalidate action="<?php $_PHP_SELF ?>" method="POST">
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
                    <div class="col-md-6">
                        <label for="eventCountry" class="form-label">Land <span class="verplicht">*</span></label>
                        <select class="form-select" id="eventCountry" name="Country" required>
                            <option value="Netherland" selected>Nederland</option>
                            <option value="Belgium">België</option>
                            <option value="Germany">Duitsland</option>
                            <option value="Luxembourg">Luxemburg</option>
                        </select>
                        <div class="invalid-feedback">Voer een locatie in.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="Placename" class="form-label">Plaatsnaam <span class="verplicht">*</span></label>
                        <input type="text" class="form-control" id="eventPlacename" name="Placename" placeholder="Amsterdam" required>
                        <div class="invalid-feedback">Voer een locatie in.</div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-7">
                        <label for="Streetname" class="form-label">Straatnaam</label>
                        <input type="text" class="form-control" id="eventStreetname" name="Streetname" placeholder="Kalverstraat">
                        <div class="invalid-feedback">Voer een locatie in.</div>
                    </div>
                    <div class="col-md-3">
                        <label for="Address" class="form-label">Postcode <span class="verplicht">*</span></label>
                        <input type="text" class="form-control" id="eventAddress" name="Address" placeholder="1234 AB" required>
                        <div class="invalid-feedback">Voer een geldig postcode in.</div>
                    </div>
                    <div class="col-md-2">
                        <label for="Homenumber" class="form-label">Huisnummer</label>
                        <input type="text" class="form-control" id="eventHomenumber" name="Homenumber" placeholder="1">
                        <div class="invalid-feedback">Voer een locatie in.</div>
                    </div>
                </div>
                
                <div class="mb-3 row" id="eventDatesContainer">
                    <div class="col-md-4">
                        <label for="eventDate" class="form-label">Datum <span class="verplicht">*</span></label>
                        <input type="date" class="form-control" id="eventDate" name="date[]" required>
                        <div class="invalid-feedback">Selecteer een datum.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="eventBeginTime" class="form-label">Begintijd <span class="verplicht">*</span></label>
                        <input type="time" class="form-control" id="eventBeginTime" name="begin-time[]" required>
                        <div class="invalid-feedback">Voer een begintijd in.</div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="flex-grow-1">
                            <label for="eventEndTime" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                            <input type="time" class="form-control" id="eventEndTime" name="end-time[]" required>
                            <div class="invalid-feedback">Voer een eindtijd in.</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mb-3" id="addDay">
                    <i class="bi bi-plus text-white"></i>
                </button>

                <div class="mb-3">
                    <label for="eventBanner" class="form-label">Banner <span class="verplicht">*</span></label>
                    <input type="file" class="form-control" id="eventBanner" name="banner" accept="image/png" onchange="previewImage(event)" required>
                    <div class="invalid-feedback">Kies een Banner.</div>
                </div>

                <div class="mb-3">
                    <img id="imagePreview" src="#" alt="Afbeelding Preview" class="img-fluid" style="display: none; max-height: 200px; object-fit: cover;">
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Sub-events toevoegen
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                    <button type="button" class="btn btn-primary" id="btnToForm2">Volgende</button>
                </div>
            </form>
            
            <!-- Form 2: SubEvents aanmaken -->
            <form id="formSubEvents" class="needs-validation" style="display: none;" novalidate>
                <h2 class="text-center mb-4">Sub-Events Toevoegen</h2>
                <div id="subEventsContainer">
                    <!-- SubEvent 1 -->
                    <div class="sub-event-item mb-4 border rounded p-3">
                        <h5>Sub-Event 1</h5>
                        <div class="mb-3">
                            <label for="subEventTitle1" class="form-label">Titel <span class="verplicht">*</span></label>
                            <input type="text" class="form-control" id="subEventTitle1" name="subevent-title[]" placeholder="Sub-event titel" required>
                            <div class="invalid-feedback">Voer een titel in.</div>
                        </div>
                        <div class="mb-3">
                            <label for="subEventDescription1" class="form-label">Beschrijving <span class="verplicht">*</span></label>
                            <textarea class="form-control" id="subEventDescription1" name="subevent-description[]" rows="3" placeholder="Beschrijf het sub-event" required></textarea>
                            <div class="invalid-feedback">Voer een beschrijving in.</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="subEventDate1" class="form-label">Datum <span class="verplicht">*</span></label>
                                <input type="date" class="form-control" id="subEventDate1" name="subevent-date[]" required>
                                <div class="invalid-feedback">Selecteer een datum.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="subEventBeginTime1" class="form-label">Begintijd <span class="verplicht">*</span></label>
                                <input type="time" class="form-control" id="subEventBeginTime1" name="subevent-begin-time[]" required>
                                <div class="invalid-feedback">Voer een begintijd in.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="subEventEndTime1" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                                <input type="time" class="form-control" id="subEventEndTime1" name="subevent-end-time[]" required>
                                <div class="invalid-feedback">Voer een eindtijd in.</div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger remove-sub-event"><i class="bi bi-trash"></i> Verwijder Sub-Event</button>
                    </div>
                </div>

                <!-- Button to Add Sub-Events -->
                <button type="button" class="btn btn-outline-primary mb-3" id="addSubEvent">
                    <i class="bi bi-plus"></i> Voeg Sub-Event Toe
                </button>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="btnToFormEvent">Terug</button>
                    <button type="submit" class="btn btn-primary" id="btnToForm3">Opslaan</button>
                </div>
            </form>

            <!-- Form 3: Activities -->
            <form id="formActivities" class="needs-validation" style="display: none;" novalidate>
                <div id="activitiesContainer">
                    <div class="activity-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="activityName1" class="form-label">Naam <span class="verplicht">*</span></label>
                                <input type="text" class="form-control" id="activityName1" name="activity-name[]" placeholder="Activiteit Naam" required>
                                <div class="invalid-feedback">Voer een activiteit naam in.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="activityTime1" class="form-label">Tijd <span class="verplicht">*</span></label>
                                <input type="time" class="form-control" id="activityTime1" name="activity-time[]" required>
                                <div class="invalid-feedback">Voer een activiteit tijd in.</div>
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
                    <button type="button" class="btn btn-secondary" id="btnToFormActivity">Terug</button>
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

    const progressBar = document.querySelector(".progress-bar");

    const formEventDetails = document.getElementById("formEventDetails");
    const formSubEvents = document.getElementById("formSubEvents");
    const formActivities = document.getElementById("formActivities");
    const btnToForm2 = document.getElementById("btnToForm2");
    const btnToFormEvent = document.getElementById("btnToFormEvent");
    const btnToFormActivity = document.getElementById("btnToFormActivity");
    const subEventCheckbox = document.getElementById("flexCheckChecked");

    function updateProgressBar(step) {
        const totalSteps = subEventCheckbox.checked ? 3 : 2;
        if (step === 1) {
            progressBar.style.width = `${100 / totalSteps}%`;
            progressBar.textContent = `Stap 1 van de ${totalSteps}`;
        } else if (step === 2) {
            progressBar.style.width = `${(2 * 100) / totalSteps}%`;
            progressBar.textContent = `Stap 2 van de ${totalSteps}`;
        } else if (step === 3 && totalSteps === 3) {
            progressBar.style.width = "100%";
            progressBar.textContent = "Stap 3 van de 3";
        }
    }

    btnToForm2.addEventListener("click", () => {
        if (subEventCheckbox.checked) {
            formEventDetails.style.display = "none";
            formSubEvents.style.display = "block";
            formActivities.style.display = "none";
            updateProgressBar(2);
        } else {
            formEventDetails.style.display = "none";
            formSubEvents.style.display = "none";
            formActivities.style.display = "block";
            updateProgressBar(2);
        }
    });

    btnToFormEvent.addEventListener("click", () => {
        formSubEvents.style.display = "none";
        formActivities.style.display = "none";
        formEventDetails.style.display = "block";
        updateProgressBar(1);
    });

    btnToFormActivity.addEventListener("click", () => {
        formActivities.style.display = "block";
        formSubEvents.style.display = "none";
        formEventDetails.style.display = "none";
        updateProgressBar(3);
    });

    subEventCheckbox.addEventListener("change", () => {
        updateProgressBar(1);
    });

    const subEventsContainer = document.getElementById("subEventsContainer");
    const addSubEventBtn = document.getElementById("addSubEvent");

    let subEventCount = 1;

    function createSubEventBlock(index) {
        const subEventBlock = document.createElement("div");
        subEventBlock.classList.add("sub-event-item", "mb-4", "border", "rounded", "p-3");
        subEventBlock.innerHTML = `
            <h5>Sub-Event ${index}</h5>
            <div class="mb-3">
                <label for="subEventTitle${index}" class="form-label">Titel <span class="verplicht">*</span></label>
                <input type="text" class="form-control" id="subEventTitle${index}" name="subevent-title[]" placeholder="Sub-event titel" required>
                <div class="invalid-feedback">Voer een titel in.</div>
            </div>
            <div class="mb-3">
                <label for="subEventDescription${index}" class="form-label">Beschrijving <span class="verplicht">*</span></label>
                <textarea class="form-control" id="subEventDescription${index}" name="subevent-description[]" rows="3" placeholder="Beschrijf het sub-event" required></textarea>
                <div class="invalid-feedback">Voer een beschrijving in.</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="subEventDate${index}" class="form-label">Datum <span class="verplicht">*</span></label>
                    <input type="date" class="form-control" id="subEventDate${index}" name="subevent-date[]" required>
                    <div class="invalid-feedback">Selecteer een datum.</div>
                </div>
                <div class="col-md-4">
                    <label for="subEventBeginTime${index}" class="form-label">Begintijd <span class="verplicht">*</span></label>
                    <input type="time" class="form-control" id="subEventBeginTime${index}" name="subevent-begin-time[]" required>
                    <div class="invalid-feedback">Voer een begintijd in.</div>
                </div>
                <div class="col-md-4">
                    <label for="subEventEndTime${index}" class="form-label">Eindtijd <span class="verplicht">*</span></label>
                    <input type="time" class="form-control" id="subEventEndTime${index}" name="subevent-end-time[]" required>
                    <div class="invalid-feedback">Voer een eindtijd in.</div>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-sub-event">
                <i class="bi bi-trash"></i> Verwijder Sub-Event
            </button>
        `;
        return subEventBlock;
    }

    addSubEventBtn.addEventListener("click", () => {
        subEventCount++;
        const newSubEvent = createSubEventBlock(subEventCount);
        subEventsContainer.appendChild(newSubEvent);
    });

    subEventsContainer.addEventListener("click", (event) => {
        if (event.target.classList.contains("remove-sub-event") || event.target.closest(".remove-sub-event")) {
            event.target.closest(".sub-event-item").remove();
        }
    });

    document.getElementById("formSubEvents").addEventListener("submit", (event) => {
        event.preventDefault();

        if (!formSubEvents.checkValidity()) {
            formSubEvents.classList.add("was-validated");
            return;
        }

        alert("Sub-Events succesvol opgeslagen!");
    });
</script>

</body>
</html>

<?php
//event
$title;
$description;
$date = [];
$location = [];
$banner;

//subevent
$subEventCount = 0;
$subEventTitle = [];
$subEventDescription = [];
$subEventDate = [];

//activity
$activityCount = 0;
$activityTitle = [];
$activityTime = [];
$activityPeople = [];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['location']) && isset($_POST['banner'])) {
    if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['title'])) {
        $title = htmlspecialchars($_POST['title']);
    }
    if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['description'])) {
        $description = htmlspecialchars($_POST['description']);
    }
    if (isset($_POST['Placename']) && preg_match("/[éèêüåäöçñØ,.\-\'&\s]/u",$_POST['Placename'])) {
        $location = htmlspecialchars($_POST['Placename']);
    }
    if (isset($_POST['date[]']) && isset($_POST['begin-time[]']) && isset($_POST['end-time[]'])) {
        // $date[] = $_POST['date[]'];    
    }
    if (isset($_POST['Country']) && $_POST['Country'] == "Netherland") {
        if (isset($_POST['Address']) && !preg_match("/^\d{4}\s[A-Z]{2}$/", $_POST['Address'])) {
            $errors[] = "De postcode moet bestaan uit 4 cijfers, een spatie, en 2 hoofdletters.";
        }
    } else if (isset($_POST['Country']) && $_POST['Country'] == "België"){
        if (isset($_POST['Address']) && !preg_match("/^\d{4}$/", $_POST['Address'])) {
            $errors[] = "De postcode moet bestaan uit 4 cijfers";
        }
    } else if (isset($_POST['Country']) && $_POST['Country'] == "Duitsland"){
        if (isset($_POST['Address']) && !preg_match("/^\d{5}$/", $_POST['Address'])) {
            $errors[] = "De postcode moet bestaan uit 5 cijfers";
        }
    } else if (isset($_POST['Country']) && $_POST['Country'] == "Luxemburg"){
        if (isset($_POST['Address']) && !preg_match("/^\d{4}$/", $_POST['Address'])) {
            $errors[] = "De postcode moet bestaan uit 4 cijfers";
        }
    }
    if (isset($_POST['banner'])) {
        $img = file_get_contents($_POST['banner']);
        $data = base64_encode($img);
    }
    if (!$title && !$description && !$location && !$date && !$banner) {
        $event = new EventsModel($title,$description,$location,$date,$banner);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subEventTitle1"]) && isset($_POST["subEventDescription1"]) && isset($_POST["subEventDate1"])){
    $subEventCount++;
    if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['subEventTitle1'])) {
        $title = htmlspecialchars($_POST['subEventTitle1']);
    }
    if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['subEventDescription1'])) {
        $description = htmlspecialchars($_POST['subEventDescription1']);
    }
    if (isset($_POST['subEventDate[]']) && isset($_POST['subEventBeginTime[]']) && isset($_POST['subEventEndTime[]'])) {
        // $date[] = $_POST['date[]'];    
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["activityName1"]) && isset($_POST["activityTime1"]) && isset($_POST["activityPeople1"])){
    $activityCount++;
    if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['activityTitle'])) {
        $description = htmlspecialchars($_POST['activityTitle']);
    }
    if (isset($_POST['begin-time[]'])) {
        // $date[] = $_POST['date[]'];    
    }
}
?>