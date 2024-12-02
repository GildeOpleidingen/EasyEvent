<?php
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

    <title>EasyEvents | Eventinformatie</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/event-info.css">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="/css/event-info.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column">
        <?php require_once("./parts/nav.html"); ?>
        
        <div class="flex-grow-1 position-relative d-flex align-items-center justify-content-center rounded-4 mb-4 bg-dark" 
            style="background-image: url('../../images/bokkenollen.jpg'); background-size: cover; background-position: center;">
            
            <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4 bg-dark opacity-50"></div>
            
            <div class="position-relative text-white px-3">
                <h1 class="text-uppercase underline mb-4">Bokkenollen</h1>
            </div>
            
            <div class="position-absolute text-white top-50 end-0 translate-middle-y text-dark rounded-3 shadow p-4 me-4" style="width: 300px; background-color: rgba(254, 141, 38, 0.5);">
                <h5 class="fw-bold">12 - 13 oktober 2024</h5>
                <p class="mb-2">10:00 - 18:00</p>
                <p class="small">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem similique unde eum aperiam praesentium nobis beatae facilis assumenda? Dolor, vitae? Esse, recusandae ipsa. Esse ipsum illum possimus quod minus est expedita modi fugiat natus?
                </p>
                <p class="small mb-4">
                    Tempora voluptates ipsa voluptatem earum pariatur, exercitationem omnis dicta? Omnis aliquid placeat alias accusantium cum!
                </p>
                <p class="small mb-4">
                    Tempora voluptates ipsa voluptatem earum pariatur, exercitationem omnis dicta? Omnis aliquid placeat alias accusantium cum!
                </p>
                <a href="#" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#activiteiten">Bekijk de activiteiten</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="activiteiten" tabindex="-1" aria-labelledby="activiteitenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activiteitenModalLabel">Selecteer Activiteiten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="activityForm">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activity1" name="activities" value="Activity 1">
                            <label class="form-check-label" for="activity1">Activity 1</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activity2" name="activities" value="Activity 2">
                            <label class="form-check-label" for="activity2">Activity 2</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activity3" name="activities" value="Activity 3">
                            <label class="form-check-label" for="activity3">Activity 3</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitActivities()">Bevestig</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
    <script src="../../js/bootstrap.bundle.js"></script>

    <script>
        function submitActivities() {
            const selectedActivities = Array.from(document.querySelectorAll('input[name="activities]:checked')).map(input => input.value);
            console.log('Selected activities: ', selectedActivities);
            alert("Selected activities: " + selectedActivities.join(', '));
        }
    </script>
</body>
</html>

