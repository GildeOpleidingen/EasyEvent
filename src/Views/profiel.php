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

    <title>EasyEvents | Profiel</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/events.css">
    <link rel="stylesheet" href="/css/profile.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .contact-info p {
            display: flex;
            align-items: center;
        }
        .contact-info i {
            width: 20px;
        }
        .contact-info span.label {
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <?php
        $hour = date('H');
        $greeting = ($hour < 12) ? 'Goedemorgen' : (($hour < 18) ? 'Goedemiddag' : 'Goedeavond');
    ?>
    <div class="container-fluid vh-100">
        <?php require_once('./parts/nav.php'); ?>
        <?php if(isset($error)): ?>
    <div class="error-message">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
        <div class="success-message">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                
                <div class="card position-relative mt-5">
                    <div class="card-body text-start ms-5">
                        <img src="./images/output-onlinepngtools (5).png" alt="Profile Picture" class="img-fluid rounded-circle position-absolute profiel-foto" style="width: 150px; height: 150px; top: -75px; left: calc(50% - 75px);">
                        <div class="mt-5 pt-5">
                            <div class="col">
                                <div class="contact-info">
                                    <p class="flex-wrap"><i class="bi bi-envelope-fill me-2"></i><span class="label">Email:</span> <?php echo $gebruiker->getEmail() ?></p>
                                    <p class="flex-wrap"><i class="bi bi-key-fill me-2"></i><span class="label">Wachtwoord:</span> ****** <i class="bi bi-pen-fill ms-3 icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wachtwoord wijzigen" onclick="openModalPassword();"></i></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="contact-info">
                                    <p class="flex-wrap d-inline-flex"><i class="bi bi-telephone-fill me-2"></i>Telefoonnummer: <span class="ms-4"> <div class="d-inline-flex align-items-center flex-wrap"> <?php echo $gebruiker->getTelefoon() ?> </span> <i class="bi bi-pen-fill ms-3 icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Telefoonnummer wijzigen" onclick="openModalPhone();"></i></div></p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <div class="contact-info">
                                    <p class="flex-wrap"><i class="bi bi-house-fill me-2"></i><span class="label">Postcode:</span> <?php echo $gebruiker->getPostcode() ?> <i class="bi bi-pen-fill ms-3 icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Adres wijzigen" onclick="openModalAddress();"></i></p>
                                    <p class="flex-wrap"><i class="bi bi-geo-alt-fill me-2"></i><span class="label">Plaatsnaam:</span> <?php echo $gebruiker->getPlaatsnaam() ?> </p>
                                    <p class="flex-wrap"><i class="bi bi-door-open-fill me-2"></i><span class="label">Huisnummer:</span> <?php echo $gebruiker->getHuisnummer() ?> </p>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="row mt-3">
                            <div class="col-12 text-start">
                                <h6 class="text-dark fw-bold mb-3 ms-2">
                                    <i class="bi bi-people-fill me-2"></i>Mijn Kinderen
                                </h6>

                                <?php if (!empty($kinderen)): ?>
                                    <div class="row g-2 ms-1 me-1"> <?php foreach ($kinderen as $kind): ?>
                                            <div class="col-sm-6">
                                                <div class="card border-0 bg-light py-2 px-3" style="border-radius: 12px;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-person-circle text-primary me-2" style="font-size: 1.2rem;"></i>
                                                        <div class="overflow-hidden">
                                                            <p class="mb-0 fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.2;">
                                                                <?php echo htmlspecialchars($kind->voornaam . ' ' . $kind->achternaam); ?>
                                                            </p>
                                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                                <?php echo htmlspecialchars($kind->postcode); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="ms-2 alert alert-light border-0 py-2">
                                        <p class="mb-0 text-muted small"><i class="bi bi-info-circle me-2"></i>Nog geen kinderen toegevoegd.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between flex-wrap">
                    <a href="/events" class="btn btn-primary">Bekijk mijn Evenementen</a>
                    <a href="/add-child" class="btn btn-primary">Voeg kind toe</a>
                </div>
            </div>
        </div>
    </div>
        <!-- Password Modal -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Wachtwoord wijzigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm" action="/profiel/updateWachtwoord" method="POST">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Huidig wachtwoord</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nieuw wachtwoord</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Bevestig nieuw wachtwoord</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Phone Modal -->
    <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="phoneModalLabel">Telefoonnummer wijzigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="phoneForm" method="POST" action="/profiel">
                        <div class="mb-3">
                            <label for="newPhone" class="form-label">Nieuw telefoonnummer</label>
                            <input type="text" class="form-control" id="newPhone" name="newPhone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Adres wijzigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addressForm" method="POST" action="/profiel/updateAdresGegevens">
                            <div class="mb-3">
                                <label for="newPostcode" class="form-label">Postcode</label>
                                <input type="text" class="form-control" id="newPostcode" name="newPostCode" maxlength="8" required>
                            </div>
                            <div class="mb-3">
                                <label for="newCity" class="form-label">Plaatsnaam</label>
                                <input type="text" class="form-control" id="newCity" name="newCity" maxlength="100" required>
                            </div>
                            <div class="mb-3">
                                <label for="newHouseNumber" class="form-label">Huisnummer</label>
                                <input type="text" class="form-control" id="newHouseNumber" name="newHouseNumber" maxlength="6" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        function openModalPassword() {
            var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        }

        function openModalPhone() {
            var phoneModal = new bootstrap.Modal(document.getElementById('phoneModal'));
            phoneModal.show();
        }

        function openModalAddress() {
            var addressModal = new bootstrap.Modal(document.getElementById('addressModal'));
            addressModal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/searchbar.js"></script>
    <script src="../../js/calendar.js"></script>
</body>
</html>
