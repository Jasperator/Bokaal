<?php

include_once(__DIR__ . "/bootstrap.include.php");

//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Bokaal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">

            <!-- If there's no active session, show the login/signup links -->
            <?php if (!empty($_SESSION['user'])) :
                $user = new classes\User($_SESSION['user']);
            ?>
                <ul class="navbar-nav mr-auto">

                    <!-- Mark a link as "active" according to the current page -->
                    <li class="nav-item <?php if ($page == "index.php") : echo "active";
                                        endif; ?>">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php 
                           if($_SESSION['user_status'] == "seller") : ?> 
                     <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sell your stuf</a>
                    </li>
                     <?php
                        endif;?>

                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fas fa-user"></i>&nbsp&nbsp<?php echo htmlspecialchars($user->getFullname()); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log out</a>
                    </li>
  
                </ul>


            <?php else : ?>

                <!-- If there's an active session, make a new user and show the site navigation -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == "login.php") : echo "active";
                                            endif; ?>" href="login.php">
                            <i class="fas fa-user"></i> Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == "register.php") : echo "active";
                                            endif; ?>" href="register.php">
                            <i class="fas fa-user-plus"></i> Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == "register-seller.php") : echo "active";
                                            endif; ?>" href="register-seller.php">
                            <i class="fas fa-user-plus"></i> Sign up as seller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page == "register-buyer.php") : echo "active";
                                            endif; ?>" href="register-buyer.php">
                            <i class="fas fa-user-plus"></i> Sign up as buyer</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
