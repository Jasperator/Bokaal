<?php

include_once(__DIR__ . "/bootstrap.include.php");
include_once(__DIR__ . "/../../classes/Conversation.php");
include_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Message.php");



//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>


<nav >
    

    <!-- If there's no active session, show the login/signup links -->
    <?php if (!empty($_SESSION['user'])) :
        $user = new classes\User($_SESSION['user']);
        $conversation = new classes\Conversation();

    $AllunreadMessages = $conversation->countAllUnreadMessages($user);

    ?>
    
        <ul class="alles" >

        <!-- Mark a link as "active" according to the current page -->

        <li class="listItem">
            <a  href="/index.php" <?php if ($page == "index.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/home.png" alt="home icon">HOME</a>
        </li>

        <li class="listItem" >
            <a href="/php/items/search.php" <?php if ($page == "search.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/zoek.png" alt="zoek icon">ZOEKEN</a>
        </li>
        <?php if($_SESSION['user_status'] == "seller") : ?> 

            <li class="listItem" >
                <a href="/php/items/sell.php" <?php if ($page == "sell.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/add.png" alt="verkoop icon">VERKOOP</a>
            </li>

        <?php endif;?>
        <li class="listItem" >
            <a  href="/php/items/cart.php" <?php if ($page == "cart.php") : echo "active"; ?> class="navActive" <?php endif; ?>> <img class="nav-img" src="/images/icon/cart.png" alt="winkelmandje icon">WINKELMANDJE</a>
        </li>

        <li class="listItem">
            <a href="/php/profile/favor.php" <?php if ($page == "favor.php") : echo "active"; ?> class="navActive" <?php endif; ?>>  <img class="nav-img" src="/images/icon/user.png" alt="profiel icon"> <?php if($AllunreadMessages> 0){  ?> <div class="navNotification"> <?php print_r($AllunreadMessages); ?>  </div> <?php } ?> PROFIEL
            </a>

        </li>




            <?php endif; ?>
    
</nav>
