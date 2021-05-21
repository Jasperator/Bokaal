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

if (!empty($_POST['buy-item'])) {
$id = $_POST['buy-item'];

$item->buyItem($user,$id);
if($user->getStatus() == "seller"){
    $items = $item->getAllItemsExceptSeller($user);
    
    } else{
        $items = $item->getAllItems();
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/bootstrap.css">-->
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="/css/style.css">

    <title>Bokaal | Search</title>
</head>

<body>
    <?php include_once("../includes/nav.include.php");?>


    <div class="container">
        <div class="titel">
            <h2>Items</h2>
            <div class="line-under" ></div>
        </div>

        <ul id='all'>
            <?php foreach ($items as $item) : ?>
            <li id="list">
                <div>
                    <div>
                        <div id='foto'>
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="./uploads/<?= htmlspecialchars($item->item_image); ?>"/>
                                            
                                </div>
                            </div>

                        </div>
                        <div class="pl-3 pt-2 pr-2 pb-2 w-75">
                            <h5 class="text-primary"><?= htmlspecialchars($item->title); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($item->description); ?></p>
                            <p class="text-primary"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="">
                                <?= htmlspecialchars($item->quantity); ?> : <?= htmlspecialchars($item->unit); ?></p>
                            <p class="text-primary"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="">
                                <?= htmlspecialchars($item->price); ?> : <?= htmlspecialchars($item->currency); ?></p>

                            <form action="" method="post">

                                <div class="form-group">
                                    <button type="submit" name="buy-item" class="buy"
                                        value="<?= htmlspecialchars($item->id); ?>" name="buy"
                                        placeholder="Koop">Koop</button>
                                </div>
                            </form>

                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>
    </div>


    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>

</html>