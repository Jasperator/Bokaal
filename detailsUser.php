<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/Item.php");
require_once(__DIR__ . "/classes/User.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item();

$userId = $_GET["data-id"];
$seller = $user->getUserFromId($userId);
$allItemsSeller = $user->getAllItemsById($userId);

if(!empty($_POST['start_chat'])){
    $user = new classes\User($_SESSION['user']);
    $userId = $_GET["data-id"];

    $item->startConversationSellers($user,$userId);
    $active_conversations = $user->getSpecifiqueConversations($userId);
    $active_conversation = $active_conversations->id;

    session_status();
    $_SESSION['chat_id'] = $active_conversation;
    header('Location: php/profile/message.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=/images/logo/favicon.png>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">


    <title>Bokaal | Search</title>
</head>

<body id="search-body">
<?php include_once("php/includes/nav.include.php");?>


    <h2 class="hoofdtitel">Verkoper</h2>

    <div class="container">
            <div id="foto">
                <div id="wrapper">
                    <div id="splash-info">
                        <form action="" method="post">
                            <img id="picture" src="/uploads/<?= htmlspecialchars($seller->profile_img); ?>"
                                 class="img-thumbnail border-0" />
                    </div>
                </div>
            </div>

            <div id="info">
                <h5 class="text-primary"><?= htmlspecialchars($seller->fullname); ?></h5>
                <p class="text-primary"><?= htmlspecialchars($seller->location); ?></p>
                <p class="text-primary"><?= htmlspecialchars($seller->company);  ?></p>
                <p class="text-primary"> Afstand:
                    <?= $user->getDistance($user->getAddress(),$user->getPostal_code(), htmlspecialchars($seller->address), htmlspecialchars($seller->postal_code), "K");  ?>
                </p>
                <form  id="start_chat" action="" method="post">

                    <div class="form-group">
                        <button type="submit" name="start_chat"
                                value="Chat" >Chat</button>
                    </div>
                </form>
            </div>

                <h2 class="hoofdtitel">Items</h2>

            <ul id='all'>
                <?php foreach ($allItemsSeller as $item) : ?>
                <li id="list">
                    <div class="container others" id="item" data-id = "<?= htmlspecialchars($item->id); ?> ">
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
                                <p class="text-primary"> <img class="zoekertje" src="/images/icon/coin-green.svg" alt="">
                                    <?= htmlspecialchars($item->quantity); ?> : <?= htmlspecialchars($item->unit); ?></p>
                                <p class="text-primary"> <img class="zoekertje" src="/images/icon/kg-green.svg" alt="">
                                    <?= htmlspecialchars($item->price); ?> : <?= htmlspecialchars($item->currency); ?></p>

                            </div>
                        </div>

    </li>

    <?php endforeach ?>
            </ul>
    </div>




            <script>
                document.querySelectorAll('.others').forEach(item => { item.addEventListener('click', function () {

                    window.location.href = `/php/items/detailItem.php?data-id=${this.getAttribute('data-id')}`
                })})
            </script>
            <script src="/js/jquery.min.js"></script>

<?php include_once("php/includes/footer.php");?>

</body>

</html>