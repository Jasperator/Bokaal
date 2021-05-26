<?php


include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/Favorite.php");
require_once(__DIR__ . "/classes/User.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite();



$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();

foreach ($favorites as $favor) {
    $favor->distance =$user->getDistance($user->getAddress(), $user->getPostal_code(), urlencode($favor->address), urlencode($favor->postal_code), "K");
}

foreach ($sellers as $sell) {
    $sell->distance =$user->getDistance($user->getAddress(), $user->getPostal_code(), urlencode($sell->address), urlencode($sell->postal_code), "K");
}

usort($favorites, function($a, $b)
{
    return strcmp($a->distance, $b->distance);
});

usort($sellers, function($a, $b)
{
    return strcmp($a->distance, $b->distance);
});

if (!empty($_POST['favorite-person'])) {
    $favorite_id = $_POST['favorite-person'];
    
    $favorite->insertFavorite($user,$favorite_id);
    
$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();
    foreach ($favorites as $favor) {
        $favor->distance =$user->getDistance($user->getAddress(), $user->getPostal_code(), urlencode($favor->address), urlencode($favor->postal_code), "K");
    }

    foreach ($sellers as $sell) {
        $sell->distance =$user->getDistance($user->getAddress(), $user->getPostal_code(), urlencode($sell->address), urlencode($sell->postal_code), "K");
    }
    usort($favorites, function($a, $b)
    {
        return strcmp($a->distance, $b->distance);
    });

    usort($sellers, function($a, $b)
    {
        return strcmp($a->distance, $b->distance);
    });


    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/svg" href=images/logo/favicon.png> <title>Bokaal | Home</title>
</head>

<body id="index-body">
    <?php include_once("php/includes/nav.include.php");?>
    <div>

    
        <div >
            <h2 class="hoofdtitel">Home</h2>
        </div>
        <h3 class="titel-index">Favorieten</h3>
        <ul id="all">
            <?php
            foreach ($favorites as $fav) : ?>
            <li id="list">
                <div class="itemId" data-id = "<?= htmlspecialchars($fav->id); ?>">
                    <div>
                        <div >
                            <div >
                                <div class="card" style="width: 18rem;">
                                    <form action="" method="post">
                                        <img class="card-img-top" src="./uploads/<?= htmlspecialchars($fav->profile_img); ?>" />
                                </div>
                            </div>
                        </div>

                        <div id="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($fav->fullname); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($fav->location); ?></p>
                            <p class="card-text"><?= htmlspecialchars($fav->company);  ?></p>
                            <p class="card-text"> Afstand:
                                <?= htmlspecialchars($fav->distance);  ?>
                            </p>

                            

                            
                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>
        <div class="space-favor"></div>
          <h3 class="titel-index"> Verkopers</h3>

        <ul id="all-detail">
            <!--<div id="pauze"></div>-->
          
            <?php foreach ($sellers as $seller) : ?>
            <li id="list-decoration">

                <div class="itemId" data-id = "<?= htmlspecialchars($seller->id); ?>">
                    <div  class="container">
                        <div class="row row-cols-1 row-cols-md-3">
                            <div class="col mb-4">
                                <div class="card h-100" style="width: 18rem;">
                                    <form action="" method="post">
                                        <img  class="card-img-top" src="./uploads/<?= htmlspecialchars($seller->profile_img); ?>"
                                            class="img-thumbnail border-0" />
                              

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($seller->fullname); ?></h5>
                            <p class="card-title"><?= htmlspecialchars($seller->location); ?></p>
                            <p class="card-title"><?= htmlspecialchars($seller->company);  ?></p>
                            <p class="card-title"><small class="text-muted">Afstand:
                                <?= htmlspecialchars($seller->distance);  ?></small> 
                            </p>


                            <form id="favor" action="" method="post">

                                <div class="fav-but" class="form-group">
                                    <button id="knop" type="submit" name="favorite-person" class="fav"
                                        value="<?= htmlspecialchars($seller->id); ?>" name="fav"> <img class="favor-img"
                                            src="images\icon\star.png" alt=""></button>
                                </div>
                            </form>


                        </div>
                        </div>
                            </div>
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