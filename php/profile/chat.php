<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");




$user = new classes\User($_SESSION['user']);

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
    <link rel="stylesheet" href="../../css/chat.css">
    <link rel="stylesheet" href="../../css/reaction.css" />
    <link rel="stylesheet" href="/css/style.css">


    <title>Chat</title>
</head>

<body>
    <?php include_once("../includes/nav.include.php"); ?>
    <?php include_once("profile.php");?>

    <form action="" method="POST" class="chat">
        <?php
        foreach($getPartnerConversations as $getPartnerConversation){

            ?>
            <input type="submit" name="chat_id" value="<?= htmlspecialchars($getPartnerConversation); ?>" />
            <?php

        }
?>

    </form>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>

</html>