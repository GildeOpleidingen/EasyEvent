
<?php

use App\Conn;

$activities = [];
$databaseUnavailable = false;

try {
    $db = Conn::getPDO();

    $sql = "
        SELECT
            e.id AS event_id,
            e.naam AS event_name,
            a.naam AS activity_name,
            et.datum AS event_date,
            aet.begin_tijd AS start_time,
            aet.eind_tijd AS end_time,
            COALESCE(
                NULLIF(aet.locatie, ''),
                CONCAT_WS(', ',
                    et.straatnaam,
                    et.huisnummer,
                    et.postcode,
                    et.plaatsnaam,
                    et.land
                )
            ) AS location,
            aet.aantal_personen AS volunteer_capacity,
            (
                SELECT COUNT(*)
                FROM inschrijving i
                WHERE i.event_tijd_id = et.id
            ) AS registered_volunteers
        FROM activiteit_event_tijd aet
        INNER JOIN activiteit a
            ON a.id = aet.activiteit_id
        INNER JOIN event_tijd et
            ON et.id = aet.event_tijd_id
        INNER JOIN event e
            ON e.id = et.event_id
        WHERE et.datum >= CURDATE()
          AND a.removed = 0
          AND e.removed = 0
        ORDER BY et.datum ASC, aet.begin_tijd ASC
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $allActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allActivities as $activity) {
        $spotsAvailable =
            (int) $activity['volunteer_capacity']
            - (int) $activity['registered_volunteers'];

        if ($spotsAvailable > 0) {
            $activities[] = $activity;
        }
    }

} catch (\Throwable $e) {
    $databaseUnavailable = true;
    error_log('Activiteiten ophalen mislukt: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyEvents | Vrijwilligers</title>
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="/css/vrijwilligers.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<main class="container volunteer-page py-4">
    <?php require __DIR__ . '/../../parts/nav.php'; ?>

    <section class="volunteer-hero mb-4">
        <span class="volunteer-eyebrow"><i class="" aria-hidden="true"></i> Doe mee</span>
        <p>Bekijk welke activiteiten nog hulp kunnen gebruiken en kies een moment dat bij je past.</p>
        <a href="#open-activiteiten" class="btn btn-primary">Bekijk open activiteiten <i class="bi bi-arrow-down" aria-hidden="true"></i></a>
    </section>

    <section id="open-activiteiten" aria-labelledby="activities-heading">
        <div class="volunteer-section-heading">
            <div>
                <h2 id="activities-heading">Open activiteiten</h2>
            </div>
            <span class="volunteer-count">
                <?= count($activities) ?> <?= count($activities) === 1 ? 'activiteit' : 'activiteiten' ?>
            </span>
        </div>

        <?php if (!empty($databaseUnavailable)): ?>
            <div class="alert alert-warning" role="alert">
                <strong>Activiteiten laden niet. Check DB</strong>
            </div>
        <?php elseif (empty($activities)): ?>
            <div class="volunteer-empty">
                <i class="bi bi-calendar-heart" aria-hidden="true"></i>
                <h3>Er zijn nog geen open activiteiten</h3>
                <p>Er staan nu geen toekomstige activiteiten met vrije vrijwilligersplekken in de agenda. Bekijk later nog eens wat er beschikbaar is.</p>
                <a href="/events" class="btn btn-outline-primary">Bekijk evenementen</a>
            </div>
        <?php else: ?>
            <div class="volunteer-activity-list">
                <?php foreach ($activities as $activity):
                    $activityDate = strtotime($activity['event_date']);
                    $spotsAvailable = max(0, (int)$activity['volunteer_capacity'] - (int)$activity['registered_volunteers']);
                ?>
                    <article class="volunteer-card">
                        <div class="volunteer-date" aria-label="<?= htmlspecialchars(date('d-m-Y', $activityDate)) ?>">
                            <span><?= htmlspecialchars(date('M', $activityDate)) ?></span>
                            <strong><?= htmlspecialchars(date('d', $activityDate)) ?></strong>
                        </div>
                        <div class="volunteer-card-content">
                            <span class="volunteer-card-event"><?= htmlspecialchars($activity['event_name']) ?></span>
                            <h3><?= htmlspecialchars($activity['activity_name']) ?></h3>
                            <ul class="volunteer-details">
                                <li><i class="bi bi-clock" aria-hidden="true"></i> <?= htmlspecialchars(substr($activity['start_time'], 0, 5)) ?>–<?= htmlspecialchars(substr($activity['end_time'], 0, 5)) ?></li>
                                <li><i class="bi bi-geo-alt" aria-hidden="true"></i> <?= htmlspecialchars($activity['location']) ?></li>
                                <li><i class="bi bi-people" aria-hidden="true"></i> <?= $spotsAvailable ?> <?= $spotsAvailable === 1 ? 'plek vrij' : 'plekken vrij' ?></li>
                            </ul>
                        </div>
                        <?php if (isset($_SESSION['gebruiker'])): ?>
                            <a class="btn btn-primary volunteer-action" href="/event-info?eventID=<?= (int)$activity['event_id'] ?>">Bekijk &amp; meld je aan</a>
                        <?php else: ?>
                            <a class="btn btn-primary volunteer-action" href="/login">Log in om je aan te melden</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="volunteer-help mt-5">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <p class="mb-0"><strong>Hoe werkt aanmelden?</strong> Open een evenement, bekijk de activiteit en kies je beschikbare moment. Inloggen is nodig om je plek vast te leggen.</p>
    </section>
</main>
<script src="/js/bootstrap.bundle.js"></script>
</body>
</html>
