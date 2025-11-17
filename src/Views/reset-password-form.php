<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Wachtwoord</title>
        <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/nav.css">
</head>
<body>
         <?php require_once(__ROOT__."/parts/nav.html"); ?>
<div class="container mt-5">
    <h1>Nieuw Wachtwoord Instellen</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="./reset-password">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <div class="mb-3">
            <label for="password" class="form-label">Nieuw wachtwoord</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Bevestig wachtwoord</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-success">Wachtwoord wijzigen</button>
    </form>
</div>
</body>
</html>
