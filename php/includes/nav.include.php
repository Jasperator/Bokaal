<?php

include_once(__DIR__ . "/bootstrap.include.php");



//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>


<nav id="navbar-full" >
    <div>
        <a class="home-logo" href="/index.php">Bokaal</a>
            <span ></span>
        </button>
        <div  id="navbarText">

            <!-- If there's no active session, show the login/signup links -->
            <?php if (!empty($_SESSION['user'])) :
                $user = new classes\User($_SESSION['user']);
            ?>
                <ul class="alles" >

                    <!-- Mark a link as "active" according to the current page -->
                    <li class="listItem" <?php if ($page == "search.php") : echo "active"; ?> class="active"<?php
                                        endif; ?>>
                        <a class="nav-link" href="/php/items/search.php"> <img class="nav-img" src="/images/icon/zoek.png" alt="zoek icon"> <p class="nav-bar_name">Items</p> </a>
                    </li>
                    <li class="listItem" <?php if ($page == "index.php") : echo "active";?> class="active"<?php
                                        endif; ?>>
                        <a class="nav-link"  href="/index.php"> <img class="nav-img" src="/images/icon/home.png" alt="zoek icon"><p class="nav-bar_name">Home</p></a>
                    </li>
                    <?php 
                           if($_SESSION['user_status'] == "seller") : ?> 
                     <li class="listItem" <?php if ($page == "sell.php") : echo "active";?> class="active"<?php
                                        endif; ?>>
                        <a class="nav-link"  href="/php/items/sell.php"> <img class="nav-img" src="/images/icon/add.png" alt="zoek icon"><p class="nav-bar_name">Verkoop</p></a>
                    </li>
                     <?php
                        endif;?>

                    <li class="listItem" <?php if ($page == "cart.php") : echo "active";?> class="active"<?php
                                        endif; ?>>
                        <a class="nav-link"  href="/php/items/cart.php"> <img class="nav-img" src="/images/icon/cart.png" alt="zoek icon"> <p class="nav-bar_name">Winkelkar</p></a>
                    </li>
                    <li class="listItem" <?php if ($page == "profile.php") : echo "active";?> class="active"<?php
                                        endif; ?>>
                        <a class="nav-link"  href="/php/profile/favor.php"><i class="fas fa-user"></i> <img class="nav-img" src="/images/icon/user.png" alt="zoek icon"> <p class="nav-bar_name">Profiel</p> </a>
                    </li>

            <?php endif; ?>
        </div>
    </div>
</nav>
