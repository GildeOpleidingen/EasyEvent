<?php
$activities = $activities ?? [];
$databaseUnavailable = $databaseUnavailable ?? false;
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

        <span class="volunteer-eyebrow">
            Doe mee
        </span>

        <p>
            Bekijk welke activiteiten nog hulp kunnen gebruiken en kies een moment dat bij je past.
        </p>

        <a href="#open-activiteiten" class="btn btn-primary">
            Bekijk open activiteiten
            <i class="bi bi-arrow-down" aria-hidden="true"></i>
        </a>

    </section>

    <section id="open-activiteiten" aria-labelledby="activities-heading">

        <div class="volunteer-section-heading">

            <div>
                <h2 id="activities-heading">
                    Open activiteiten
                </h2>
            </div>

            <span class="volunteer-count">
                <?= count($activities) ?>
                <?= count($activities) === 1 ? 'activiteit' : 'activiteiten' ?>
            </span>

        </div>

        <?php if ($databaseUnavailable): ?>

            <div class="alert alert-warning" role="alert">
                <strong>Activiteiten laden niet. Controleer de databaseverbinding of SQL-query.</strong>
            </div>

        <?php elseif (empty($activities)): ?>

            <div class="volunteer-empty">

                <i class="bi bi-calendar-heart" aria-hidden="true"></i>

                <h3>
                    Er zijn nog geen open activiteiten
                </h3>

                <p>
                    Er zijn momenteel geen activiteiten gevonden.
                    Bekijk later nog eens wat er beschikbaar is.
                </p>

                <a href="/events" class="btn btn-outline-primary">
                    Bekijk evenementen
                </a>

            </div>

        <?php else: ?>

            <div class="volunteer-activity-list">

                <?php foreach ($activities as $activity):

                    $activityDate = strtotime($activity['event_date']);
                    $registeredVolunteers = (int) $activity['registered_volunteers'];

                ?>

                    <article class="volunteer-card">

                        <div class="volunteer-date"
                             aria-label="<?= htmlspecialchars(date('d-m-Y', $activityDate)) ?>">

                            <span>
                                <?= htmlspecialchars(date('M', $activityDate)) ?>
                            </span>

                            <strong>
                                <?= htmlspecialchars(date('d', $activityDate)) ?>
                            </strong>

                        </div>

                        <div class="volunteer-card-content">

                            <span class="volunteer-card-event">
                                <?= htmlspecialchars($activity['event_name']) ?>
                            </span>

                            <h3>
                                <?= htmlspecialchars($activity['activity_name']) ?>
                            </h3>

                            <ul class="volunteer-details">

                                <li>
                                    <i class="bi bi-clock" aria-hidden="true"></i>

                                    <?= htmlspecialchars(substr($activity['start_time'], 0, 5)) ?>
                                    –
                                    <?= htmlspecialchars(substr($activity['end_time'], 0, 5)) ?>
                                </li>

                                <li>
                                    <i class="bi bi-geo-alt" aria-hidden="true"></i>

                                    <?= htmlspecialchars($activity['location'] ?? '') ?>
                                </li>

                                <li>
                                    <i class="bi bi-people" aria-hidden="true"></i>

                                    <?= $registeredVolunteers ?>

                                    <?= $registeredVolunteers === 1
                                        ? 'aanmelding'
                                        : 'aanmeldingen' ?>
                                </li>

                            </ul>

                        </div>

                        <?php if (isset($_SESSION['gebruiker'])): ?>

                            <a
                                class="btn btn-primary volunteer-action"
                                href="/event-info?eventID=<?= (int) $activity['event_id'] ?>"
                            >
                                Bekijk &amp; meld je aan
                            </a>

                        <?php else: ?>

                            <a
                                class="btn btn-primary volunteer-action"
                                href="/login"
                            >
                                Inschrijven
                            </a>

                        <?php endif; ?>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

    <section class="volunteer-help mt-5">

        <i class="bi bi-info-circle" aria-hidden="true"></i>

        <p class="mb-0">
            <strong>Hoe werkt aanmelden?</strong>
            Open een evenement, bekijk de activiteit en kies je beschikbare moment.
            Inloggen is nodig om je plek vast te leggen.
        </p>

    </section>

</main>

<script src="/js/bootstrap.bundle.js"></script>

</body>
</html>
