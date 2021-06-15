<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();

$itemsAvailable = $item->getAvailableItemsFromSeller($user);
if(!empty($_POST['delete'])){
    $item->deleteOwnItem($_POST['deleteHidden'], $user);
    $itemsAvailable = $item->getAvailableItemsFromSeller($user);

}
if(!empty($_POST['edit_item'])){
    session_status();
    $_SESSION['item_id'] = $_POST['edit_item'];
    header('Location: edit_item.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Bokaal | Search</title>
</head>

<body>
    <?php include_once("../includes/nav.include.php");?>
    <div>


        <div>
            <h2 id="hoofdtitel" class="hoofdtitel">Aanbiedingen</h2>
        </div>
        <ul id="all-detail" class="row col-md-12">    
            
            <?php foreach ($itemsAvailable as $item) : ?>    
                <div id="list-decoration" class="col-md-4">
                    <div class="container" >
                        <div class="card h-100" style="width: auto;">
                                    <form action="" method="post">
                                        <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?> "
                                            class="img-thumbnail border-0"/>                           

                        
                                        <div id="card-body" style="padding:15px;">
                                            <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                            <p class="card-text"> <img class="zoekertje" src="../../images/icon/vegetables.png" alt="">
                                            <?= htmlspecialchars($item->category); ?></p>
                                            <p class="card-text"><img class="zoekertje" src="../../images/icon/description.png"
                                                 alt="icon place"> <?= htmlspecialchars($item->description); ?></p>
                                            <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="">
                                                <?= htmlspecialchars($item->quantity); ?>  <?= htmlspecialchars($item->unit); ?></p>
                                            <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="">
                                                <?= htmlspecialchars($item->price); ?>  <?= htmlspecialchars($item->currency); ?></p>
                                        </div>

                                    <form action="" method="POST" class="edit">
                                        <div class="col text-center" style="margin-bottom:15px;">
                                            <input type="submit" class="editButton" value="Bewerken">
                                            <input type="hidden" class="btn btn-primary"  name="edit_item" value="<?= htmlspecialchars($item->id); ?>" name="deleteHidden">

                                        </div>
                                    </form>
                                    
                                    <form action="" method="POST" class="delete">
                                        <div class="col text-center" style="margin-bottom:15px;">
                                            <input type="submit" class="btn btn-danger btn" value="Verwijder" name="delete">
                                            <input type="hidden" class="btn btn-danger btn" value="<?= htmlspecialchars($item->id); ?>" name="deleteHidden">

                                        </div>
                                    </form>
                        </div>
                    </div>
                </div>                    
            <?php endforeach ?>

        </ul>
    <div id="space"></div>

<?php include_once("../includes/footer.php");?>

</body>
</html>
