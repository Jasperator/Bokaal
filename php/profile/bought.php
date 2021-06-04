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
        
<?php include_once("../profile/profile.php");?>

<ul id='all'>
            <?php foreach ($items as $item) : ?>                
                <div id="list-decoration" class="col-md-4">
                    <div class="itemId users" >
                        <div class="container">
                            <div class="card h-100" style="width: auto;">
                                <form  action="" method="post">
                                    <img id="picture" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" class="img-thumbnail border-0" />
                                                            
                                    <div id="card-body" style="padding:15px;">
                                        <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($item->category); ?></p>
                                        <p class="card-text"><?= htmlspecialchars($item->description); ?></p>
                                        <p class="card-text"><?= htmlspecialchars($item->quantity); ?> :  <?= htmlspecialchars($item->unit); ?></p>
                                        <p class="card-text"><?= htmlspecialchars($item->price); ?> :  <?= htmlspecialchars($item->currency); ?></p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>                                    
</ul>

<?php include_once("../includes/footer.php");?>

</body>
</html>