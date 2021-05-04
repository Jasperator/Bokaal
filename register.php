<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Check if values have been sent
if (!empty($_POST['Koper'])) {
            header("Location: register-buyer.php");
        
    }

	if (!empty($_POST['Verkoper'])) {
		header("Location: register-seller.php");
	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/register.css">
	<link rel="icon" type="image/svg" href=images/Logo/LogoWhite.svg>

</head>

<body>

	<?php //include_once("nav.include.php") ?>

	<div class="d-flex justify-content-center">
			<form  action="" method="post">
				<h2>Ik ben een</h2>

				<div class="form-group">
					<input type="submit" class="buyer" value="Koper" name="Koper">
				</div>
				<div class="form-group">
					<input type="submit" class="seller" value="Verkoper" name="Verkoper">
				</div>
				<p>Heb je al een account? <a href="login.php">Log</a> dan hier in</p>
			</form>

		</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>

</html>