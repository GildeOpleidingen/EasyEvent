<?php
use App\Models\EventsModel;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php 
$bevoegd = false;
if (isset($_SESSION['Gebruikersemail'])) {
    $gebruiker = unserialize($_SESSION['gebruiker']);
    $roles = $gebruiker->getRoles();
    foreach ($roles as $role) {
        if ($role == "Admin") {
            $bevoegd = true;
        }
    }
}
else {
    $roles = "";
}
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
        <h1 class="text-center mb-4">Event overzicht</h1>
        <?php if (!empty($events)): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Titel</th>
                <th scope="col">Activiteiten</th>
                <th scope="col">Bewerk</th>
                <?php if ($bevoegd): ?>
                <th scope="col">Verwijder</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($events as $index => $event): ?>
            <tr>
                <td>
                    <p><?= htmlspecialchars($event->getEventName()) ?></p>
                </td>
                <td>
                    <a href="/beheer/event/activiteiten?eventID=<?=$event->getEventID() ?>">Toon Activiteiten</a>
                </td>
                <td>
                    <a href="/beheer/event-bewerken?eventID=<?=$event->getEventID() ?>">Bewerk Event</a>
                </td>
                <?php if ($bevoegd): ?>
                <td>
                    <a href="/beheer/event/delete" onclick="return (confirm('Weet je zeker dat je dit evenement wilt verwijderen? Je kunt NIET meer terug!'));">Verwijder event</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/bootstrap.bundle.min.js"></script><script src="/js/animaties.js"></script>
</body>
</html>