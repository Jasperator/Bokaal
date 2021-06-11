<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$itemClass = new classes\Item();


$items = $itemClass->getAllItemsbought($user);

if(!empty($_POST['start_chat'])){
    $user = new classes\User($_SESSION['user']);
    $userId = $_POST["chat_id"];

    $itemClass->startConversationSellers($user,$userId);
    $active_conversations = $user->getSpecifiqueConversations($userId);
    $active_conversation = $active_conversations->id;

    session_status();
    $_SESSION['chat_id'] = $active_conversation;
    header('Location: ../profile/message.php');
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

    <title>Bokaal | Bestellingen</title>
</head>
<body id="bought-body">
<?php include_once("../includes/nav.include.php") ?>


            <h2 class="hoofdtitel" >Bestellingen</h2>

<?php include_once("../includes/subNav.php");?>

<?php if(count($items) <= 0){ ?>


<img class="Placeholder" src="../../images/boughtPlaceholder.png" alt="cart placeholder">
<?php } else { ?>

<ul id='all' class="row col-md-12">
            <?php foreach ($items as $item) :
                $seller = $itemClass->getUserFromItem($user, $item->id);
                ?>
                <div id="list-decoration" class="col-md-4">
                    <div class="itemId users" >
                        <div class="container">
                            <div class="card h-100 breed">
                                <form  action="" method="post">
                                    <img id="picture" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" class="img-thumbnail border-0" />
                                                            
                                    <div id="card-body" style="padding:15px;">
                                        <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>

                                        <p class="card-text"><img class="zoekertje" src="../../images/icon/vegetables.png" alt="icon vegetables">
                                         <?= htmlspecialchars($item->category); ?></p>

                                        <p class="card-text"> <img class="zoekertje" src="../../images/icon/description.png" alt="icon description">
                                         <?= htmlspecialchars($item->description); ?></p>

                                        <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="icon stock">
                                         <?= htmlspecialchars($item->quantity); ?>   <?= htmlspecialchars($item->unit); ?></p>       

                                        <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="icon price">
                                         <?= htmlspecialchars($item->price); ?>   <?= htmlspecialchars($item->currency); ?></p>
                                        <?php if($seller){ ?>
                                        <form  id="start_chat" class="chat-button" action="" method="post">
                                            <div class="form-group">

                                                <input type="hidden" name="chat_id" value="<?= htmlspecialchars($seller->id);?>" placeholder="naam" />
                                                <input id="chatnaam"  class="btn" type="submit" name="start_chat" value="chat" />
                                            </div>
                                        </form> <?php } ?>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
</ul>
<?php } ?>

<?php include_once("../includes/footer.php");?>

</body>
</html>