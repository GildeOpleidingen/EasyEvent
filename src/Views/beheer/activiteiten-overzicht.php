<?php

use App\Models\ActivityModel;
use App\Models\EventEditModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$eventid = $_GET['eventID'];

$planning = ActivityModel::getActiviteitenByEventId($eventid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>Beheer | Event overzicht</title>

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
        <h1 class="text-center mb-4">Activiteiten 
                <?php if (!empty($eventid)): ?>
                    <?= EventEditModel::getEventByID($eventid)['naam'];
                ?>
        </h1>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Activiteit</th>
                    <th scope="col">Activiteit Start Tijd</th>
                    <th scope="col">Activiteit Eind Tijd</th>
                    <th class="col">Planning</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($planning as $row): ?>
                    <tr>
                        <td>
                            <?=htmlspecialchars($row['activiteitNaam']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['activiteitBeginTijd']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['activiteitEindTijd']) ?>
                        </td>
                        <td>
                            <a href="/beheer/event/planning?activiteitID=<?= $row['activiteitID'] ?>">Toon Planning</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/form-validatie.js"></script>
<script src="/js/image-preview.js"></script>
<script src="/js/animaties.js"></script>
<script src="/js/activiteit-toevoegen.js"></script>
</body>
</html>
