<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Conversation.php");
require_once(__DIR__ . "/../../classes/Message.php");

$user = new classes\User($_SESSION['user']);
$item = new classes\Item();


$items = $item->getAllItemsCart($user);

if (!empty($_POST['delete-cart-item'])) {
    $item_id = $_POST['delete-cart-item'];
    
    $item->deleteItemCart($item_id);
    $items = $item->getAllItemsCart($user);

    }



    if (!empty($_POST['buy-all-items'])) {
        $sellers = $item->getAllSellersCart($user);
        foreach ($sellers as $seller){

            $item->startConversationSellers($user,$seller->id);
            $active_conversations = $user->getSpecifiqueConversations($seller->id);
            $active_conversation = $active_conversations->id;

            $conversation = new classes\Conversation();
            $conversation->setId($active_conversation);
            $conversation->readMessages($user->getId());
            $messages = $conversation->getMessages();
            $chat_partner = $conversation->getPartner($user->getId());
            $standard_message= 'Hello ' . $chat_partner->fullname. ', ik heb een item van jou gekocht. Wanneer past het voor jou om deze op te halen?';

            $time = date('Y-m-d H:i:s');
            $message = new classes\Message();
            $message->setConversation_id($active_conversation);
            $message->setSender_id($user->getId());
            $message->setReceiver_id($chat_partner->id);
            $message->setContent($standard_message);
            $message->setTimestamp($time);
            $message->saveMessage();


        }
        $item->buyAll($user);
        header('Location: ../profile/chat.php');



    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="../../css/style.css">


    <title>Bokaal | Winkelmandje</title>
</head>
<body id="cart-body">
<?php include_once("../includes/nav.include.php");?>


        <div>
            <h2 class="hoofdtitel">Winkelmandje</h2>            
        </div>
        <ul id="all-detail" class="row col-md-12">

            <?php foreach ($items as $item) : ?>
                <div id="list-decoration" class="col-md-4">
                    <div class="container" >
                        <div class="card h-100" style="width: auto;">
                            <form  action="" method="post">
                                <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" 
                                class="img-thumbnail border-0" />
                                
                                <div id="card-body" style="padding:15px;">
                                    <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($item->category); ?></p>
                                    <p class="card-text"><?= htmlspecialchars($item->description); ?></p>
                                    <p class="card-text"><?= htmlspecialchars($item->quantity); ?>    <?= htmlspecialchars($item->unit); ?></p>
                                    <p class="card-text"><?= htmlspecialchars($item->price); ?>    <?= htmlspecialchars($item->currency); ?></p>
                            
                                    <form  id="delete-cart" action="" method="post">

                                        <div class="form-group">                                 
                                            <button type="submit" name="delete-cart-item"
                                            value="<?= htmlspecialchars($item->id); ?>" >Verwijder item</button>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        </ul>

        <?php if(!empty($items)) { ?>
        <form  id="buy-cart" action="" method="post">

<div class="form-group">                                 
    <button type="submit" name="buy-all-items"
        value="buy_all" >Koop alles</button>
</div>
</form>
<?php } ?>

        <?php include_once("../includes/footer.php");?>



  	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
</body>
</html>