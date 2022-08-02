<?php
   require('php/process.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title> Blog | WEB</title>
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
        <article>
            <h1>Rumours</h1>
            <p>"So, what do you think?" he asked nervously. He wanted to know the answer, but at the same time, he didn't. He'd put his heart and soul into the project and he wasn't sure he'd be able to recover if they didn't like what he produced. The silence from the others in the room seemed to last a lifetime even though it had only been a moment since he asked the question. "So, what do you think?" he asked again.</p>
        </article>
        <section>
<?php
require("php/review.php");
?>
        </section>
    </div>
  </body>
</html>
<form method="post" name="logOut" class="logOut">
    <input type="hidden" name="logoutAction" value="logout">
    <input type="submit" class="sentReq" style="display: none;">
</form>
p>