<?php

include_once(__DIR__ . "/bootstrap.include.php");
$user = new classes\User($_SESSION['user']);
$item = new classes\Item($_SESSION['user']);

if($user->getStatus() == "seller"){
$items = $item->getAllItemsExceptSeller($user);

} else{
    $items = $item->getAllItems();
}

if (!empty($_POST['buy-item'])) {
$id = $_POST['buy-item'];

$item->buyItem($user,$id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" type="image/svg" href=images/Logo/LogoWhite.svg>

    <title>Home</title>
</head>
<body>
<?php include_once("nav.include.php");
?>
    <div class="container">
        <div class="jumbotron">
            <h1>Items</h1>
            <p>Buy your items</p>
        </div>

        <ul>
            <?php foreach ($items as $item) : ?>
                <li class="list-group-item">
                    <div class="col-md-12">
                        <div class="d-flex flex-row">
                            <div class="p-0 w-25">
                            <form  action="" method="post">
                                <img src="./uploads/<?= htmlspecialchars($item->item_image); ?>" class="img-thumbnail border-0" />
                            </div>
                            <div class="pl-3 pt-2 pr-2 pb-2 w-75">
                                <h5 class="text-primary"><?= htmlspecialchars($item->title); ?></h5>
                                <p class="text-primary"><?= htmlspecialchars($item->description); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->quantity); ?> :  <?= htmlspecialchars($item->unit); ?></p>
                                <p class="text-primary"><?= htmlspecialchars($item->price); ?> :  <?= htmlspecialchars($item->currency); ?></p>
                                
			<form  action="" method="post">

				<div class="form-group">
					<button type="submit" name="buy-item" class="buy" value="<?= htmlspecialchars($item->id); ?>" name="buy" placeholder="Koop">Koop</button>
				</div>
			</form>

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