<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();

$itemId = $_SESSION['item_id'];
$detailItem = $item->getItem($itemId);


if (!empty($_POST['updateItem'])) {
    $item = new classes\Item();


    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here

    $item->setTitle($_POST['title']);
    $item->setCategory($_POST['category']);
    $item->setDescription($_POST['description']);
    $item->setQuantity($_POST['quantity']);
    $item->setUnit($_POST['unit']);
    $item->setPrice($_POST['price']);
    $item->setCurrency($_POST['currency']);

    try {
        $item->updateItem($itemId);
        header('Location: settings_items.php');

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
	<link rel="icon" type="image/svg" href=images/logo/favicon.png>
    <link rel="stylesheet" href="/css/bootstrap.css">    
    <link rel="stylesheet" href="../../css/style.css">


    <title>Bokaal | Sell</title>

    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png> 

</head>

<body id="sell-body">

    <?php include_once("../includes/nav.include.php") ?>

    <a class="backArrow" href="/php/profile/settings_items.php"><img src="/images/icon/back.svg" style="width: 50%;"></a>

    <h2 class="hoofdtitel">Edit producten</h2>


    <form class="registerForm-sell" enctype="multipart/form-data" action="" method="post">


        <div id="category" class="form-sell">
        <label class="tag-name-edit" for="">Soort groente/fruit</label>

            <select type="text" name="category" id="categorie" class="form-control" placeholder="  Geef de categorie in"
                    required>
                <optgroup label="Groenten" >

                    <option value="Bladgroenten">Bladgroenten</option>
                    <option value="Kiemgroenten">Kiemgroenten (spruiten, tuinkers,...)</option>
                    <option value="Koolsoorten">Koolsoorten</option>
                    <option value="Stengelgewassen">Stengelgewassen (prei, selder,...)</option>
                    <option value="Uien">Uien</option>
                    <option value="Vruchtgroenten">Vruchtgroenten (tomaat, aubergine, courgette,...)</option>
                    <option value="Wortel- knolgewassen">Wortel- knolgewassen</option>
                    <option value="Overige groenten">Overige groenten</option>

                    <optgroup label="Fruit">

                        <option value="Citrusfruit">Citrusfruit (citroen, limoen,...</option>
                        <option value="Pitfruit">Pitfruit (appel, peer,...)</option>
                        <option value="Steenvruchten">Steenvruchten (pruim, perzik, kers,...)</option>
                        <option value="Zacht fruit">Zacht fruit (aardbei, bessen,...)</option>
                        <option value="Exotisch fruit">Exotisch fruit (passievrucht, papaja,...</option>
                        <option value="overig fruit">overig Fruit</option>
            </select>
        </div>

        <div id="top" class="form-sell">
        <label class="tag-name-edit" for="">Titel</label>
            <input type="text" name="title" id="title-edit" class="form-control" value="<?= htmlspecialchars($detailItem->title); ?>" placeholder="Titel" required>
        </div>

        <div class="form-sell">
        <label class="tag-name-edit" for="">Beschrijving</label>
            <input type="text" name="description" id="description-edit" class="form-control" value="<?= htmlspecialchars($detailItem->description); ?>" placeholder="Beschrijving"
                   required>
        <label class="tag-name-edit" for="">Hoeveelheid en prijs</label>
        </div>

        <div class="form-sell-item-edit">
        
            <div id="hoeveelheid-edit">
                <div id="select-items-selectItems" class="select-items-selectItems">
                    <input class="select-items-nr" type="number" name="quantity"  value="<?= htmlspecialchars($detailItem->quantity); ?>"
                           placeholder=" <?= htmlspecialchars($detailItem->quantity); ?>" required>

                    <select class="select-items-select-unit" type="text" name="unit"
                        placeholder="Kies soort hoeveelheid" required>
                            <optgroup label="Hoeveelheid">
                                <option value="Gram">Gram</option>
                                <option value="Kg">Kg</option>
                                <option value="Stuks">Stuks</option>
                            </select>            
                            
                        <input class="select-items-select-price"  type="number" name="price" placeholder="Prijs" step=".01" value="<?= htmlspecialchars($detailItem->price); ?>" required>
                        <input class="select-items-select-value" type="text" name="currency" Value="Euro" disabled>
                </div>
            </div>


        </div>


    <?php if (isset($error)) : ?>
        <div><?php echo $error; ?></div>
    <?php endif; ?>

    <div id="result"> </div>
            <div class="form-group">
                <input id="button_orange" type="submit" value="Opslaan" name="updateItem">
            </div>



    </form>



    <div id="space"></div>
    <div id="space"></div>

    <script>
        let unit = '<?=htmlspecialchars($detailItem->unit);?>';
        console.log(unit);
        let category = '<?=htmlspecialchars($detailItem->category);?>';

        document.getElementById('unit').querySelectorAll("option").forEach(item => {if(item.value == unit) {document.getElementById('unit').value = unit;}});
        document.getElementById('categorie').querySelectorAll("option").forEach(item => {if(item.value == category) {document.getElementById('categorie').value = category}});

    </script>
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>

    <?php include_once("../includes/footer.php");?>

</body>

</html>
