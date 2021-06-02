<?php
include_once(__DIR__ . "/../includes/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");
require_once(__DIR__ . "/../../classes/Item.php");
require_once(__DIR__ . "/../../classes/Favorite.php");



$user = new classes\User($_SESSION['user']);
$item = new classes\Item();
$conversations = new classes\Conversation();
$messages = new classes\Message();
$favorites = new classes\Favorite();



$userId = $user->getId();
$item->deleteAllOwnItem($user);
$item->deleteAllItemCart($user);
$conversations->deleteConversations($user);
$messages->deleteOwnMessages($user);
$favorites->deleteOwnFavorites($user);
$user->deleteUser();

//Remove session variables
unset($_SESSION["user"]);

//Destroy session
session_destroy();

//Redirect to homepage
header("Location: /index.php");
