<?php

include_once(__DIR__ . "/bootstrap.include.php");





if (!empty($_POST['upload'])) {

    $user = new classes\User($_SESSION['user']);
    $item = new classes\Item($_SESSION['user']);

    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $seller_id = $user -> getId();
    $title = $_POST['title'];
    $description = $_POST['description'];
	$quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $currency = $_POST['currency'];
	
    $item->setSeller_id($seller_id);
    $item->setTitle($title);
    $item->setDescription($description);
	$item->setQuantity($quantity);
    $item->setUnit($unit);
    $item->setPrice($price);
    $item->setCurrency($currency);

	try {
		$item->save_item();
	} catch (\Throwable $th) {
		$error = $th->getMessage();
	  }



}
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

	<style>
		<?php include 'css/sell.css';
		?>
	</style>


	<div class="d-flex justify-content-center">
		<form class="registerForm" enctype="multipart/form-data" action="" method="post">
			<h2>Sell</h2>
			<div id="top" class="form-group">
				<!--<label for="title">Title</label>-->
				<input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
				<i class="fas fa-user"></i>
			</div>
			<div class="form-group">
				<!--<label for="description">Description</label>-->
				<input type="text" name="description" id="description" class="form-control" placeholder="description"
					required>
				<i class="fas fa-user"></i>
			</div>

			<div class="form-group name2 col-xs-6">
				<div class="row">
					<div class="form-group">
						<!--<label for="quantity">Quantity</label>-->
						<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity"
							required>
						<i class="fas fa-user"></i>
					</div>
					<div class="form-group">
						<!--<label for="unit">Unit</label>
						<input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" required  > -->
						
						<select type="text" name="unit" id="unit" class="form-control" placeholder="Unit" required >
							<option value="Maak je keuze">Maak je keuze</option>
							<option value="Gram">Gram</option>
							<option value="Kg">Kg</option>
							<option value="Stuks">Stuks</option>							
						</select>

						<i class="fas fa-user">  </i>
					</div>
				</div>
			</div>


			<div class="form-group name2 col-xs-6">
				<div class="row">
					<div class="form-group">
						<!--<label for="price">Price</label>-->
						<input type="number" name="price" id="price" class="form-control" placeholder="Price" required>
						<i class="fas fa-user"></i>
					</div>
					<div class="form-group">
						<!--<label for="currency">Currency</label>-->
						
						<input type="text" name="currency" id="currency" class="form-control" placeholder="Currency"
							required>
						
						<i class="fas fa-user"></i>
					</div>
				</div>
			</div>

			<?php if (isset($error)) : ?>
			<div><?php echo $error; ?></div>
			<?php endif; ?>
			<div class="form-group">
				<input class="button" type="file" id="item_image" name="item_image" capture="camera" />
			</div>
			<div class="form-group">
				<input id="button_or" type="submit" class="register" value="Upload" name="upload">
			</div>
			<div id="result"> </div>

		</form>

	</div>

	<!-- <div>style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px; margin-top:10px;"</div> -->

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>

</html>



					<!--	<select>
							<option value="0">Maak je keuze</option>
							<option value="1">Gram</option>
							<option value="2">Kg</option>
							<option value="3">Stuks</option>
							
						</select> -->