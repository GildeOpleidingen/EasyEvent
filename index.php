<?php
  require_once("./functions/DB_connection.php");
  require_once("./functions/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="./images/icons/favicon.png">
  <link rel="stylesheet" href="./css/style.css">
  <title>EasyEvents</title>
</head>
<body>
	<?php require_once("./parts/nav.html"); ?>
	<div class="main-container">
		test content
	</div>
	<?php require_once("./parts/footer.html"); ?>
  
  <?php require_once("./parts/nav.html"); ?>
  <div class="main-container">
    <a href="login.php" class="redirect-button">Login</a>
  </div>
  <?php require_once("./parts/footer.html"); ?>

</body>
</html>