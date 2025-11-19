<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Vergeten</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
         <?php require_once(__ROOT__."/parts/nav.php"); ?>
    <div class="container mt-5">
        <h1>Wachtwoord Vergeten</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="./forgot-password">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Vul je e-mailadres in" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
        <?php if (isset($success)): ?>
    <hr>
    <h2>Voer je resetcode in</h2>
    <form method="POST" action="./verify-reset-code">
        <div class="mb-3">
            <label for="reset_code" class="form-label">Resetcode</label>
            <input type="text" class="form-control" id="reset_code" name="reset_code" placeholder="Voer je code in" required>
        </div>
        <button type="submit" class="btn btn-success">Verifiëren</button>
    </form>
<?php endif; ?>

    </div>
</body>
</html>
