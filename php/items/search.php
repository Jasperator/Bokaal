<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Distance.php");

$user = new classes\User($_SESSION['user']);
$itemClass = new classes\Item();
$distanceClass = new classes\Distance();


if($user->getStatus() == "seller"){
    $pageAndUsers = $itemClass->getAllItemsExceptSeller($user);
    $totalPages = $itemClass->countPagesAllItemsExceptSeller($user);


} else{
    $pageAndUsers = $itemClass->getAllItems($user);
    $totalPages = $itemClass->countPagesAllItems();

}
$maxPrice = $itemClass->maxPrice();
$maxDistance = $distanceClass->maxDistanceItems($user);
$minDistance = $distanceClass->minDistanceItems($user);


$page = $pageAndUsers[0];
$items = $pageAndUsers[1];



if(!empty($_GET['searchCategory'])){
    $priceRange = $_GET['priceRange'];
    if(isset($_GET['distanceRange'])) {
        $distanceRange = $_GET['distanceRange'];
    } else {
        $distanceRange = $maxDistance;
    }


    $user = new classes\User($_SESSION['user']);

    if(!empty($_GET['category'])) {
        $category =  "'". $_GET['category'] . "'";
    } else {
        $category = "category";
    }
    $searchName = urlencode($_GET['searchName']);
    $searchName = '%' . $searchName . '%';
    $pageAndItems = $itemClass->searchItemCategoryAndName($searchName, $category, $user, $priceRange, $distanceRange);
    $page = $pageAndItems[0];
    $items = $pageAndItems[1];
    $totalPages = $itemClass->searchItemCategoryAndNameCount($searchName, $category, $user, $priceRange, $distanceRange);


}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png> <link rel="stylesheet"
        href="../../css/style.css">

    <title>Bokaal | Zoeken</title>
</head>

<body id="search-body">
    <?php include_once("../includes/nav.include.php");?>


            <h2 class="hoofdtitel"> Zoeken </h2>

        <form class="" enctype="multipart/form-data" action="" method="GET">
                <!--<label  for="searchName">Search</label>-->
                <input class="search-bar" placeholder="Zoek" type="text" name="searchName" value="" />

            <div id="categorie-item">
                <select type="text" name="category" id="" class="form-control-search" placeholder="Geef de categorie in">
                    <option value="" selected disabled hidden>Categorie</option>
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
            </div>

            <input id="button_or_search" type="submit" value="Zoek" name="searchCategory">
            

                <br><br><br>


            <label class="priceLabel" for="priceRange">Max. prijs</label>

            <div class="slidecontainer">
                <input type="range" min="1.00" max="<?=$maxPrice?>" value="<?=$maxPrice?>" class="slider" name="priceRange" id="priceRange">
                <p> <span id="priceVal"></span> Euro </p>
            </div>
                <select type="text" name="distanceRange" id="" class="form-control-search">
                    <option value="" selected disabled hidden>Maximum Afstand</option>
                    <optgroup label="Maximum Afstand">

                        <option value="5000">< 5 km</option>
                        <option value="10000">< 10 km</option>
                        <option value="15000">< 15 km</option>
                        <option value="20000">< 10 km</option>
                        <option value="25000">< 25 km</option>
                        <option value="30000">< 30 km</option>
                        <option value="35000">< 35 km</option>
                        <option value="40000">< 40 km</option>
                        <option value="45000">< 45 km</option>
                        <option value="50000">< 50 km</option>
                        <option value="10000000">> 50 km</option>

                </select>



        </form>

        <ul  id="all-detail" class="row col-md-12">

            <?php foreach ($items as $item) :

            ?>
                
                <div id="list-decoration" class="col-md-4">
                    <div class="itemId" data-id="<?= htmlspecialchars($item->id); ?> ">
                        <div class="container">
                            <div class="card h-100 breed">
                                <form action="" method="post">
                                    <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?> " 
                                    class="img-thumbnail border-0"/>
                            
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                    <p class="card-text"><img class="zoekertje" src="../../images/icon/vegetables.png" alt="icon vegetables">
                                     <?= htmlspecialchars($item->category); ?></p>

                                    <!--<p class="card-text"><?= htmlspecialchars($item->description); ?></p>-->

                                    <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="icon stock">
                                     <?= htmlspecialchars($item->quantity); ?>   <?= htmlspecialchars($item->unit); ?></p>

                                    <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="icon price">
                                     <?= htmlspecialchars($item->price); ?>   <?= htmlspecialchars($item->currency); ?></p>
                                    
                                    <p class="card-text"> <img class="zoekertje" src="../../images/icon/place-green.png" alt="icon place"> <?= htmlspecialchars($item->distance); ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </ul>

    <div id="space"></div>

    <div id="pages" style="text-align: center">
            <?php
            $page = $pageAndUsers[0];
            for ($i=1; $i<=$totalPages; $i++) {  // print links for all pages
                echo "<a href='search.php?page=".$i."'";
                if ($i==$page)  echo " class='curPage'";
                echo ">".$i."</a> ";

            };
            ?>
        </div>    <script>
        var slider = document.getElementById("priceRange");

        var output = document.getElementById("priceVal");
        output.innerHTML = slider.value;

        slider.oninput = function() {
            output.innerHTML = this.value;
        }


        document.querySelectorAll('.itemId').forEach(item => {
            item.addEventListener('click', function () {

                window.location.href = `detailItem.php?data-id=${this.getAttribute('data-id')}`
            })
        })

    </script>

    <script src="../../js/jquery.min.js"></script>


    <?php include_once("../includes/footer.php");?>

</body>

</html>