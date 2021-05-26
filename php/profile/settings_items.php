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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="../../css/style.css">

    <title>Bokaal | Search</title>
</head>

<body id="search-body">
<?php include_once("../includes/nav.include.php");?>

<ul id='all'>
    <h1>Items for sale</h1>

    <?php foreach ($itemsAvailable as $item) : ?>
    <li id="list">
        <div class="container" id="item" data-id = "<?= htmlspecialchars($item->id); ?> ">
            <div>
                <div id='foto'>
                    <div id="wrapper">
                        <div id="splash-info">
                            <form action="" method="post">
                                <img id="picture" src="/uploads/<?= htmlspecialchars($item->item_image); ?> "/>

                        </div>
                    </div>

                </div>
                <div id="info">
                    <h5 class="text-primary"><?= htmlspecialchars($item->title); ?></h5>
                    <p class="text-primary"><?= htmlspecialchars($item->category); ?></p>
                    <p class="text-primary"><?= htmlspecialchars($item->description); ?></p>
                    <p class="text-primary"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="">
                        <?= htmlspecialchars($item->quantity); ?> : <?= htmlspecialchars($item->unit); ?></p>
                    <p class="text-primary"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="">
                        <?= htmlspecialchars($item->price); ?> : <?= htmlspecialchars($item->currency); ?></p>


                </div>
                <form action="" method="POST" class="delete">
                    <div class="form-group">
                        <input id="button_or" type="submit" class="delete" value="Delete" name="delete">
                        <input id="button_or" type="hidden" class="delete" value="<?= htmlspecialchars($item->id); ?>" name="deleteHidden">

                    </div>
                </form>
                <?php endforeach ?>
            </div>
    </li>
</ul>

</body>
</html>
