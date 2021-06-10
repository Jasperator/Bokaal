<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");
//Create a new user based on the active user's email
$user = new classes\User($_SESSION['user']);

$pop = $user->selectPopupSeen();

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

    if($_SESSION['user_status'] == "seller") {
        //Fill in the user's properties
        $user->setBio($_POST['bio']);
        $user->setAddress($_POST['address']);
        $user->setPostal_code($_POST['postal_code']);
        $user->setLocation($_POST['location']);
        $user->setBtw($_POST['btw']);
        $user->setCompany($_POST['company']);
        $user->setTelephone($_POST['number']);

      
        //Save those properties to the database
        $user->completeProfileSeller();}
    else {
    //Fill in the user's properties
    $user->setBio($_POST['bio']);
    $user->setAddress($_POST['address']);
    $user->setPostal_code($_POST['postal_code']);
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
  <!--<link rel="stylesheet" href="css/bootstrap.css">-->
  <title>Profiel instellingen</title>

  <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">

    <!--slider links en scripts-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.5.0/flexslider.min.css" rel="stylesheet">
    <link href="../../css/popup-slider.css" rel="stylesheet">


    <!--slider links en scripts einde-->



</head>

<body id="Profiel-instellingen-body">
  <?php include_once("../includes/nav.include.php") ?>  
  
 
  <!-- Hier moet de profile.php nav komen -->



     <h2 class="hoofdtitel">Profiel instellingen</h2>
      <div class="profile-settings-image">
        
        <div>
          <div >
            <img class="new-profile-image" src="/uploads/<?= htmlspecialchars($user->getProfile_img()) ?>" />
            <?php if (isset($error)) : ?>
            <div><?php echo $error; ?></div>
            <?php endif; ?>
          </div>
        </div>
        
        <!--<div class="setImg">
          <img class="setImage" src="../../images/setting-img.jpg" alt="">
        </div>-->

        <form enctype="multipart/form-data" action="" method="POST">
          <div>
            <input class="file-button" type="file" id="profile_img" name="profile_img" capture="camera" required />
          </div>
          <div>
            <input class="button-profile-img" type="submit" value="Upload" name="uploadPicture" />
          </div>
        </form>
      </div>
    </div>
  </div>

  <div >
    <div>

      <form action="" method="POST">

        <!-- Fill in the input fields with the data from the database -->
        <br>
        <div class="form-group">
          <!-- <label for="bio">Biography</label>-->
          <textarea placeholder="Biografie" name="bio" id="bio" class="form-control-settings" rows="3"
            cols="100"><?= htmlspecialchars($user->getBio()) ?></textarea>
        </div>

        
        <div>
				<div >

        <div>
						<!--<label for="currency">Currency</label>-->
						
						<input type="text" name="location"  class="form-control-settings" placeholder="Location" value="<?= htmlspecialchars($user->getLocation()) ?>"
							required>
		
					</div>
          <div>
						<!--<label for="currency">Currency</label>-->
						
						<input type="number" name="postal_code"  class="form-control-settings" placeholder="Postcode" value="<?= htmlspecialchars($user->getPostal_code()) ?>"
							required>
		
					</div>

					<div class="form-group">
						<!--<label for="price">Price</label>-->
						<input type="text" name="address" class="form-control-settings" placeholder="Straat, nr en bus" value="<?= htmlspecialchars($user->getAddress()) ?>" required>
            </input>
			
					</div>
				
				</div>
			</div>

      
        <?php if($_SESSION['user_status'] == "seller") : ?>

        <div class="form-group">
          <!--<label for="btw">Btw number</label>-->
          <input placeholder="BTW nummer" name="btw" id="btw" class="form-control-settings" value="<?= htmlspecialchars($user->getBtw()) ?>">
        </div>

        <div class="form-group">
          <!--<label for="company">Company name</label>-->
          <input placeholder="Bedrijfs naam" name="company" id="company" class="form-control-settings" value="<?= htmlspecialchars($user->getCompany()) ?>">
        </div>

        <div class="form-group">
          <!--<label for="number">Telephone number</label>-->
          <input placeholder="Telefoon nummer" name="number" id="number" class="form-control-settings" value="<?= htmlspecialchars($user->getTelephone()) ?>">
        </div>

        <?php
                        endif;?>

        <div class="form-group">
          <input class="button-profile" type="submit" value="Opslaan" name="updateProfile">
        </div>
      </form>
    </div>
  </div>

  <div>
    <div>
      <form method="POST" action="">
        <p style="color:red">
          <?php if (!empty($error_mail)) : ?>
          <div>
            <p><?= $error_mail ?></p>
          </div>
          <?php endif; ?>
          <?php if (isset($succesfull_mail)) : ?>
          <div><?php echo $succesfull_mail; ?></div>
          <?php endif; ?>

        </p>
        <div class="form-group">
          <!--<label for="emailpassword">Current password</label>-->
          <input placeholder="email" type="email" name="emailpassword" value="<?= htmlspecialchars($user->getEmail()) ?>" id="emailpassword" class="form-control-settings">
        </div>

        <div class="form-group">
          <!--<label for="new_email">New email</label>-->
          <input placeholder="Nieuw email adres" type="email" name="new_email" id="new_email" class="form-control-settings">
        </div>
        <input class="button-profile" type="submit" value="Verander Email" name="changeEmail">

        <form method="POST" action="">
          <div class="form-group">
            <p style="color:red">
              <?php if (!empty($error_password)) : ?>
              <div><?php echo $error_password; ?></div>
              <?php endif; ?>
              <?php if (isset($succesfull_password)) : ?>
              <div><?php echo $succesfull_password; ?></div>
              <?php endif; ?>
            </p>

            <!--<label for="old_password">Current password</label>-->
            <input placeholder="Oud wachtwoord" type="password" name="old_password" id="old_password" class="form-control-settings">
          </div>
          <div class="form-group">
            <!--<label for="new_password">New password</label>-->
            <input placeholder="Nieuw wachtwoord" type="password" name="new_password" id="new_password" class="form-control-settings">
          </div>
          <input class="button-profile" type="submit" value="Verander Wachtwoord" name="changePassword">
        </form>
      </form>
              
      <div class="spacing-bottom"></div>
    </div>
  </div>

  <?php if(empty($pop)){
?>
 <!-- slider menu -->
  <div class="sliderPop" id="sliderPop">
    <div class="ct-sliderPop-container">
        <div class="ct-sliderPop ct-sliderPop-slide1 open">
            <div class="inner">
                <h1 class="head-title-slider">Verspilling</h1>
                <a class="close-button">
                    <img id="img-close-button" alt="close" src="../../images/icon/cross-black.svg"></a>
                <img id="img-vedgy" src="../../images/sla.jpg" alt="">
                <div class="map-white-border"></div>
                <h2 class="htwee">907 miljoen kg verspilling in Vlaanderen</h2>
                <p class="paragraaf">Elk jaar wordt er in Vlaanderen alleen al 907 miljoen kilogram voedsel weggegooid
                    . Van de 907 miljoen kilogram voedsel dat weggegooid wordt,
                    is 20% groenten en 29% fruit, dus een groot deel van de verspilling komt vanuit
                    de landbouw (330 miljoen kilogram).
                </p>                
            </div>
        </div>

        <div class="ct-sliderPop ct-sliderPop-slide1">
            <div class="inner">
                <h1 class="head-title-slider">Hoe pakken we dit aan</h1>
                <a class="close-button">
                    <img id="img-close-button" alt="close" src="../../images/icon/cross-black.svg"></a>
                <img id="img-vedgy" src="../../images/selder.jpg" alt="">
                <h2 class="htwee">SAMEN</h2>
                <p class="paragraaf">Via dit portaal willen wij boeren de optie
                    geven om hun groenten en fruit die er iets minder mooi uitzien
                    lokaal te verkopen. En deze kunnen dan door iedereen gekocht worden.
                </p>
            </div>        
        </div>   
            
    </div>
</div>
  <!--einde slider menu-->
<?php
      $user->popupSeen(); }
  ?>

  

  <?php include_once("../includes/footer.php");?>


  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.5.0/jquery.flexslider-min.js"></script>
    <script src="../../js/popup-slider.js"></script>


  <script>

      // Get the modal
      var modal = document.getElementById("sliderPop");


      // Get the <span> element that closes the modal
    document.querySelectorAll(".close-button").forEach(item => {
          item.addEventListener('click', function () {
              modal.style.display = "none";

          })
      });

  </script>

</body>

</html>