<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Create a new user based on the active user's email
$user = new classes\User($_SESSION['user']);


//Detect a submit to change the password
if (!empty($_POST['changePassword'])) {
    $new_password = $_POST['new_password'];
    $old_password = $_POST['old_password'];
  
    //Check if the user has the correct password
    if (classes\User::checkPassword($user->getEmail(), $old_password)) {
  
      //Change it to the new password
      $user->changePassword($new_password);
      $succesfull_password = "Your password is succesfully changed.";
    } else {
      $error_password = "We couldn't change the password.";
    }
  }

  //Detect a submit to change the email
if (!empty($_POST['changeEmail'])) {
    $old_password = $_POST['emailpassword'];
    $new_email = $_POST['new_email'];
  
    //Check if the user has the correct password
    if (classes\User::checkPassword($user->getEmail(), $old_password)) {
  
      //Use the setter with conditions to set the new email
      $valid_email = $user->setEmail($new_email);
  
      //If the setter returns an error string, show the error
      if (gettype($valid_email) == "string") {
        $error_mail = $valid_email;
      } else {
        //If the setter returns an object, change the email in the database
        $user->changeEmail($new_email);
        $succesfull_mail = "Your email is succesfully changed.";
      }
    } else {
      $error_mail = "Wrong password";
    }
  }

//Detect a submit to update your profile
if (!empty($_POST['updateProfile'])) {
    $user = new classes\User($_SESSION['user']);

    if(($_SESSION['user_status'] == "seller")) {  
        //Fill in the user's properties
        $user->setBio($_POST['bio']);
        $user->setLocation($_POST['location']);
        $user->setBtw($_POST['btw']);
        $user->setCompany($_POST['company']);
        $user->setTelephone($_POST['number']);

      
        //Save those properties to the database
        $user->completeProfileSeller();}
    else {
    //Fill in the user's properties
    $user->setBio($_POST['bio']);
    $user->setLocation($_POST['location']);
  
    //Save those properties to the database
    $user->completeProfile();
    }
  }

  if (!empty($_POST['uploadPicture'])) {
    try {
      $user->saveProfile_img();
    } catch (\Throwable $th) {
      $error = $th->getMessage();
    }
  }


  $locationArray = array("Antwerpen", "Henegouwen", "Limburg", "Luik", "Luxemburg", "Namen", "Oost-Vlaanderen", "Vlaams-Brabant", "Waals-Brabant", "West-Vlaanderen");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Sell your stuf</title>
</head>
<body>
<?php include_once("nav.include.php") ?>

<div class="container">
    <div class="jumbotron" style=" height:500px; margin:20px;">
      <div class="float-left" style=" margin-left:50px;">

        <img src="./uploads/<?= htmlspecialchars($user->getProfile_img()) ?>" width="250px;" height="250px;" style="border-radius: 10px"/>
        <?php if (isset($error)) : ?>
          <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px; margin-top:10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        <form enctype="multipart/form-data" action="" method="POST" style="margin-top:20px; border:none;">
          <div class="form-group">
            <input style="color:gray; border:none;" type="file" id="profile_img" name="profile_img" capture="camera" required />
          </div>
          <div class="form-group">
            <input type="submit" value="Upload" name="uploadPicture" />
          </div>
        </form>
      </div>
    </div>
</div>

      <div class="container">
    <div class="jumbotron float-left" style="width:50%; height:500px; margin:20px;">

      <form action="" method="POST">

        <!-- Fill in the input fields with the data from the database -->
        <br>
        <div class="form-group">
          <label for="bio">Biography</label>
          <textarea name="bio" id="bio" class="form-control" rows="3" cols="50"><?= htmlspecialchars($user->getBio()) ?></textarea>
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <select type="text" id="location" name="location" class="form-control">
            <?php foreach ($locationArray as $location) : ?>
              <option <?php if ($location == $user->getLocation()) {
                        echo "selected";
                      } ?>><?php echo htmlspecialchars($location) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <?php if($_SESSION['user_status'] == "seller") : ?> 
            <div class="form-group">
          <label for="btw">Btw number</label>
          <textarea name="btw" id="btw" class="form-control" rows="1" cols="50"><?= htmlspecialchars($user->getBtw()) ?></textarea>
        </div>
        <div class="form-group">
          <label for="company">Company name</label>
          <textarea name="company" id="company" class="form-control" rows="1" cols="50"><?= htmlspecialchars($user->getCompany()) ?></textarea>
        </div>

        <div class="form-group">
          <label for="number">Telephone number</label>
          <textarea name="number" id="number" class="form-control" rows="1" cols="50"><?= htmlspecialchars($user->getTelephone()) ?></textarea>
        </div>
        <?php
                        endif;?>

        <div class="form-group">
          <input type="submit" value="Save" name="updateProfile">
        </div>
      </form>
    </div>
      </div>

      <div class="container">
    <div class="jumbotron float-right" style="width:40%; height:600px; margin:20px;">
      <form method="POST" action="">
        <p style="color:red">
          <?php if (!empty($error_mail)) : ?>
            <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;">
              <p><?= $error_mail ?></p>
            </div>
          <?php endif; ?>
          <?php if (isset($succesfull_mail)) : ?>
            <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;"><?php echo $succesfull_mail; ?></div>
          <?php endif; ?>

        </p>
        <div class="form-group">
          <label for="emailpassword">Current password</label>
          <input type="password" name="emailpassword" id="emailpassword" class="form-control">
        </div>
        <div class="form-group">
          <label for="new_email">New email</label>
          <input type="email" name="new_email" id="new_email" class="form-control">
        </div>
        <input type="submit" value="Save" name="changeEmail" style="margin-bottom:20px;">

        <form method="POST" action="">
          <div class="form-group">
            <p style="color:red">
              <?php if (!empty($error_password)) : ?>
                <div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;"><?php echo $error_password; ?></div>
              <?php endif; ?>
              <?php if (isset($succesfull_password)) : ?>
                <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;"><?php echo $succesfull_password; ?></div>
              <?php endif; ?>
            </p>
            <label for="old_password">Current password</label>
            <input type="password" name="old_password" id="old_password" class="form-control">
          </div>
          <div class="form-group">
            <label for="new_password">New password</label>
            <input type="password" name="new_password" id="new_password" class="form-control">
          </div>
          <input type="submit" value="Save" name="changePassword">
        </form>
      </form>
    </div>
  </div>




<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>