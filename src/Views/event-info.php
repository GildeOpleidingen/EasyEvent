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
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-danger"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="flex-grow-1 position-relative d-flex align-items-center justify-content-center rounded-4 mb-4 bg-dark" 
            style="background-image: url('../../images/<?= htmlspecialchars($event->getEventBanner()) ?>'); background-size: cover; background-position: center;">

            <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4 bg-dark opacity-50"></div>
            
            <div class="position-relative text-white px-3">
                <h1 class="text-uppercase underline mb-4"><?= htmlspecialchars($event->getEventName()) ?></h1>
            </div>
            
            <div class="position-absolute text-white top-50 end-0 translate-middle-y text-dark rounded-3 shadow p-4 me-4" style="width: 300px; min-height: ; background-color: rgba(254, 141, 38, 0.5);">
                <h5 class="fw-bold">
                    <?php
                    $eventTime = $event->getEventTime()[0] ?? [];
                    echo htmlspecialchars($eventTime['date'] ?? 'Datum onbekend');
                    ?>
                </h5>
                <p class="mb-2">
                    <?= htmlspecialchars($eventTime['startTime'] ?? '') ?> - <?= htmlspecialchars($eventTime['endTime'] ?? '') ?>
                </p>
                <p class="small"><?= htmlspecialchars($event->getEventInfo()); ?></p>
                <a href="#" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#activiteiten">Bekijk de activiteiten</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="activiteiten" tabindex="-1" aria-labelledby="activiteitenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php if (isset($gebruikerID)): ?>
                    <form id="activityForm" action="/event-info" Method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="activiteitenModalLabel">Selecteer Activiteiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <input type="hidden" name="eventID" value="<?= htmlspecialchars($event->getEventID()) ?>" />
                        <div class="modal-body">
                            <?php if (!empty($active_roles)): ?>
                                Kies de rol waarin je aan de activiteit deelneemt.
                                <?php foreach ($active_roles as $role): ?>
                                <div class="form-check">
                                    <?php
                                    /** @var RolModel $role */
                                    $role = $role[0]; ?>
                                    <input class="form-check-input" type="radio" id="role<?=  htmlspecialchars($role->getName()) ?>" name="role" <?php if ($event::hasRole($activities, $role)) : ?> checked="checked"<?php endif; ?> value="<?= htmlspecialchars($role->getID()) ?>">
                                    <label class="form-check-label" for="role<?= htmlspecialchars($role->getName()) ?>"><?= htmlspecialchars($role->getName()) ?></label>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Geen rollen gevonden.</p>
                            <?php endif; ?>

                            <?php if (!empty($organisations)): ?>
                                Kies de organisatie waarvoor je aan de activiteit deelneemt.
                                <?php foreach ($organisations as $organisation): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="organisation<?= htmlspecialchars($organisation->getName()) ?>" name="organisation" <?php if ($event::hasOrganisation($activities, $organisation)) : ?> checked="checked"<?php endif; ?> value="<?= htmlspecialchars($organisation->getID()) ?>">
                                    <label class="form-check-label" for="organisation<?= htmlspecialchars($organisation->getName()) ?>"><?= htmlspecialchars($organisation->getName()) ?></label>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Geen organisaties gevonden.</p>
                            <?php endif; ?>

                            <?php if (!empty($activities)): ?>
                                Kies de activiteit waarin je aan wil deelnemen.
                                <?php foreach ($activities as $activity): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="activity<?= htmlspecialchars($activity->getID()) ?>" name="activities[<?= htmlspecialchars($activity->getID()) ?>][checked]" <?php if ($activity->hasUser()) : ?> checked="checked"<?php endif; ?> value="<?= htmlspecialchars($activity->getID()) ?>">
                                    <label class="form-check-label" for="activity<?= htmlspecialchars($activity->getID()) ?>"><?= htmlspecialchars($activity->getName()) ?></label>
                                </div>
                                <div class="form-check">
                                    <input type="text" name="activities[<?= htmlspecialchars($activity->getID()) ?>][startTime]" value="<?= htmlspecialchars($activity->getBeginTijd()) ?>" />
                                    <input type="text" name="activities[<?= htmlspecialchars($activity->getID()) ?>][endTime]" value="<?= htmlspecialchars($activity->getEindTijd()) ?>" />
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Geen activiteiten gevonden.</p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Inschrijven</button>
                        </div>
                    </form>
                <?php endif; ?>
                <?php if (!isset($gebruikerID)): ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="activiteitenModalLabel">Activiteiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <p class="" id="<?= htmlspecialchars($activity->getID()) ?>"><?= htmlspecialchars($activity->getName()) ?></p>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <p>Geen activiteiten gevonden.</p>
                            <?php endif; ?>
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/animaties.js"></script>
    <script src="/js/bootstrap.bundle.js"></script>
</body>
</html>

