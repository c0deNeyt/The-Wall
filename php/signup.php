<?php
   include('process.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title> Authentication I | WEB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/favicon.png">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../js/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <div class="wrapper">
    <h5 class="card-title">SIGN UP V88 ACCOUNT</h5>
<?= validationMsg();
?>
    <form enctype="multipart/form-data"  autocomplete="off" class="form" action="process.php" method="post">
      <input type="hidden" name="action" value="register">
      <label>First Name:
        <input value="<?= isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName'], ENT_QUOTES) : ''; ?>" type="text" name="firstName" placeholder="First Name">
      </label>
      <label>Last Name:
        <input value="<?= isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName'], ENT_QUOTES) : ''; ?>" type="text" name="lastName" placeholder="Last Name">
      </label>
      <label>Email:
        <input value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>" type="text" name="email" placeholder="Email">
      </label>
      <label>Contact Number:
        <input value="<?= isset($_POST['contactNumber']) ? htmlspecialchars($_POST['contactNumber'], ENT_QUOTES) : ''; ?>" type="text" name="contactNumber" placeholder="Contact Number">
      </label>
      <label class="password">Password:
        <input value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>" type="password" name="password" placeholder="Password">
      </label>
      <label class="confirmPassword">Confirm Password:
        <input value="<?= isset($_POST['confirmPassword']) ? htmlspecialchars($_POST['confirmPassword'], ENT_QUOTES) : ''; ?>" type="password" name="confirmPassword" placeholder="Password">
      </label>
      <a class="gotoSignIn" href="signIn.php">Sign In</a>
      <input type="submit" class="registerBtn" value="Register">
    </form>
    </div>
  </body>
</html>