<?php
include_once(__DIR__ . "/../includes/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");

$user = new classes\User($_SESSION['user']);
if(isset($_GET['chat_id'])){
    $_SESSION['chat_id'] = $_GET['chat_id'];
    $active_conversation =  $_SESSION['chat_id'];

}else {
    $active_conversation = $_SESSION['chat_id'];

}

 if ($active_conversation) {
     $conversation = new classes\Conversation();
     $conversation->setId($active_conversation);
     $conversation->readMessages($user->getId());
     $messages = $conversation->getMessages();
     $chat_partner = $conversation->getPartner($user->getId());




 if (!empty($_POST['content'])) {
     $time = date('Y-m-d H:i:s');

     if(isset($_GET['chat_id'])){
         $_SESSION['chat_id'] = $_GET['chat_id'];
         $active_conversation =$_SESSION['chat_id'];

     }else {
         $active_conversation = $_SESSION['chat_id'];

     }


     $message = new classes\Message();
     $message->setConversation_id($active_conversation);
     $message->setSender_id($user->getId());
     $message->setReceiver_id($chat_partner->id);
     $message->setContent($_POST['content']);
     $message->setTimestamp($time);
     $message->saveMessage();
 }

 if (isset($_POST['like'])) {
     if ($_POST['like'] == 1) {
         classes\Message::reaction();
     }

     if ($_POST['like'] == 0) {
         classes\Message::undoReaction();
     }
}}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/reaction.css" />
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>



    <title>Bokaal | Chat</title>
</head>

<body onload="updateScroll()">
    <?php include_once("../includes/nav.include.php");?>
<form action="" method="POST" class="chat">
<a class="backArrow" href="/php/profile/chat.php"><img src="/images/icon/back.svg" style="width: 50%;"></a>
<h2 class="hoofdtitel" id="chatNaam" data-id="<?php echo htmlspecialchars($chat_partner->id); ?>"><?php echo htmlspecialchars($chat_partner->fullname); ?></h2>
    <div class="chatbox">
        <?php if (!empty($active_conversation)) : ?>
            
            <div class="messagebox" style="min-height: 350px;">
                <?php
                if (!empty($active_conversation)) :
                    //Print out all messages
                    foreach ($messages as $message) : ?>
                        <div class="messageElement">
                            <div class="messageContent">
                                <strong <?php if ($message->sender_id == $user->getId()) {
                                    echo 'style="float:right"';
                                } else {
                                    echo 'style="float:left"';
                                } ?>> &nbsp; <?= htmlspecialchars($message->fullname) ?> &nbsp; </strong>
                                <small <?php if ($message->sender_id == $user->getId()) {
                                    echo 'style="float:right"';
                                } else {
                                    echo 'style="float:left"';
                                } ?>> <?= $message->timestamp; ?> </small>
                                <br>
                                <p <?php if ($message->sender_id == $user->getId()) {
                                    echo 'style="background-color:#d5d962; color:white; float:right; margin-bottom: -5px"';
                                } else {
                                    echo 'style="background-color:#E1E3E2; float:left; margin-bottom: -5px "';
                                } ?>>
                                    <?= htmlspecialchars($message->content) ?>
                                </p> <br><br><br>
                                <div class="container float-left" <?php if ($message->sender_id == $user->getId()) {
                                    echo 'style="visibility:hidden"';
                                } else {
                                    echo 'style="visibility:visible"';
                                } ?>>
                                    <div class="main">
                                        <!-- Reaction system start -->
                                        <div class="reaction-container">
                                            <!-- container div for reaction system -->
                                            <span class="like-emo <?= $message->id ?> ">
                                                    <!-- like emotions container -->
                                                    <?php if (!empty($message->reaction)) : ?>
                                                        <span class="like-btn-<?= strtolower($message->reaction) ?>"></span>
                                                    <?php endif; ?>
                                                </span>
                                            <span class="<?php if ($message->receiver_id == $user->getId()) {
                                                echo "reaction-btn";
                                            } else {
                                                echo "reaction-btn-locked";
                                            } ?> <?= $message->id ?>">
                                                    <!-- Default like button -->
                                                    <span class="<?php if ($message->receiver_id == $user->getId()) {
                                                        echo "reaction-btn-text";
                                                    } else {
                                                        echo "reaction-btn-text-locked";
                                                    } ?> <?= $message->id ?> <?= $message->id ?> <?php if (!empty($message->reaction)) :
                                                        echo "reaction-btn-text-" . strtolower($message->reaction);
                                                        echo " active";
                                                    endif; ?>" message-id="<?= $message->id ?>">
                                                        <?php if (!empty($message->reaction)) :
                                                            echo $message->reaction;
                                                        else :
                                                            echo "Like";
                                                        endif; ?>
                                                </span>
                                                    <ul class="emojies-box">
                                                        <!-- Reaction buttons container-->
                                                        <li class="emoji emo-like" data-reaction="Like" message-id="<?= $message->id ?>"></li>
                                                        <li class="emoji emo-love" data-reaction="Love" message-id="<?= $message->id ?>"></li>
                                                        <li class="emoji emo-haha" data-reaction="HaHa" message-id="<?= $message->id ?>"></li>
                                                        <li class="emoji emo-wow" data-reaction="Wow" message-id="<?= $message->id ?>"></li>
                                                        <li class="emoji emo-sad" data-reaction="Sad" message-id="<?= $message->id ?>"></li>
                                                        <li class="emoji emo-angry" data-reaction="Angry" message-id="<?= $message->id ?>"></li>
                                                    </ul>
                                                </span>
                                        </div>
                                        <!-- Reaction system end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div id="reply">
            <input type="text" id="messageText" class="messageText" placeholder="Type hier...">
            <button id="sendMessage" class="sendMessage">Stuur</button>
            </div>
        <?php else : ?>
            <h2 class="d-inline-block">You have no body to chat with!</h2>
            <h6>Send a request to someone or wait for someone else to ask you.</h6>
        <?php endif; ?>
    </div>
</form>


<script src="../../js/jquery.min.js"></script>
<script src="../../js/chat.js"></script>
<script src="../../js/bootstrap.js"></script>

    <script>
        document.getElementById('chatNaam').addEventListener('click',function (){
            window.location.href = `../../detailsUser.php?data-id=${this.getAttribute('data-id')}`

        })
    </script>

</body>

</html>