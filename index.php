<?php
   require('php/process.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title> The Wall | WEB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/favicon.png">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/jquery.min.js" defer></script>
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <script src="js/jquery.min.js" defer></script>
    <script src="js/jquery-ui-1.13.2/jquery-ui.min.js" defer></script>
    <script src="js/sweetalert2.all.min.js" defer></script>
    <script src="js/index.js" defer></script>
  </head>
  <body>
    <div class="wrapper">
<?php
  include("php/header.php");
?>
        <form class="share" method="post" action="php/process.php">
            <input type="hidden" name="reviewAction" value="write">
            <label>Share you thoughts!!
                <textarea name="latestReview" ></textarea>
            </label>
            <input class="post" type="submit" value="Share">
        </form>
        <section>
<?= displayReview(); ?>
        </section>
    </div>
  </body>
</html>
<form method="post" name="logOut">
    <input type="hidden" name="logoutAction" value="show">
    <input type="submit" class="sentReq" style="display: none;">
</form>