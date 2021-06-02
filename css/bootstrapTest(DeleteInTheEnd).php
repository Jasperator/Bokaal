<nav id="navbar-full" class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!--hieronder is de originele navbar voor als ik upfuck-->
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
