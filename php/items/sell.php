<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");




if (!empty($_POST['upload'])) {

    $user = new classes\User($_SESSION['user']);
    $item = new classes\Item();

    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $seller_id = $user -> getId();
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
	$quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $currency = $_POST['currency'];


    $item->setSeller_id($seller_id);
    $item->setTitle($title);
    $item->setCategory($category);
    $item->setDescription($description);
	$item->setQuantity($quantity);
    $item->setUnit($unit);
    $item->setPrice($price);
    $item->setCurrency($currency);

	try {
		$item->save_item();
        header('Location: ../profile/settings_items.php');

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
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
	<link rel="icon" type="image/svg" href=images/logo/favicon.png>

	<title>Bokaal | Sell</title>

	<link rel="icon" type="image/svg" href=../../images/logo/favicon.png> </head>
	
<body id="sell-body">

	<?php include_once("../includes/nav.include.php") ?>

	<div >
            <h2 class="hoofdtitel">Verkoop</h2>
        </div>
    
	<div>
		<form class="registerForm" enctype="multipart/form-data" action="" method="post">


			<div id="category" class="form-sell">
				<select type="text" name="category" id="categorie" class="form-control" placeholder="Geef de categorie in"
					required>
					<option value="" selected disabled hidden>categorie</option>
					<optgroup label="Groenten">

						<option value="Bladgroenten">Bladgroenten</option>
						<option value="Kiemgroenten">Kiemgroenten (spruiten, tuinkers,...)</option>
						<option value="Koolsoorten">Koolsoorten</option>
						<option value="Stengelgewassen">Stengelgewassen (prei, selder,...)</option>
						<option value="Uien">Uien</option>
						<option value="Vruchtgroenten">Vruchtgroenten</option>
						<option value="Wortel en knolgewassen">Wortel- knolgewassen</option>
						<option value="Vruchtgroenten">Vruchtgroenten (tomaat, aubergine, courgette,...)</option>
						<option value="Wortel- knolgewassen">Wortel- knolgewassen</option>
						<option value="Overige groenten">Overige groenten</option>

					<optgroup label="Fruit">

						<option value="Citrusfruit">Vruchtgroenten</option>
						<option value="Pitfruit">Pitfruit</option>
						<option value="Steenvruchten">Steenvruchten</option>
						<option value="Zacht fruit">Zacht fruit</option>
						<option value="Exotisch fruit">Exotisch fruit</option>
						<option value="overig fruit">overig fruit</option>
						<option value="Citrusfruit">Citrusfruit (citroen, limoen,...</option>
						<option value="Pitfruit">Pitfruit (appel, peer,...)</option>
						<option value="Steenvruchten">Steenvruchten (pruim, perzik, kers,...)</option>
						<option value="Zacht fruit">Zacht fruit (aardbei, bessen,...)</option>
						<option value="Exotisch fruit">Exotisch fruit (passievrucht, papaja,...</option>
						<option value="overig fruit">overig Fruit</option>


				</select>

			</div>


			<div id="top" class="form-sell">
				<input type="text" name="title" id="title" class="form-control" placeholder="Titel" required>

			</div>

			<div class="form-sell">
				<input type="text" name="description" id="description" class="form-control" placeholder="Beschrijving"
					required>

			</div>

			<div class="form-sell">
				<div id="hoeveelheid">
					<div>
						<input type="number" name="quantity" id="quantity" class="form-control"
							placeholder="Hoeveelheid" required>

					</div>

					<div id="unit" class="form-sell">

						<select type="text" name="unit" id="unit" class="form-control"
							placeholder="Kies soort hoeveelheid" required>
							<option value="" selected disabled hidden>Kies soort hoeveelheid</option>

							<optgroup label="Hoeveelheid">

								<option value="Gram">Gram</option>
								<option value="Kg">Kg</option>
								<option value="Stuks">Stuks</option>

						</select>

					</div>


				</div>


			</div>
	</div>


	<div  class="form-sell">
		<div id="bedrag">
			<div>
				<!--<label for="price">Price</label>-->
				<input type="number" name="price" id="price" class="form-control" placeholder="Prijs" step=".01" required>

			</div>
			<div>
				<!--<label for="currency">Currency</label>-->

				<input type="text" name="currency" id="currency" class="form-control" Value="Euro" required>


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

	<!--<div class="input-group">
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="inputGroupFile04">
    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
  </div>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button">Button</button>
  </div>
</div>


	<div id="result"> </div>

	</form>

	</div>

	<div id="space"></div>
	<div id="space"></div>

	<!-- <div>style="font-size: 15px; background-color:#F8D7DA; padding:10px; border-radius:10px; margin-top:10px;"</div> -->

	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>

<?php include_once("../includes/footer.php");?>

	</body>

</html>



<!--	<select>
							<option value="0">Maak je keuze</option>
							<option value="1">Gram</option>
							<option value="2">Kg</option>
							<option value="3">Stuks</option>
							
						</select> -->