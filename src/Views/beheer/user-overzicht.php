<?php
use App\Models\UserModel;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>Beheer | Gebruikers overzicht</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/nav.css">
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container-fluid vh-100 d-flex flex-column">
        <?php require_once('./parts/nav-beheer.html'); ?>
        <div class="container my-4 pb-4">
            <h1 class="text-center mb-4">Gebruikers overzicht</h1>

            <!-- Form 1: User Details -->
            <form id="formUserDetails" novalidate action="<?php $_PHP_SELF ?>" method="POST">
                <?php
                    $user = new UserModel();
                
                    $allUsers = $user->getAllUsers();
                ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefoon</th>
                        <th scope="col">Kledingmaat</th>
                        <th scope="col">Geverifieerd</th>
                        <th scope="col">Rollen</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($allUsers as $key => $value): ?>
                        <tr>
                            <td>
                                <?=$value->getVoornaam() ?>
                            </td>
                            <td>
                                <?=$value->getAchternaam() ?>
                            </td>
                            <td>
                                <?=$value->getEmail() ?>
                            </td>
                            <td>
                                <?=$value->getTelefoon() ?>
                            </td>
                            <td>
                                <?=$value->getkledingMaat() ?>
                            </td>
                            <td>
                                <?=$value->getIsGeverifieerd() ?>
                            </td>
                            <td>
                                <?=$value->getRoles() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            
            </form>
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

