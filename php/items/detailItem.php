<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();

$itemId = $_GET["data-id"];
$seller = $item->getUserFromItem($itemId);
$detailItem = $item->getItem($itemId);
$allItemsSeller = $item->getAllItemsBySellerId($itemId);
$distance =$user->getDistance($user->getAddress(),$user->getPostal_code(), htmlspecialchars($seller->address), htmlspecialchars($seller->postal_code));

if (!empty($_POST['buy-item'])) {
    $id = $_POST['buy-item'];

    $item->buyItem($user,$id);
    header("Location: cart.php");


}

if(!empty($_POST['start_chat'])){
    $user = new classes\User($_SESSION['user']);
    $userId = $_POST["chat_id"];

    $item->startConversationSellers($user,$userId);
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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">


    <title>Bokaal | Search</title>
</head>

<body id="search-body">
<?php include_once("../includes/nav.include.php");?>


<div>
    <h2 class="hoofdtitel">Verkoper</h2>

    <div class="card mb-3 boer-detail" style="max-width: 50%; max-height:;" >
        <div class="row g-0">
            <div class="col-md-4">
                <form action="" method="post">
                    <img class="boer-img" id="picture" style="height:250px; width:250px;" src="/uploads/<?= htmlspecialchars($seller->profile_img); ?>"/>
                        </div>    
                            <div class="col-md-8">
                                <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($seller->fullname); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($seller->location); ?></p>
                                <p class="card-text"><?= htmlspecialchars($seller->company);  ?></p>
                                <p class="card-text"> Afstand:
                                    <?=
                                    $distance->text;?></p>

                                    <form  id="start_chat" class="chat-button" action="" method="post">
                                        <div class="form-group">

                                            <input type="hidden" name="chat_id" value="<?= htmlspecialchars($seller->id);?>" placeholder="naam" />
                                            <input id="chatnaam"  class="btn" type="submit" name="start_chat" value="chat" />
                                        </div>
                                    </form>
                                </div>
                            </div>            
                        </div>
            </div>
        </div>
    </div>            
    
    <div class="titel">
        <h2 class="subtitel" >Items</h2>
    

    <ul id="all-detail" class="row col-md-12">
            <div id="list-decoration" class="col-md-4">
                <div class="itemId">
                    <div class="container">
                        <div class="card h-100 breed">
                            <form action="" method="post">
                                <img class="card-img-top" id="picture" src="/uploads/<?= htmlspecialchars($detailItem->item_image); ?> "
                                class="img-thumbnail border-0"/>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($detailItem->title); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($detailItem->description); ?></p>
                                <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="">
                                    <?= htmlspecialchars($detailItem->quantity); ?> : <?= htmlspecialchars($detailItem->unit); ?></p>
                                <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="">
                                    <?= htmlspecialchars($detailItem->price); ?> : <?= htmlspecialchars($detailItem->currency); ?></p>

                                <form action="" method="post">
                                    <div class="item_profile">
                                        <button type="submit" name="buy-item" class="btn btn detail"
                                            value="<?= htmlspecialchars($detailItem->id); ?>" name="buy"
                                            placeholder="Koop">Toevoegen aan winkelmandje</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </ul>
</div>
            <div class="titel">
                <h2 class="subtitel">Other items</h2>
            </div>

            <ul id="all-detail" class="row col-md-12">

                <?php foreach ($allItemsSeller as $item) : ?>
                    <div id="list-decoration" class="col-md-4">
                        <div class="itemId" id="item" data-id = "<?= htmlspecialchars($item->id); ?> ">
                            <div class="container">
                                <div class="card h-100 breed">
                                    <form action="" method="post">
                                        <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?> "
                                        class="img-thumbnail border-0"/>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($item->category); ?></p>
                                        <p class="card-text"><?= htmlspecialchars($item->description); ?></p>
                                        <p class="card-text"> <img class="zoekertje" src="../../images/icon/coin-green.svg" alt="">
                                            <?= htmlspecialchars($item->quantity); ?> : <?= htmlspecialchars($item->unit); ?></p>
                                        <p class="card-text"> <img class="zoekertje" src="../../images/icon/kg-green.svg" alt="">
                                            <?= htmlspecialchars($item->price); ?> : <?= htmlspecialchars($item->currency); ?></p>

                                        <form action="" method="post">
                                            
                                    </div>                           
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </ul>

            <div id="space"></div>

            <script>
                document.querySelectorAll('.others').forEach(item => { item.addEventListener('click', function () {

                    window.location.href = `detailItem.php?data-id=${this.getAttribute('data-id')}`
                })})
            </script>
<script src="../../js/jquery.min.js"></script>

<?php include_once("../includes/footer.php");?>

</body>

</html>