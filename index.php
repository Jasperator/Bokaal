<?php


include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/Favorite.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Distance.php");

$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite();
$distanceClass = new classes\Distance();




$favorites = $favorite->getAllFavorites($user);
$pageAndUsers = $user->getSellersExceptUser();
$page = $pageAndUsers[0];
$totalPages = $user->countPages();
$sellers = $pageAndUsers[1];





if (!empty($_POST['favorite-person'])) {
    $favorite_id = $_POST['favorite-person'];
    
    $favorite->insertFavorite($user,$favorite_id);


    }

if (!empty($_POST['delete-favorite-person'])) {
    $favorite_id = $_POST['delete-favorite-person'];

    $favorite->deleteFavorite($user,$favorite_id);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/svg" href=images/logo/favicon.png> <title>Bokaal | Home</title>
</head>

<body id="index-body">
    <?php include_once("php/includes/nav.include.php");?>
    <div>


        <div>
            <h2 class="hoofdtitel">Bokaal</h2>
        </div>
        <?php
        $page = $pageAndUsers[0];
        if($page == 1){
            ?>
        <h3 class="titel-index">FAVORIETEN</h3>
        <ul id="all-detail" class="row col-md-12"  >

            <?php
            foreach ($favorites as $fav) : ?>
                <div id="list-decoration" class="col-md-4">
                    <div class="itemId users" data-id="<?= htmlspecialchars($fav->id); ?>">
                        <div class="container" >
                            <div class="card h-100 breed" >
                                <form action="" method="post">
                                    <img class="card-img-top" src="./uploads/<?= htmlspecialchars($fav->profile_img); ?>"
                                        class="img-thumbnail border-0" />

                                    <div id="card-body" style="padding:15px;">
                                        <h5 class="card-title"><?= htmlspecialchars($fav->fullname); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($fav->location); ?></p>
                                        <p class="card-text"><?= htmlspecialchars($fav->company);  ?></p>
                                        <p class="card-text"><small class="text-muted"> <img class="zoekertje" src="../../images/icon/place-green.png" alt="icon place">
                                                <?= htmlspecialchars($fav->distance);  ?></small>
                                        </p>

                                        <form  action="" method="post">
                                        
                                            <button id="knop1" type="submit" class="fav-delete" name="delete-favorite-person"
                                                value="<?= htmlspecialchars($fav->id); ?>">
                                                <i class="fa fa-star fa-2x" aria-hidden="true" id="favor-img"></i>
                                            </button>
                                        
                                        </form>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
                            
        </ul>

        <?php } ?>

        <div class="space-favor"></div>
        <h3 class="titel-index"> VERKOPERS</h3>

        <ul id="all-detail" class="row col-md-12">
            <!--<div id="pauze"></div>-->

            <?php foreach ($sellers as $seller) : ?>
            <div id="list-decoration" class="col-md-4">
                <div class="itemId users" data-id="<?= htmlspecialchars($seller->id); ?>">
                    <div class="container">
                        <div class="card h-100 breed" >
                            <form action="" method="post">
                                <img class="card-img-top" src="./uploads/<?= htmlspecialchars($seller->profile_img); ?>"
                                    class="img-thumbnail border-0" />

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($seller->fullname); ?></h5>
                                    <p class="card-text p-0"><?= htmlspecialchars($seller->location); ?></p>
                                    <p class="card-text p-0"><?= htmlspecialchars($seller->company);  ?></p>
                                    <p class="card-text p-0"><small class="text-muted"><img class="zoekertje" src="../../images/icon/place-green.png" alt="icon place">
                                            <?= htmlspecialchars($seller->distance);  ?></small>
                                    </p>
                                    <form  action="" method="post">
                                        
                                            <button id="knop2" type="submit" class="fav" name="favorite-person"
                                                value="<?= htmlspecialchars($seller->id); ?>" name="fav">
                                                <i class="fa fa-star fa-2x" aria-hidden="true" id="favor-img"></i>
                                            </button>
                                        
                                    </form>


                                </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php endforeach ?>
        </ul>


        <div id="space"></div>


<div id="pages" style="text-align: center">
<?php for ($i=1; $i<=$totalPages; $i++) {  // print links for all pages
    echo "<a href='index.php?page=".$i."'";
    if ($i==$page)  echo " class='curPage'";
    echo ">".$i."</a> ";

};
?>
</div>

        <script>
            document.querySelectorAll('.users').forEach(item => {
                item.addEventListener('click', function () {

                    window.location.href = `detailsUser.php?data-id=${this.getAttribute('data-id')}`
                })
            })
        </script>


<?php include_once("php/includes/footer.php");?>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/home.js"></script>

</body>

</html>