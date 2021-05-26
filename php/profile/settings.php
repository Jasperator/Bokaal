<?php
include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");

$page = basename($_SERVER['PHP_SELF']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="../../css/style.css">

    <title>settings option</title>
</head>

<body id="settings-body">
<?php include_once("../includes/nav.include.php");?>


<div>
            <h2 class="hoofdtitel">Settings</h2>
        </div>

        <?php include_once("../profile/profile.php");?>
<!-- Hier moet de profile.php nav komen -->

    <div class="all_item_profile">
        <?php
        if($_SESSION['user_status'] == "seller") : ?>
            <div class="item_profile">
                <a class="instel" href="../profile/settings_items.php">Mijn Items</a>
            </div>
        <?php
        endif;?>

        <div class="item_profile">
            <a class="instel" href="../profile/settings_account.php">Account instellingen</a>
        </div>
        <div class="item_profile">
            <a class="instel" href="../profile/meldingen.php">Meldingen</a>
        </div>
        <div class="item_profile"> 
            <a class="instel" href="../profile/blocked.php">Geblokkeerd</a>
        </div>

        <div class="item_profile">
            <a class="instel" href="../auth/logout.php">Logout</a>
        </div>
    </div>
</body>

</html>