<?php


include_once(__DIR__ . "/bootstrap.include.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite($_SESSION['user']);



$favorites = $favorite->getAllFavorites($user);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=images/Logo/favicon.png>
    <title>Favorieten</title>
</head>
<body>
<?php include_once("nav.include.php") ?>
    
<?php include_once("nav.include.php");
?>
    <div class="container">
        <div class="jumbotron">
            <h1>Favorieten</h1>
        </div>

        <ul>
            <?php foreach ($favorites as $fav) : ?>
                <li class="list-group-item">
                    <div class="col-md-12">
                        <div class="d-flex flex-row">
                            <div class="p-0 w-25">
                            <form  action="" method="post">
                                <img src="./uploads/<?= htmlspecialchars($fav->profile_img); ?>" class="img-thumbnail border-0" />
                            </div>
                            <div class="pl-3 pt-2 pr-2 pb-2 w-75">
                                <h5 class="text-primary"><?= htmlspecialchars($fav->fullname); ?></h5>
                                <p class="text-primary"><?= htmlspecialchars($fav->email); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($fav->location); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($fav->company);  ?></p>
                            

                    </div>
                    <?php endforeach ?>
                    </div>
                </li>
        </ul>
    </div>




  	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>  
</body>
</html>