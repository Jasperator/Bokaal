<?php


include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/Favorite.php");
require_once(__DIR__ . "/../../classes/User.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite();



$favorites = $favorite->getAllFavorites($user);

if (!empty($_POST['delete-favorite-person'])) {
    $favorite_id = $_POST['delete-favorite-person'];
    
    $favorite->deleteFavorite($user,$favorite_id);
    $favorites = $favorite->getAllFavorites($user);

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png> 
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">


    <title>Bokaal | Favorieten</title>
</head>

<body>
    <?php include_once("../includes/nav.include.php") ?>


        
            <h2 class="hoofdtitel">Favorieten</h2>



        <?php include_once("../includes/subNav.php");?>

        <?php if(count($favorites) <= 0){ ?>


<img class="Placeholder" src="../../images/favoritePlaceholder.png" alt="cart placeholder">
<?php } else { ?>

        <ul id="all-detail" class="row col-md-12">

            <?php foreach ($favorites as $fav) : ?>
            <div id="list-decoration" class="col-md-4">
                <div class="itemId" data-id="<?= htmlspecialchars($fav->id); ?>">
                    <div class="container favorieten-afstand">
                        <div class="card h-100 breed" >
                            <form action="" method="post">
                                <img class="card-img-top" src="/uploads/<?= htmlspecialchars($fav->profile_img); ?>"
                                    class="img-thumbnail border-0" />


                                <div id="card-body" style="padding:15px;">
                                    <h5 class="card-title"><?= htmlspecialchars($fav->fullname); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($fav->company);  ?></p>
                                    <p class="card-text"><?= htmlspecialchars($fav->location); ?></p>
                                    <p class="card-text"><small class="text-muted"> <img class="zoekertje" src="../../images/icon/place-green.png" alt="icon place">
                                                <?= htmlspecialchars($fav->distance);  ?></small>
                                    </p>
                                    <button id="knop1" type="submit" class="fav-delete" name="delete-favorite-person"
                                                value="<?= htmlspecialchars($fav->id); ?>">
                                                <i class="fa fa-star fa-2x" aria-hidden="true" id="favor-img"></i>
                                    </button>
                                </div>

                                
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </ul>   
        
        <?php } ?>

   


    <div id="space"></div>


    <?php include_once("../includes/footer.php");?>

    <script>
        document.querySelectorAll('.itemId').forEach(item => {
            item.addEventListener('click', function () {

                window.location.href = `/detailsUser.php?data-id=${this.getAttribute('data-id')}`
            })
        })
    </script>
    <script src="../../js/jquery.min.js"></script>


</body>

</html>