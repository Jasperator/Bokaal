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
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">


    <title>settings option</title>
</head>

<body id="settings-body">
<?php include_once("../includes/nav.include.php");?>



            <h2 id="hoofdtitel" class="hoofdtitel">Settings</h2>


        <?php include_once("../includes/subNav.php");?>
    <!-- Hier moet de profile.php nav komen -->

    <div class="all_item_profile">
        <?php
        if($_SESSION['user_status'] == "seller") : ?>

            <div class="item_profile">
                <button onclick="window.location.href='../profile/settings_items.php'" type="button" 
                class="settingsButton">Mijn items</button>
            </div>
        <?php
        endif;?>

        

        <div class="item_profile">
            <button onclick="window.location.href='../profile/settings_account.php'" type="button" 
            class="settingsButton">Account instellingen</button>
        </div>

        <div class="item_profile">
            <button onclick="window.location.href='../profile/privacy.php'" type="button" 
            class="settingsButton">Machtigingen</button>
        </div>

        <div class="item_profile">
        <button onclick="window.location.href='../auth/logout.php'" type="button" 
            class="settingsButton">Log out</button>
        </div>

        <div class="item_profile" id="delete_account">
        <button type="button" class="delete_account">
            <a>Verwijder account</a>
            </button>
        </div>

        <div id="delete_acc_modal" class="modal">      
            <div class="modalContent">
                <span class="close">&times;</span>
                <h4>Ben je zeker dat je jouw account wilt verwijderen?</h4>
                <form method="get" action="../profile/delete_account.php">
                    <button class="deleteButton" type="submit">Verwijder account</button>
                </form>
            </div>
        </div>
        
    </div>

<script>
    // Get the modal
    var modal = document.getElementById("delete_acc_modal");

    // Get the button that opens the modal
    var btn = document.getElementById("delete_account");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php include_once("../includes/footer.php");?>

</body>

</html>