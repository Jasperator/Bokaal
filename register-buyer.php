<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Check if values have been sent
if (!empty($_POST['register'])) {

    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $email = strtolower($_POST['email']);
    $user = new classes\User($email);

    //Set the user's properties
    //setEmail returns an error message if the email is not a valid email or if it's not unique
    $valid_email = $user->setEmail($email);
    $user->setFullname($fullname);
    $user->setPassword($password);

	
    //If setEmail returns a string, show the error message
    if (gettype($valid_email) == "string") {
        $error = $valid_email;
    } else {

        //Save the user
        $user->save_buyer();

        //Let him know he's registered
        $succesfull = "You have been succesfully registered!";

		$user = new classes\User($email);
		
            session_start();
            $_SESSION['user'] = $email;
            $_SESSION['user-status'] = "buyer";
            header("Location: index.php");
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="css/bootstrap.css">
	
</head>

<body>

	<?php include_once("nav.include.php") ?>

	<div class="d-flex justify-content-center">
			<form class="registerForm" action="" method="post">
				<h2>Register Buyer Account</h2>
				<?php if (!empty($error)) : ?>
					<div style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px;">
						<p><?= $error ?></p>
					</div>
				<?php endif; ?>
				<?php if (isset($succesfull)) : ?>
          <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;"><?php echo $succesfull; ?></div>
        <?php endif; ?>
				<br>
				<div class="form-group">
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Your Name" required>
					<i class="fas fa-user"></i>
				</div>
				<div class="form-group">
					<label for="email">Your Email</label>
					<input type="email" name="email" class="form-control email" placeholder="Your Email" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required>
					<span id="availability"></span>
					<i class="fas fa-envelope"></i>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
					<i class="fas fa-lock"></i>
				</div>
				<div class="form-group">
					<input type="submit" class="register" value="Register" name="register">
				</div>
				<div id="result"> </div>

			</form>

		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>

</html>