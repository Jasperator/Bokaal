<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">


    <title>Meldingen</title>
</head>
<body>
    <?php include_once("../includes/nav.include.php");?>
   
    <!-- Hier moet de profile.php nav komen -->
   <div class="locationRadio">

    <p id="locationAccept">Locatie toestaan:</p>

    <div class="radioButton">
    <input type="radio" class="locationOption" id="always" name="location" value="always">
    <label for="always">Altijd</label><br>
    </div>


    <input type="radio" class="locationOption" id="onlyUse" name="location" value="onlyUse">
    <label for="onlyUse">Bij gebruik van Bokaal</label><br>
    <input type="radio" class="locationOption" id="never" name="location" value="never">
    <label for="never">Nooit</label>

  </div>



<?php include_once("../includes/footer.php");?>


</body>
</html>