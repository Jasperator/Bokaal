<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Detect submit
if (!empty($_POST)) {

  //Put fields in variables
  $email = $_POST['email'];
  $password = $_POST['password'];


  if (!empty($email) && !empty($password)) {
    //If both fields are filled in, check if the login is correct

    if (classes\User::checkPassword($email, $password)) {
      $user = new classes\User($email);

      // if ($_POST['captcha'] == $_SESSION['digit']) {
       $_SESSION['user'] = $email;
       $_SESSION['user_status'] = $user -> retrieveStatus();

          header("Location: index.php");
       
      // } else {
      //   $error = "Wrong Captcha";
      // }
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
  <link rel="stylesheet" href="css/bootstrap.css">

  <title>Bokaal: login</title>
</head>

<body>

  <?php include_once("nav.include.php"); ?>

  <div class="container-fluid">
    <div class="row no-gutter">
      <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Welcome back!</h3>


                <?php if (isset($error)) : ?>
                  <div class="col-md-9 col-lg-8 mx-auto">
                    <h3 class="login-heading mb-4" style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;"><?php echo $error; ?></h3>
                  </div>
                <?php endif; ?>

                <form action="" method="post">
                  <div class="form-label-group">
                    <input type="text" name="email" id="email" class="form-control" autofocus>
                    <label for="inputEmail">Email</label>
                  </div>

                  <div class="form-label-group">
                    <input type="password" name="password" id="password" class="form-control">
                    <label for="inputPassword">Password</label>
                  </div>


                  <p><img src="./captcha.php" width="120" height="30" alt="CAPTCHA">
                    <input type="text" size="6" maxlength="5" name="captcha" value=""></p>
                  <p><small>Copy the digits from the image into the box</small></p>

                  <input type="submit" value="LOGIN" class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2">

                  <div class="text-center">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.js"></script>

</body>

</html>