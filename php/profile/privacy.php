<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href=../../images/logo/favicon.png>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">


    <title>Meldingen</title>
</head>
<body class="body-privacy">
    <?php include_once("../includes/nav.include.php");?>
   
    <a class="backArrow" href="/php/profile/settings.php"><img src="/images/icon/back.svg" style="width: 50%;"></a>
<h2 class="hoofdtitel" id="privacyTitel" >Machtigingen</h2>  

<div class="locationRadio">

    <p id="locationAccept">Locatie toestaan:</p>

    <div class="radioButton">
        <input type="radio" class="locationOption" id="always" name="location" value="always">
        <label for="always">Altijd</label>
        </div>
        <div class="radioButton">
        <input type="radio" class="locationOption" id="onlyUse" name="location" value="onlyUse">
        <label for="onlyUse">Bij gebruik van Bokaal</label><br>
        </div>
        <div class="radioButton">
        <input type="radio" class="locationOption" id="never" name="location" value="never">
        <label for="never">Nooit</label>
    </div>


</div>

<div class="switchButtons">

    <label class="switchLabel">Meldingen ontvangen voor berichten
    <input class="checkbox-macht" type="checkbox">
    <span id="buttonMeldingen" class="checkmark"></span>
    </label>

    <label class="switchLabel">Straat en nummer openbaar
    <input class="checkbox-macht-onder" type="checkbox">
    <span id="buttonStraat" class="checkmark"></span>
    </label>

    <label class="switchLabel">Stad en postcode openbaar
    <input class="checkbox-macht-onder" type="checkbox">
    <span id="buttonStad" class="checkmark"></span>
    </label>

    <label class="switchLabel">Telefoonnummer openbaar
    <input class="checkbox-macht-onder" type="checkbox">
    <span id="buttonTelefoon" class="checkmark"></span>
    </label>

    <label class="switchLabel">BTW nummer openbaar
    <input class="checkbox-macht-onder" type="checkbox">
    <span id="buttonBtw" class="checkmark"></span>
    </label>
</div>



<?php include_once("../includes/footer.php");?>


</body>
</html>