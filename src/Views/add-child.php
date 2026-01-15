<?php
$gebruiker = $gebruiker ?? (object)[];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>EasyEvents | Kind Toevoegen</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/nav.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="login container-fluid vh-100">
    <?php require_once(__ROOT__."/parts/nav.php"); ?>
    <div class="d-flex justify-content-center align-items-center h-75">
        <div class="row">
            <?php //?>
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                <img src="../../images/logo.png" alt="Easy Events logo" class="logo-img">
            </div>
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                <h1 class="text-center text-uppercase ms-6">Kind Toevoegen</h1>
                <p class="text-center ms-6">Vul de gegevens van je kind in</p>

                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>

                <?php //?>
                <?php if (isset($gebruiker)): ?>
                    <form action="" method="POST" class="w-75 needs-validation" novalidate>
                        <div class="form-floating mb=3">
                        <input type="text" id="voornaam" name="voornaam" class="form-control rounded-0" placeholder="Voornaam" required>
                        <label for="voornaam">Voornaam</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" id="achternaam" name="achternaam" class="form-control rounded-0" placeholder="Achternaam" required>
                        <label for="achternaam">Achternaam</label>
                    </div>

                    <p class="text-muted text-center ms-6">Adresgegevens (standaard van jou, pas aan indien nodig)</p>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?php //?>
                                <input type="text" id="postcode" name="postcode" class="form-control rounded-0" placeholder="Postcode"
                                       value="<?php echo htmlspecialchars($gebruiker->getPostcode() ?? ''); ?>" required>
                                <label for="postcode">Postcode</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?php //?>
                                <input type="text" id="plaatsnaam" name="plaatsnaam" class="form-control rounded-0" placeholder="Plaatsnaam"
                                       value="<?php echo htmlspecialchars($gebruiker->getPlaatsnaam() ?? ''); ?>" required>
                                <label for="plaatsnaam">Plaatsnaam</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <?php //?>
                            <input type="text" id="huisnummer" name="huisnummer" class="form-control rounded-0" placeholder="Huisnummer"
                                   value="<?php echo htmlspecialchars($gebruiker->getHuisnummer() ?? ''); ?>" required>
                            <label for="huisnummer">Huisnummer</label>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 login-btn mt-3" type="submit">Kind Toevoegen</button>
                </form>
                <?php else: ?>
                <div class="alert alert-warning">Kon gebruikersgegevens niet laden. <a href="/profiel">Ga terug</a>.</div>
                <?php endif; ?>

                <p class="text-center ms-6 mt-3"><a href="/profiel">Terug naar profiel</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Succes!</h5>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: green;"></i>
                <p class="mt-3 fs-5">Kind is succesvol toegevoegd!</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="/profiel" class="btn btn-primary">Terug naar profiel</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nog een kind toevoegen</button>
            </div>
        </div>
    </div>
</div>


<script src="../../js/bootstrap.bundle.js"></script>
<script src="../../js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../../js/animaties.js"></script>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

<?php if (isset($childAdded) && $childAdded === true): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        });
    </script>
<?php endif; ?>
?>

</body>
</html>