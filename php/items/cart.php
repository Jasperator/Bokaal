<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Conversation.php");
require_once(__DIR__ . "/../../classes/Message.php");

$user = new classes\User($_SESSION['user']);
$itemClass = new classes\Item();


$items = $itemClass->getAllItemsCart($user);

if (!empty($_POST['delete-cart-item'])) {
    $item_id = $_POST['delete-cart-item'];

    $itemClass->deleteItemCart($item_id);
    $items = $itemClass->getAllItemsCart($user);

    }

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



    if (!empty($_POST['buy-all-items'])) {
        $sellers = $itemClass->getAllSellersCart($user);
        foreach ($sellers as $seller){

            $itemClass->startConversationSellers($user,$seller->id);
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
        $itemClass->buyAll($user);
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


            <h2 class="hoofdtitel">Winkelmandje</h2>

        <ul id="all-detail" class="row col-md-12">

            <?php $price = 0;
            foreach ($items as $item) :
                $seller = $itemClass->getUserFromItem($item->id);
                $price += $item->price;
                ?>
                <div id="list-decoration" class="col-md-4">
                    <div class="container" >
                        <div class="card h-100 breed" >
                            <form  action="" method="post">
                                <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?>" 
                                class="img-thumbnail border-0" />
                                
                                <div id="card-body" style="padding:15px;">
                                    <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                    <p class="card-text"><img class="zoekertje" src="../../images/icon/vegetables.png" alt="icon vegetables">
                                    <?= htmlspecialchars($item->category); ?></p>

                                    <p class="card-text"><img class="zoekertje" src="../../images/icon/description.png" alt="icon place">
                                    <?= htmlspecialchars($item->description); ?></p>

                                    <p class="card-text"><img class="zoekertje" src="../../images/icon/kg-green.svg" alt="icon stock">
                                    <?= htmlspecialchars($item->quantity); ?>    <?= htmlspecialchars($item->unit); ?></p>

                                    <p class="card-text"><img class="zoekertje" src="../../images/icon/coin-green.svg" alt="icon price">
                                    <?= htmlspecialchars($item->price); ?>    <?= htmlspecialchars($item->currency); ?></p>
                            
                                    <form  id="delete-cart" action="" method="post">

                                        <div class="form-group">                                 
                                            <button class="btn btn detail" type="submit" name="delete-cart-item"
                                            value="<?= htmlspecialchars($item->id); ?>">Verwijder item</button>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        </ul>

        <?php if(!empty($items)) { ?>

                <div class="total_price">
                    <p>Totale prijs: <?= $price ?></p>
                </div>

            <button type="button" id="buy-all" class="buy-all">
                <a>Afrekenen</a>
            </button>

            <div id="buy-all-items-modal" class="modal">
                <div class="modalContent">
                    <span class="close">&times;</span>
                    <h4>Afrekenen</h4>
                    <div class="total_price">
                        <p>Totale prijs: <?= $price ?></p>
                    </div>
                    <form  id="buy-cart" action="" method="post">

                        <div class="form-group">
                            <button type="submit" name="buy-all-items" value="buy_all" >Koop alles</button>
                        </div>
                    </form>
                </div>
            </div>

<?php } ?>

        <?php include_once("../includes/footer.php");?>

<script>
    // Get the modal
    var modal = document.getElementById("buy-all-items-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("buy-all");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

  	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
</body>
</html>