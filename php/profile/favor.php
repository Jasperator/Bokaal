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
    <link rel="stylesheet" href="../../css/style.css">


    <title>Favorieten</title>
</head>

<body id="favor-body">
    <?php include_once("../includes/nav.include.php") ?>
    <?php include_once("../profile/profile.php");?>


    <div>
        <div>
            <h2 class="hoofdtitel">Favorieten</h2>
        </div>

        <ul id="all">
            <?php foreach ($favorites as $fav) : ?>
            <li id="list">
                <div class="container users" data-id = "<?= htmlspecialchars($fav->id); ?>"">
                    <div >
                        <div id="foto">
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="/uploads/<?= htmlspecialchars($fav->profile_img); ?>"/>
                                            
                                </div>
                            </div>
                        </div>
                        
                        <div id="info">
                            <h5 class="text-primary"><?= htmlspecialchars($fav->fullname); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($fav->location); ?></p>
                            <p class="text-primary"><?= htmlspecialchars($fav->company);  ?></p>

                            <form id="favor" action="" method="post">

                                <div class="form-group">
                                    <button type="submit" name="delete-favorite-person" class="fav"
                                        value="<?= htmlspecialchars($fav->id); ?>" name="fav"
                                        placeholder="Favoriet">Verwijder favoriet</button>
                                </div>
                            </form>


                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>
    </div>

<div id="space" ></div>


    <script>
        document.querySelectorAll('.users').forEach(item => { item.addEventListener('click', function () {

            window.location.href = `/detailsUser.php?data-id=${this.getAttribute('data-id')}`
        })})
    </script>
    <script src="../../js/jquery.min.js"></script>
</body>

</html>