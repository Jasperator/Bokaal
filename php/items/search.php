<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();

if($user->getStatus() == "seller"){
$items = $item->getAllItemsExceptSeller($user);


} else{
    $items = $item->getAllItems();
}


if (!empty($_POST['category']) and (empty($_POST['searchName']))) {
    $category = $_POST['category'];
$items = $item->searchItemCategory($category, $user);
}

if (!empty($_POST['searchName']) and (empty($_POST['category']))) {
    $searchName = urlencode($_POST['searchName']);
    htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8');
    $searchName = '%' . $searchName . '%';
    $items = $item->searchItemName($searchName, $user);
}

if (!empty($_POST['searchName']) and (!empty($_POST['category']))) {
    $category = $_POST['category'];
    $searchName = urlencode($_POST['searchName']);
    htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8');
    $searchName = '%' . $searchName . '%';
    $items = $item->searchItemCategoryAndName($searchName, $category, $user);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png> <link rel="stylesheet"
        href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">


    <title>Bokaal | Search</title>
</head>

<body id="search-body">
    <?php include_once("../includes/nav.include.php");?>


    <div class="container">

        <div class="titel">
            <h2 class="hoofdtitel">Items</h2>
        </div>

        <form class="" enctype="multipart/form-data" action="" method="post">
            <div>
                <!--<label  for="searchName">Search</label>-->
                <input class="form-control rounded" placeholder="Zoek" type="search" name="searchName" aria-label="Search" aria-describedby="search-addon" value="" /> 
                 </span>
            </div>

            <!--<div class="input-group rounded">
  <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
    aria-describedby="search-addon" />
  <span class="input-group-text border-0" id="search-addon">
    <i class="fas fa-search"></i>
  </span>
</div>-->

            <div id="categorie-item" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <select type="text" name="category" id="" class="form-control-search" placeholder="Geef de categorie in"
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
                        <option value="Wortel en knolgewassen">Wortel- knolgewassen</option>
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

                <div class="">
                    <input id="button_or_search" type="submit" class="" value="Search" name="searchCategory">
                </div>

            </div>


        </form>
        <div >

            <ul id='all-detail'>

                <?php foreach ($items as $item) : ?>
                <li id="list-decoration">
                    
                    <div class="itemId" data-id="<?= htmlspecialchars($item->id); ?> ">
                        <div class="container">
                            <div>
                                <div>
                                    <div class="card" style="width: 18rem;">
                                        <form action="" method="post">
                                            <img class="card-img-top"
                                                src="/uploads/<?= htmlspecialchars($item->item_image); ?> " />

                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($item->category); ?></p>
                               <!-- <p class="card-text"><?= htmlspecialchars($item->description); ?></p>-->
                                <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg"
                                        alt="">
                                    <?= htmlspecialchars($item->quantity); ?> : <?= htmlspecialchars($item->unit); ?>
                                </p>
                                <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg"
                                        alt="">
                                    <?= htmlspecialchars($item->price); ?> : <?= htmlspecialchars($item->currency); ?>
                                </p>


                            </div>
                            <?php endforeach ?>
                        </div>
                </li>
            </ul>
        </div>
    </div>
    <script>
        document.querySelectorAll('.itemId').forEach(item => {
            item.addEventListener('click', function () {

                window.location.href = `detailItem.php?data-id=${this.getAttribute('data-id')}`
            })
        })
    </script>

    <script src="../../js/jquery.min.js"></script>
</body>

</html>