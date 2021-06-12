<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Distance.php");


//Check if values have been sent
if (!empty($_POST['register'])) {

    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $fullname = $_POST['fullname'];
    $postal_code = $_POST['postal_code'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = strtolower($_POST['email']);
    if ($password == $confirmPassword) {
        $user = new classes\User($email);

        //Set the user's properties
        //setEmail returns an error message if the email is not a valid email or if it's not unique
        $valid_email = $user->setEmail($email);
        $user->setFullname($fullname);
        $user->setPostal_code($postal_code);
        $user->setAddress($address);
        $user->setLocation($location);
        $user->setPassword($password);


        //If setEmail returns a string, show the error message
        if (gettype($valid_email) == "string") {
            $error = $valid_email;
        } else {

            //Save the user
            $user->save_buyer();
            $user->standardProfilePicture();


            $user = new classes\User($email);
            $distance = new classes\Distance();
            $otherUsers = $user->getAllUsers();
            foreach ($otherUsers as $otherUser) {
                $user = new classes\User($email);
                $distance = new classes\Distance();

                $distanceCalculation = $user->getDistance($user->getAddress(), $user->getPostal_code(), urlencode($otherUser->address), urlencode($otherUser->postal_code));

                if (isset($distanceCalculation)) {
                    $distance->insertDistance($user->getId(), $otherUser->id, $distanceCalculation->text, $distanceCalculation->value);
                }
            }


            session_start();
            $_SESSION['user'] = $email;
            $_SESSION['user_status'] = "buyer";
            header("Location: /index.php");

        }
    }
    $error = 'Wachtwoorden komen niet overeen';

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Bokaal | Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/register-seller.css">
	<link rel="icon" type="image/svg" href=../../images/logo/favicon.png> <link rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>

<body class="body-login">

	<?php // include_once("nav.include.php") ?>

	<img id="img-log" src="../../images/background/OGbackground.png" class="loginImage"></div>


	<div class="register ">
		<form action="" method="post">
			<img class="logo logo-reg-buy" src="../../images/logo/LogoBlack.svg" alt="logo Bokaal">
			<h2 class="reg-buy-title">Registreer kopers</h2>
			<?php if (!empty($error)) : ?>
			<div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;">
				<p class="login-p"><?= $error ?></p>
			</div>
			<?php endif; ?>
			<?php if (isset($succesfull)) : ?>
			<div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;">
				<?php echo $succesfull; ?></div>
			<?php endif; ?>
			<br>

			<div id="reg-form-buyer-flex"  class="form-group">
					<input id="label-fill" type="text" name="fullname" id="fullname" class="form-control" placeholder="Volledige naam"
						required>
					<i class="fa fa-user icon-img" aria-hidden="true"></i>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
					<input id="label-fill" type="email" name="email" class="form-control email" placeholder="Email"
						pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required>
					<span id="availability"></span>
					<i class="fa fa-envelope icon-img" aria-hidden="true"></i>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
					<input id="label-fill" type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord"
						required>
					<i class="fa fa-lock icon-img" aria-hidden="true"></i>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
					<input id="label-fill" type="password" name="confirmPassword" id="confirmPassword" class="form-control"
						placeholder="Wachtwoord bevestigen" required>
					<i class="fa fa-lock icon-img" aria-hidden="true"></i>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
					<input id="label-fill" type="number" name="postal_code" class="form-control" placeholder="Postcode" required>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
				<input id="label-fill" type="text" name="location" class="form-control" placeholder="Stad" required>
			</div>

			<div id="reg-form-buyer-flex-flex" class="form-group">
				<input id="label-fill" type="text" name="address" class="form-control" placeholder="Straat, nr en bus" required>
			</div>

			<div id="reg-form-buyer-flex" class="form-group">
				<input id="register" id="register" type="submit"  value="Registreer" name="register">
			</div>

			<div id="result"> </div>

			<p class="login-p-reg-buy">Heb je al een account? <a class="login-link" href="login.php">Log</a> dan hier in</p>
		</form>

	</div>
	</div>

	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
</body>

</html>