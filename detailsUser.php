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
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">


    <title>Bokaal | Search</title>
</head>

<body id="search-body">
<?php include_once("php/includes/nav.include.php");?>


    <h2 class="hoofdtitel"> Verkoper </h2>

    <div class="container-boer">
            <h2 class="verkoper"><?= htmlspecialchars($seller->fullname);  ?></h2>
            <div class="locatie-boer">
                <p><?= htmlspecialchars($seller->location); ?>,</p>
                <p class="afstand"> <?= htmlspecialchars($seller->address); ?></p>
            </div>
            <div class="locatie-boer">
                <p class="text-muted"> Afstand: <?=$seller->distance;?></p>
            </div>

            <div>
                <div>
                    <div>
                        <div class="img-text">
                            <form class="boer-profile-pic-user" action="" method="post">
                                <img class="boer-profile-pic-img"
                                    src="/uploads/<?= htmlspecialchars($seller->profile_img); ?>" />
                                <div>
                                    <h5 class="full-name-boer"><?= htmlspecialchars($seller->fullname); ?></h5>
                                    <p class="bio-boer">"<?= htmlspecialchars($seller->bio); ?>"</p>
                                    <form action="" method="post">
                                        <div>
                                            <input type="hidden" name="chat_id"
                                                value="<?= htmlspecialchars($seller->id);?>" placeholder="naam" />
                                            <input id="chatnaam" type="submit" name="start_chat"
                                                value="Stuur een bericht" />
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php if(count($allItemsSeller) > 0){ ?>
                <h2 class="items-header" >Aanbiedingen</h2>

            <ul id="all-detail" class="row col-md-12">

                <?php foreach ($allItemsSeller as $item) : ?>  
                    <div id="list-decoration" class="col-md-4">              
                        <div class="others" id="item" data-id = "<?= htmlspecialchars($item->id); ?> ">
                                <div class="container">
                                    <div class="card h-100 breed">
                                            <form action="" method="post">
                                                <img class="card-img-top" src="/uploads/<?= htmlspecialchars($item->item_image); ?> "
                                                class="img-thumbnail border-0"/>

                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($item->title); ?></h5>
                                                <p class="card-text"><?= htmlspecialchars($item->category); ?></p>
                                                <!--<p class="card-text"><?= htmlspecialchars($item->description); ?></p>-->
                                                <p class="card-text"> <img class="zoekertje" src="/images/icon/coin-green.svg" alt="">
                                                    <?= htmlspecialchars($item->quantity); ?> <?= htmlspecialchars($item->unit); ?></p>
                                                <p class="card-text"> <img class="zoekertje" src="/images/icon/kg-green.svg" alt="">
                                                    <?= htmlspecialchars($item->price); ?> <?= htmlspecialchars($item->currency); ?></p>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </ul>

<?php } ?>


            <script>
                document.querySelectorAll('.others').forEach(item => { item.addEventListener('click', function () {

                    window.location.href = `/php/items/detailItem.php?data-id=${this.getAttribute('data-id')}`
                })})
            </script>
            <script src="/js/jquery.min.js"></script>

<?php include_once("php/includes/footer.php");?>

</body>

</html>