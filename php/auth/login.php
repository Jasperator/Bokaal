<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");



//Detect submit
if (!empty($_POST)) {

  //Put fields in variables
  $password = $_POST['password'];
    $email = $_POST['email'];



    if (!empty($email) && !empty($password)) {
    //If both fields are filled in, check if the login is correct

    if (classes\User::checkPassword($email, $password)) {
      $user = new classes\User($email);

      if ($_POST['captcha'] == $_SESSION['digit']) {
       $_SESSION['user'] = $email;
       $_SESSION['user_status'] = $user -> retrieveStatus();

          header("Location: /index.php");
       
      } else {
        $error = "Wrong Captcha";
       }
    } else {
      $error = "Sorry, we couldn't log you in.";
    }
  } else {

    //If one of the fields is empty, generate an error
    $error = "Email and password are required.";
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>

  <title>Bokaal | login</title>
</head>

<body class="body-login">

  <?php // include_once("nav.include.php"); ?>

  <img id="img-log" src="../../images/background/OGbackground.png" class="loginImage"></div>

  <div class="container-fluid">
    <div class="row no-gutter">
      <div id="frame" class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">

                <img class="logo" src="../../images/logo/LogoBlack.svg" alt="login logo Bokaal">
                <h3 class="titel-login">Welcome back!</h3>


                <?php if (isset($error)) : ?>
                  <div class="col-md-9 col-lg-8 mx-auto">
                    <h3 class="login-heading mb-4" style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;"><?php echo $error; ?></h3>
                  </div>
                <?php endif; ?>

                <form id=log-form action="" method="post">
                  <div id="label-fill" class="form-label-group">
                    <input class=input-login type="text" name="email" id="email" placeholder="Email">                   
                   <br>
                  </div>

                  <div class="form-label-group">
                    <input  class=input-login type="password" name="password" id="password" placeholder="Wachtwoord">
                    
                    <br>
                  </div>


                  <p class="login-p captcha"><img src="captcha.php" width="120" height="30" alt="CAPTCHA">
                    <input  class=input-login type="text" size="6" maxlength="5" name="captcha" value=""></p>
                  <p class="login-p"><small>Copy the digits from the image into the box</small></p>

                  <input id="loginBTN" type="submit" value="LOGIN" class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2">

                  <div class="text-center">
                </form>
                <p class="login-p">Nog geen account? <a class="login-link" href="register.php">Registreer</a> dan hier</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.js"></script>

</body>

</html>