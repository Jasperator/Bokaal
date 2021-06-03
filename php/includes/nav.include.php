<?php

include_once(__DIR__ . "/bootstrap.include.php");



//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>


<nav >
    

    <!-- If there's no active session, show the login/signup links -->
    <?php if (!empty($_SESSION['user'])) :
        $user = new classes\User($_SESSION['user']);
    ?>
    
        <ul class="alles" >

        <!-- Mark a link as "active" according to the current page -->

        <li class="listItem" <?php if ($page == "index.php") : echo "active";?> <?php endif; ?>>
            <a  href="/index.php"> <img class="nav-img" src="/images/icon/home.png" alt="home icon">HOME</a>
        </li>

        <li class="listItem" <?php if ($page == "search.php") : echo "active"; ?> <?php endif; ?>>
            <a href="/php/items/search.php"> <img class="nav-img" src="/images/icon/zoek.png" alt="zoek icon"> ZOEKEN </a>
        </li>

        <li class="listItem" <?php if ($page == "cart.php") : echo "active";?> <?php endif; ?>>
            <a  href="/php/items/cart.php"> <img class="nav-img" src="/images/icon/cart.png" alt="winkelmandje icon"> WINKELMANDJE</a>
        </li>

        <li class="listItem" <?php if ($page == "profile.php") : echo "active";?> <?php endif; ?>>
            <a href="/php/profile/favor.php"> <img class="nav-img" src="/images/icon/user.png" alt="profiel icon"> PROFIEL </a>
        </li>

        <?php if($_SESSION['user_status'] == "seller") : ?> 

            <li class="listItem" <?php if ($page == "sell.php") : echo "active";?> <?php endif; ?>>
                <a id="sellNav" href="/php/items/sell.php"> <img class="nav-img" src="/images/icon/add.png" alt="verkoop icon">VERKOOP</a>
            </li>

        <?php endif;?>

    <?php endif; ?>
    
</nav>
