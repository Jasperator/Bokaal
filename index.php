<?php


include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/Favorite.php");
require_once(__DIR__ . "/classes/User.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite();



$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();



// $addressFrom = 'Adolf Mortelmansstraat 74';
// $addressTo   = 'Dascoottelei 890';



// // Get distance in km
// $distance = getDistance($addressFrom, $addressTo, "K");


if (!empty($_POST['favorite-person'])) {
    $favorite_id = $_POST['favorite-person'];
    
    $favorite->insertFavorite($user,$favorite_id);
    
$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/bootstrap.css">-->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/svg" href=images/logo/favicon.png> <title>Bokaal | Home</title>
</head>

<body id="index-body">
    <?php include_once("php/includes/nav.include.php");?>
    <div>

    
        <div >
            <h2 class="hoofdtitel">Home</h2>
        </div>

        <ul id="all">
            <h3 class="titel-index">Favorieten</h3>
            <?php foreach ($favorites as $fav) : ?>
            <li id="list">
                <div class="container">
                    <div>
                        <div id="foto">
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="./uploads/<?= htmlspecialchars($fav->profile_img); ?>" />
                                </div>
                            </div>
                        </div>

                        <div id="info">
                            <h5 class="text-primary"><?= htmlspecialchars($fav->fullname); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($fav->location); ?></p>
                            <p class="text-primary"><?= htmlspecialchars($fav->company);  ?></p>
                            <p class="text-primary"> Afstand:
                                <?= $user->getDistance($user->getAddress(),$user->getPostal_code(), urlencode($fav->address), urlencode($fav->postal_code), "K");  ?>
                            </p>

                            

                            
                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>
        <div class="space-favor"></div>
        
        <ul id="all-buurt">
            <div id="pauze"></div>
            <h3 class="titel-index"> Verkopers</h3>
            <?php foreach ($sellers as $seller) : ?>
            <li id="list">
                <div class="container users" data-id = "<?= htmlspecialchars($seller->id); ?>">
                    <div>
                        <div id="foto">
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="./uploads/<?= htmlspecialchars($seller->profile_img); ?>"
                                            class="img-thumbnail border-0" />
                                </div>
                            </div>
                        </div>

                        <div id="info">
                            <h5 class="text-primary"><?= htmlspecialchars($seller->fullname); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($seller->location); ?></p>
                            <p class="text-primary"><?= htmlspecialchars($seller->company);  ?></p>
                            <p class="text-primary"> Afstand:
                                <?= $user->getDistance($user->getAddress(),$user->getPostal_code(), htmlspecialchars($seller->address), htmlspecialchars($seller->postal_code), "K");  ?>
                            </p>


                            <form id="favor" action="" method="post">

                                <div class="fav-but" class="form-group">
                                    <button id="knop" type="submit" name="favorite-person" class="fav"
                                        value="<?= htmlspecialchars($seller->id); ?>" name="fav"> <img class="favor-img"
                                            src="images\icon\star.png" alt=""></button>
                                </div>
                            </form>


                        </div>

                        

                        <?php endforeach ?>
                    </div>
            </li>
        </ul>

    </div>
    <div id="space"></div>



    <script>
        document.querySelectorAll('.users').forEach(item => { item.addEventListener('click', function () {

            window.location.href = `detailsUser.php?data-id=${this.getAttribute('data-id')}`
        })})
    </script>



    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>