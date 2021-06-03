<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();


$items = $item->getAllItemsbought($user);

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

    <title>Aankopen</title>
</head>
<body id="bought-body">
<?php include_once("../includes/nav.include.php") ?>

<div>
        <div>
            <h2 class="hoofdtitel" >Bestellingen</h2>
        </div>
        
<?php include_once("../includes/subNav.php");?>

<ul id='all'>
            <?php foreach ($items as $item) : ?>
                <li id="list">
                    <div class="container">
                        <div>
                            <div id='foto'>
                                <div id="wrapper">
                                    <div id="splash-info">
                                        <form  action="" method="post">
                                <img id="picture" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" class="img-thumbnail border-0" />
                                    </div>
                                </div>
                            
                            </div>
                            <div class="pl-3 pt-2 pr-2 pb-2 w-75">
                                <h5 class="text-primary"><?= htmlspecialchars($item->title); ?></h5>
                                <p class="text-primary"><?= htmlspecialchars($item->category); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->description); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->quantity); ?> :  <?= htmlspecialchars($item->unit); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->price); ?> :  <?= htmlspecialchars($item->currency); ?></p>


                    </div>
                    <?php endforeach ?>
                    </div>
                </li>
        </ul>

<?php include_once("../includes/footer.php");?>

</body>
</html>