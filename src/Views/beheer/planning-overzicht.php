<?php

use App\Models\ActivityModel;
use App\Models\PlanningsModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$activiteitID = $_GET['activiteitID'];

$activity = ActivityModel::getActiviteitById($activiteitID);

$planning = PlanningsModel::getPlanning($activiteitID);
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
        <h1 class="text-center mb-4">Planning 
                <?php if (!empty($activiteitID)): ?>
                    <?= $activity['naam'];
                ?>
        </h1>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Activiteit</th>
                    <th scope="col">Activiteit Start Tijd</th>
                    <th scope="col">Activiteit Eind Tijd</th>
                    <th scope="col">Voornaam</th>
                    <th scope="col">Achternaam</th>
                    <th scope="col">Telefoon</th>
                    <th scope="col">Ingeplande Start Tijd</th>
                    <th scope="col">Ingeplande Eindtijd</th>
                    <th scope="col">Betaalt</th>
                    <th scope="col">Goedgekeurd</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($planning as $row): ?>
                    <tr>
                        <td>
                            <?=htmlspecialchars($row['activiteitNaam']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['activiteitBeginTijd']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['activiteitEindTijd']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['voornaam']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['achternaam']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['telefoon']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['planningBeginTijd']) ?>
                        </td>
                        <td>
                            <?=htmlspecialchars($row['planningEindTijd']) ?>
                        </td>
                        <td>
                            <?= $row['is_betaald'] ? "Ja" : "Nee"; ?>
                        </td>
                        <td>
                            <?= $row['goedgekeurd'] ? "Ja" : "Nee"; ?>
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
