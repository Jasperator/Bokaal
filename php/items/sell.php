<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");





if (!empty($_POST['upload'])) {


        $user = new classes\User($_SESSION['user']);
    $item = new classes\Item();

    for($i = 0; $i < $_POST['aantalPlaatsingen']; $i++){
        //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $seller_id = $user->getId();
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $currency = 'Euro';


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

	<title>Bokaal | Verkoop</title>

	<link rel="icon" type="image/svg" href=../../images/logo/favicon.png> </head>
	
<body id="sell-body">

	<?php include_once("../includes/nav.include.php") ?>

		<div >
            <h2 class="hoofdtitel">Verkoop</h2>
        </div>

	<div>

	
		
		<form class="registerForm-sell" enctype="multipart/form-data" action="" method="post">


			<div id="category" class="form-sell">
			<label class="sellLabel" for="aantalPlaatsingen">Categorie</label>

				<select type="text" name="category" id="categorie" class="form-control" placeholder="Geef de categorie in"
					required>
					<option value="" selected disabled hidden>categorie</option>
					<optgroup label="Groenten">

						<option value="Bladgroenten">Bladgroenten</option>
						<option value="Kiemgroenten">Kiemgroenten (spruiten, tuinkers,...)</option>
						<option value="Koolsoorten">Koolsoorten</option>
						<option value="Stengelgewassen">Stengelgewassen (prei, selder,...)</option>
						<option value="Uien">Uien</option>
						<option value="Vruchtgroenten">Vruchtgroenten (tomaat, aubergine, courgette,...)</option>
						<option value="Wortel- knolgewassen">Wortel- knolgewassen</option>
						<option value="Overige groenten">Overige groenten</option>

					<optgroup label="Fruit">

						<option value="Citrusfruit">Vruchtgroenten</option>
						<option value="Citrusfruit">Citrusfruit (citroen, limoen,...</option>
						<option value="Pitfruit">Pitfruit (appel, peer,...)</option>
						<option value="Steenvruchten">Steenvruchten (pruim, perzik, kers,...)</option>
						<option value="Zacht fruit">Zacht fruit (aardbei, bessen,...)</option>
						<option value="Exotisch fruit">Exotisch fruit (passievrucht, papaja,...</option>
						<option value="overig fruit">overig Fruit</option>
				</select>
			</div>

			<div class="form-sell">
				<label class="sellLabel" for="aantalPlaatsingen">Titel</label>
				<input type="text" name="title" id="title" class="form-control" placeholder="Titel" required>

			</div>

			<div class="form-sell">
				<label class="sellLabel" for="aantalPlaatsingen">Beschrijving</label>
				<input type="text" name="description" id="description" class="form-control" placeholder="Beschrijving"
					required>	
					<label class="sellLabel" for="aantalPlaatsingen">Hoeveelheid en prijs</label><br>
						
			</div>
			

			<div class="form-sell-item">

				<div id="hoeveelheid">
					<div class="select-items-selectItems">
						<input class="select-items-nr" type="number" name="quantity"
							placeholder="Hoeveelheid" required>

						<select class="select-items-select-unit" type="text" name="unit"
							placeholder="Kies soort hoeveelheid" required>
								<option  value="" selected disabled hidden>Eenheid</option>
									<optgroup label="Hoeveelheid">
										<option value="Gram">Gram</option>
										<option value="Kg">Kg</option>
										<option value="Stuks">Stuks</option>
						</select>
							<input type="number" class="select-items-select-price"  name="price"  placeholder="Prijs" step=".01" required>
							<input type="text" class="select-items-select-value" name="currency" Value="Euro" disabled>

                    </div>
				</div>
			</div>
	</div>


	<?php if (isset($error)) : ?>
	<div><?php echo $error; ?></div>
	<?php endif; ?>

    <div id="aantalPlaatsingen" class="form-sell-item">

        <div class="aantal-plaatsingen">
		<label class="sellLabel" for="aantalPlaatsingen">Aantal keer plaatsen</label>

            <input type="number" name="aantalPlaatsingen" id="aantalPlaatsingen" class="form-control"
                   placeholder="Hoeveel keer plaatsen" value="1" required>
        </div>
    </div>

    <div id="linker" class="form-group">
        <input class="button" type="file" name="item_image" capture="camera" />
    </div>
    <div class="form-group">
        <input id="button_orange" type="submit" class="register" value="Upload" name="upload">
    </div>
    <div id="result"> </div>


	<div id="result"> </div>

	</form>

	</div>

	<div id="space"></div>
	<div id="space"></div>

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