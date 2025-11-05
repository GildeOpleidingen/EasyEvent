<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">
    <title>EasyEvents | Registreer</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://www.google.com/recaptcha/enterprise.js?render=6LePJs0rAAAAABAiA324JCCmHmiIS4Tp0nf2Bsho"></script>
    <script src="../js/captcha.js"></script>
</head>

<body>
    <div class="register container-fluid vh-100">
        <?php require_once(__ROOT__."/parts/nav.html"); ?>
        <div class="d-flex justify-content-center align-items-center h-75">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <img src="../../images/logo.png" alt="Easy Events logo" class="logo-img">
                </div>

                <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                    <div id="registerForm" <?php if (isset($step) && $step === 'verify') echo 'style="display: none;"'; ?>>
                        <h1 class="text-center text-uppercase ms-5">Registreer</h1>
                        <p class="text-center ms-5">Maak een nieuw account</p>

                        <?php if (isset($succes)): ?>
                            <div class="alert alert-success"><?php echo $succes; ?></div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="/register" method="POST" id="registratie">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" id="voornaam" name="voornaam" class="form-control rounded-0" placeholder="Voornaam" maxlength="70" required>
                                        <label for="voornaam">Voornaam</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" id="achternaam" name="achternaam" class="form-control rounded-0" placeholder="Achternaam" maxlength="70" required>
                                        <label for="achternaam">Achternaam</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" id="email" name="email" class="form-control rounded-0" placeholder="E-mailadres" maxlength="120" required>
                                <label for="email">E-mailadres</label>
                            </div>
                            <div class="form-floating mb-3">
<input 
  type="tel" 
  id="telefoon" 
  name="telefoon" 
  class="form-control rounded-0" 
  placeholder="Telefoonnummer" 
  maxlength="16" 
  pattern="^\+?[0-9]{6,15}$" 
  required
  oninput="
    this.value = this.value
      .replace(/[^0-9+]/g,'')
      .replace(/(?!^)\+/g,'')
  "
>

                                <label for="telefoon">Telefoonnummer</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" id="wachtwoord" name="wachtwoord" class="form-control rounded-0" placeholder="Wachtwoord" maxlength="100" required>
                                <label for="wachtwoord">Wachtwoord</label>
                                <i class="bi bi-eye-fill position-absolute icon-eye" data-toggle="wachtwoord"></i>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" id="herhaalWachtwoord" name="herhaalWachtwoord" class="form-control rounded-0" placeholder="Herhaal wachtwoord" maxlength="100" required>
                                <label for="herhaalWachtwoord">Herhaal wachtwoord</label>
                                <i class="bi bi-eye-fill position-absolute icon-eye" data-toggle="herhaalWachtwoord"></i>
                            </div>
<button type="submit" class="btn btn-primary w-100" onclick="submit">Registreer</button>

                        </form>
                    </div>

                    <div id="verificationForm" <?php if (!isset($step) || $step !== 'verify') echo 'style="display: none;"'; ?>>
                        <h3 class="text-center mt-5">Verificatiecode</h3>
                        <p class="text-center">Voer de code in die naar je e-mail is gestuurd.</p>
                        <form action="/verify-code" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" id="verificationCode" name="verificationCode" class="form-control rounded-0" placeholder="Verificatiecode" required maxlength="6">
                                <label for="verificationCode">Verificatiecode</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Verstuur</button>
                            <!-- <button type="submit" class="btn btn-primary w-100" onclick="captcha('LOGIN', this)">Verstuur</button> -->
                            <button type="button" class="btn btn-secondary w-100 mt-2" id="backToRegister">Terug naar registratie</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.icon-eye').forEach(icon => {
                icon.addEventListener('click', () => {
                    const input = document.getElementById(icon.dataset.toggle);
                    input.type = input.type === "password" ? "text" : "password";
                    icon.classList.toggle('bi-eye-fill');
                    icon.classList.toggle('bi-eye-slash-fill');
                });
            });

            const backToRegisterButton = document.getElementById("backToRegister");
            if (backToRegisterButton) {
                backToRegisterButton.addEventListener("click", () => {
                    document.getElementById("verificationForm").style.display = "none";
                    document.getElementById("registerForm").style.display = "block";
                });
            }
        });
    </script>
    <script src="../../js/bootstrap.bundle.js"></script>
</body>

</html>
