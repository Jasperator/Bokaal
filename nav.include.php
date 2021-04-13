<?php

include_once(__DIR__ . "/bootstrap.include.php");



//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>
<style>
<?php include 'css/navbar.css'; ?>
</style>

<nav >
    <div id="container" class="container">
        <a class="home-logo" href="index.php">Bokaal</a>
        <button type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span ></span>
        </button>
        <div  id="navbarText">

            <!-- If there's no active session, show the login/signup links -->
            <?php if (!empty($_SESSION['user'])) :
                $user = new classes\User($_SESSION['user']);
            ?>
                <ul >

                    <!-- Mark a link as "active" according to the current page -->
                    <li  <?php if ($page == "search.php") : echo "active";
                                        endif; ?>>
                        <a  href="search.php"> <img src="images/icon/zoek.png" alt="zoek icon"> <p>Zoek</p> </a>
                    </li>
                    <li <?php if ($page == "index.php") : echo "active";
                                        endif; ?>>
                        <a href="index.php"> <img src="images/icon/home.png" alt="zoek icon"> <p>Home</p> </a>
                    </li>
                    <?php 
                           if($_SESSION['user_status'] == "seller") : ?> 
                     <li <?php if ($page == "sell.php") : echo "active";
                                        endif; ?>>
                        <a href="sell.php"> <img src="images/icon/add.png" alt="zoek icon"> <p> Sell your stuff</p></a>
                    </li>
                     <?php
                        endif;?>

                    <li <?php if ($page == "cart.php") : echo "active";
                                        endif; ?>>
                        <a href="cart.php"> <img src="images/icon/cart.png" alt="zoek icon"> <p>cart</p> </a>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fas fa-user"></i> <img src="images/icon/user.png" alt="zoek icon"> <p>Profile</p> </a>
                    </li>

            <?php endif; ?>
        </div>
    </div>
</nav>
