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
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png> <link rel="stylesheet" href="../../css/style.css">
    


    <title>Bokaal | Winkelmandje</title>
</head>

<body id="cart-body">
    <?php include_once("../includes/nav.include.php");?>


            <h2 class="hoofdtitel">Winkelmandje</h2>
<?php if(count($items) <= 0){ ?>


            <img id="cartPlaceholder" src="../../images/cartPlaceholder.png" alt="cart placeholder">
<?php } else { ?>
        <ul id="all-detail" class="row col-md-12">

        <?php $price = 0;
            foreach ($items as $item) :
                $seller = $itemClass->getUserFromItem($item->id);
                $price += $item->price;
                ?>
        <div id="list-decoration" class="col-md-4">
            <div class="container">
                <div class="card h-100 breed">
                    <form action="" method="post">
                        <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?>"
                            class="img-thumbnail border-0" />

                        <div id="card-body" style="padding:15px;">
                            <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                            <p class="card-text"><img class="zoekertje" src="../../images/icon/vegetables.png"
                                    alt="icon vegetables">
                                <?= htmlspecialchars($item->category); ?></p>

                            <p class="card-text"><img class="zoekertje" src="../../images/icon/description.png"
                                    alt="icon place">
                                <?= htmlspecialchars($item->description); ?></p>

                            <p class="card-text"><img class="zoekertje" src="../../images/icon/kg-green.svg"
                                    alt="icon stock">
                                <?= htmlspecialchars($item->quantity); ?> <?= htmlspecialchars($item->unit); ?></p>

                            <p class="card-text"><img class="zoekertje" src="../../images/icon/coin-green.svg"
                                    alt="icon price">
                                <?= htmlspecialchars($item->price); ?> <?= htmlspecialchars($item->currency); ?></p>

                            <form id="delete-cart" action="" method="post">

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

<?php } ?>


        <?php if(!empty($items)) { ?>

    <div class="total_price">
        <p class="total_price_titel">Totale prijs</p>

        <div id="prijs-start">
            <p class="prijs_een">Prijs item: </p> 
            <p class="line-rechts" ><?= $price ?></p>
        </div>

        <div id="prijs-twee" >
            <p class="prijs_twee" > Kopers garantie </p>
            <p class="line-rechts-twee"><?= ($price/100)*10 ?></p>
        </div>

        <div id="prijs-alles">
            <p class="prijs-tott">Totaal bedrag </p>
            <p class="bedrag-eind"><?= $price+(($price/100))*10 ?></p>
        </div>

    </div>

    <button type="button" id="buy-all" class="buy-all">
        <a>Afrekenen</a>
    </button>

    <!-- buy thingy-->

    <div id="buy-all-items-modal" class="modal">
        <div class="modalContent" id="total-box">
            <span class="close">&times;</span>

            
            

            <div class="container-box">
                <h4 class="head-calc">Afrekenen</h4>
                <div class="price">
                    <h1>Totale prijs <?= $price+(($price/100)*10) ?> Euro !</h1><br>
                </div>

                <div class="card__container">
                    <div class="card-deco">
                        <div class="row paypal">
                            <div class="left">
                                <input class="radio" id="pp" type="radio" name="payment" />
                                <div class="radio">
                                </div>
                                <label  class="label" for="pp">Paypal</label>
                            </div>

                            <div class="right">
                                <img class="small-cardIcon-pp" src="../../images/paycard/paypal.jpg" alt="paypal" />
                            </div>
                        </div>
                        <div class="row credit">
                            <div class="left">
                                <input class="radio" id="cd" type="radio" name="payment" />
                                <div class="radio"></div>
                                <label  class="label" class="naam" for="cd">Bank kaart</label>
                            </div>

                            <div class="right">
                                <img class="small-cardIcon" src="../../images/paycard/mastercard-word.svg" alt="mastercard" />
                                <img class="small-cardIcon" src="../../images/paycard/amex.png" alt="amex" />
                                <img class="small-cardIcon" src="../../images/paycard/maestro-word.svg" alt="maestro" />
                            </div>
                        </div>
                        <div>
                            <div class="info">
                                <label  class="label" for="cardholdername">Naam</label>
                                <input class="cardholdername" placeholder="Naam" id="cardholdername" type="text" />
                            </div>
                        </div>
                        <div>
                            <div class="info">
                                <label  class="label" id="label" for="cardnumber">Kaart nummer</label>
                                <input class="cardnumber" id="cardnumber" type="text" pattern="[0-9]{16,19}" maxlength="19"
                                    placeholder="8888-8888-8888-8888" />
                            </div>
                        </div>
                        <div class="row details">
                            <div class="left">
                                <label class="label-expiry" for="expiry-date">Verval datum</label>
                                <select class="select" id="expiry-date">
                                    <option>Maand</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select class="select" id="expiry-date">
                                    <option>Jaar</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                    <option value="2032">2032</option>
                                    <option value="2033">2033</option>
                                    <option value="2034">2034</option>
                                    <option value="2035">2035</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <form id="buy-cart" action="" method="post">

                <div class="form-group">
                    <button class="buy-all-items" type="submit" name="buy-all-items" value="buy_all">Koop alles</button>
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
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>

</html>