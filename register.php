<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Check if values have been sent
if (!empty($_POST['buyer'])) {
            header("Location: register-buyer.php");
        
    }

	if (!empty($_POST['seller'])) {
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
	
</head>

<body>

	<?php include_once("nav.include.php") ?>

	<div class="d-flex justify-content-center">
			<form  action="" method="post">
				<h2>I am a</h2>

				<div class="form-group">
					<input type="submit" class="buyer" value="Buyer" name="buyer">
				</div>
				<div class="form-group">
					<input type="submit" class="seller" value="Seller" name="seller">
				</div>

			</form>

		</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>

</html>