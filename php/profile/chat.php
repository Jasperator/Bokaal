<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");




$user = new classes\User($_SESSION['user']);
$conversation = new classes\Conversation();

$active_conversations = $user->getConversations();
$getPartnerConversations = $user->getPartnerConversations();

$partners = [];
foreach($getPartnerConversations as $getPartnerConversation){
$getPartnerName = $conversation->getUserByConversationId($user->getId(), $getPartnerConversation);
$unreadMessages = $conversation->countUnreadMessages($user, $getPartnerName->id);
    $getPartnerName->unreadMes = $unreadMessages;
    array_push($partners, $getPartnerName);

}

function cmp($a, $b) {
    return strcmp($b->unreadMes, $a->unreadMes);
}

usort($partners, "cmp");
function message() {
    session_status();
    $_SESSION['chat_id'] = $_POST['chat_id'];
    header('Location: message.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/reaction.css" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>


    <title>Bokaal | Chat</title>
</head>

<body>
        <?php include_once("../includes/nav.include.php"); ?>
        
        <h2 class="hoofdtitel">Berichten</h2>

    <?php include_once("../includes/subNav.php");?>


        <?php if(count($getPartnerConversations) <= 0){ ?>


    <img class="Placeholder" src="../../images/chatPlaceholder.png" alt="cart placeholder">
        <?php } else { ?>


        <ul id="all-chats" class="row col-md-12">

    <?php
    foreach($partners as $partner):
        $getPartnerConvo = $user->getPartnerConvo($partner->id);


        ?>


                <div id="chats list-decoration-search" class="col-md-4">
                        <div id="container-search" class="container">
                            <div class="card h-100 breed">

                <?php if($partner->unreadMes> 0){  ?> <div class="notification"> <?php print_r($partner->unreadMes); ?>  </div> <?php } ?>


                <img src="/uploads/<?= htmlspecialchars($partner->profile_img); ?>" alt="Chat placeholder" class="card-img-top img-thumbnail border-0">

                <form action="" method="POST" class="chat">
                        <input type="hidden" name="chat_id" class="convoId" value="<?= htmlspecialchars($getPartnerConvo);?>" placeholder="naam" />
                        <p id="chatName"><?= htmlspecialchars($partner->fullname); ?> </p>
                </form>


                <div id="space-chat"></div>
            </div>
                        </div></div>
        <?php endforeach ?>
        </ul>
        <?php } ?>


        <?php include_once("../includes/footer.php");?>


    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>

        <script>
            document.querySelectorAll('.chats').forEach(item => {
                item.addEventListener('click', function () {

                    // this.getElementsByClassName('convoId').item(0)
                    window.location.href = `message.php?chat_id=${this.getElementsByClassName('convoId').item(0).value}`;

                })})
        </script>
    
    
</body>

</html>