<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();


$items = $item->getAllItemsCart($user);

if (!empty($_POST['delete-cart-item'])) {
    $item_id = $_POST['delete-cart-item'];
    
    $item->deleteItemCart($item_id);
    $items = $item->getAllItemsCart($user);

    }



    if (!empty($_POST['buy-all-items'])) {
        
        $item->buyAll($user);
        $items = $item->getAllItemsCart($user);

    
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


    <title>Bokaal | Winkelmandje</title>
</head>
<body id="cart-body">
<?php include_once("../includes/nav.include.php");?>



    <div>
        <div>
            <h2 class="hoofdtitel">Winkelmandje</h2>
            
        </div>

        <ul id='all'>
            <?php foreach ($items as $item) : ?>
                <li id="list" class="list-group-item">
                    <div class="col-md-12">
                        <div class="d-flex flex-row">
                            <div id='' class="p-0 w-25">
                                <div id="wrapper">
                                    <div id="splash-info">
                                        <form  action="" method="post">
                                <img id="picture" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" class="img-thumbnail border-0" />
                                    </div>
                                </div>
                            
                            </div>
                            <div class="pl-3 pt-2 pr-2 pb-2 w-75">
                                <h5 class="text-primary"><?= htmlspecialchars($item->title); ?></h5>
                                <p class="text-primary"><?= htmlspecialchars($item->description); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->quantity); ?> :  <?= htmlspecialchars($item->unit); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->price); ?> :  <?= htmlspecialchars($item->currency); ?></p>
                            
                                <form  id="delete-cart" action="" method="post">

<div class="form-group">                                 
    <button type="submit" name="delete-cart-item"
        value="<?= htmlspecialchars($item->id); ?>" >Verwijder item</button>
</div>
</form>

                    </div>
                    <?php endforeach ?>
                    </div>
                </li>
        </ul>

        <?php if(!empty($items)) { ?>
        <form  id="buy-cart" action="" method="post">

<div class="form-group">                                 
    <button type="submit" name="buy-all-items"
        value="buy_all" >Koop alles</button>
</div>
</form>
<?php } ?>



  	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
</body>
</html>