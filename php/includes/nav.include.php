<?php

include_once(__DIR__ . "/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");
require_once(__DIR__ . "/../../classes/Item.php");




//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>


<nav class="navbar-volledig" >
    

    <!-- If there's no active session, show the login/signup links -->
    <?php if (!empty($_SESSION['user'])) :
        $user = new classes\User($_SESSION['user']);
        $conversation = new classes\Conversation();
    $itemClass = new classes\Item();


    $AllunreadMessages = $conversation->countAllUnreadMessages($user);
    $allItemsCart = $itemClass->countAllItems($user);


    ?>
    
        <ul class="alles" <?php if($user->getStatus() == 'buyer') { ?> style="margin-left: 60%;width: 40%" <?php }?>>

        <!-- Mark a link as "active" according to the current page -->

        <li class="listItem mobNav">
            <a  href="/index.php" <?php if ($page == "index.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/home.png" alt="home icon">HOME</a>
        </li>

        <li class="listItem mobNav" >
            <a href="/php/items/search.php" <?php if ($page == "search.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/zoek.png" alt="zoek icon">ZOEKEN</a>
        </li>
        <?php if($_SESSION['user_status'] == "seller") : ?> 

            <li class="listItem mobNav" >
                <a href="/php/items/sell.php" <?php if ($page == "sell.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/add.png" alt="verkoop icon">VERKOOP</a>
            </li>

        <?php endif;?>
        <li class="listItem" >
            <a  href="/php/items/cart.php" <?php if ($page == "cart.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/cart.png" alt="winkelmandje icon">  <?php if ($page != "cart.php") {
                    if($allItemsCart> 0){  ?> <div class="navNotification"><?php print_r($allItemsCart); ?></div>
                    <?php } }?>WINKELMANDJE</a>
        </li>

        <li class="listItem mobNav">
            <a href="/php/profile/favor.php" <?php if ($page == "favor.php") : echo "active"; ?> class="navActive" <?php endif; ?>>  <img class="nav-img" src="/images/icon/user.png" alt="profiel icon">
                <?php if ($page != "favor.php" and $page != "chat.php" and $page != "bought.php" and $page != "settings.php" and $page != "settings_account.php" and $page != "meldingen.php") {
                   if($AllunreadMessages> 0){  ?> <div class="navNotification"><?php print_r($AllunreadMessages); ?></div>
                        <?php } }?> PROFIEL
            </a>

        </li>




            <?php endif; ?>
    
</nav>
