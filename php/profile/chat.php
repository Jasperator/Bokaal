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

if (!empty($_POST['chat_id'])) {
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
        
    <div>
        <h2 class="hoofdtitel">Berichten</h2>
    </div>

    <?php include_once("../includes/subNav.php");?>
        <ul id="all-chats" class="row col-md-12">

    <?php
    foreach($getPartnerConversations as $getPartnerConversation):
        $getPartnerName = $conversation->getUserByConversationId($user->getId(), $getPartnerConversation);
        $unreadMessages = $conversation->countUnreadMessages($user, $getPartnerName->id);

    ?>

            <div class="chatPreview col-md-2">

                <img src="/uploads/<?= htmlspecialchars($getPartnerName->profile_img); ?>" alt="Chat placeholder" class="chatImg">

                <form action="../profile/chat.php" method="POST" class="chat">
                        <input type="hidden" name="chat_id" value="<?= htmlspecialchars($getPartnerConversation);?>" placeholder="naam" />
                        <input id="chatnaam"  class="btn" type="submit" name="chat_name" value="<?= htmlspecialchars($getPartnerName->fullname); ?>" />
                </form>

                <div class="notification"> <?php if($unreadMessages> 0){ print_r($unreadMessages);} ?> </div>

            </div>
        <?php endforeach ?>
        </ul>



        <?php include_once("../includes/footer.php");?>


    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
    

</body>

</html>