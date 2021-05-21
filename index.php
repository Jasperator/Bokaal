<?php


include_once(__DIR__ . "/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/Favorite.php");
require_once(__DIR__ . "/classes/User.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite();



$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();


function getDistance($addressFrom, $postalcodeoFrom, $addressTo, $postalcodeoTo, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyAZvw5R_4B6VsHG9MTrobGTrWFAL3gosNk';
    
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'+'. $postalcodeoFrom .'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }

    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo .'+'. $postalcodeoTo .'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }
    
    // Get latitude and longitude from the geodata
    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    
    // Convert unit and return distance
    $unit = strtoupper($unit);
    if($unit == "K"){
        return round($miles * 1.609344, 2).' km';
    }elseif($unit == "M"){
        return round($miles * 1609.344, 2).' meters';
    }else{
        return round($miles, 2).' miles';
    }
}

// $addressFrom = 'Adolf Mortelmansstraat 74';
// $addressTo   = 'Dascoottelei 890';



// // Get distance in km
// $distance = getDistance($addressFrom, $addressTo, "K");


if (!empty($_POST['favorite-person'])) {
    $favorite_id = $_POST['favorite-person'];
    
    $favorite->insertFavorite($user,$favorite_id);
    
$favorites = $favorite->getAllFavorites($user);
$sellers = $user->getSellersExceptUser();

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/bootstrap.css">-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/svg" href=images/logo/favicon.png> <title>Bokaal | Home</title>
</head>

<body id="index-body">
    <?php include_once("nav.include.php");?>
    <div>

    
        <div >
            <h2 class="hoofdtitel">Home</h2>
            <!-- <div class="line-under" ></div> -->
        </div>

        <ul id="all">
            <h3 class="titel-index">Favorieten</h3>
            <?php foreach ($favorites as $fav) : ?>
            <li id="list">
                <div class="container">
                    <div>
                        <div id="foto">
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="./uploads/<?= htmlspecialchars($fav->profile_img); ?>" />
                                </div>
                            </div>
                        </div>

                        <div id="info">
                            <h5 class="text-primary"><?= htmlspecialchars($fav->fullname); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($fav->location); ?></p>
                            <p class="text-primary"><?= htmlspecialchars($fav->company);  ?></p>
                            <p class="text-primary"> Afstand:
                                <?= getDistance($user->getAddress(),$user->getPostal_code(), urlencode($fav->address), urlencode($fav->postal_code), "K");  ?>
                            </p>

                            

                            
                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>
        <div class="space-favor"></div>
        <ul id="all-buurt">
            <div id="pauze"></div>
            <h3 class="titel-index"> Verkopers</h3>
            <?php foreach ($sellers as $seller) : ?>
            <li id="list">
                <div class="container">
                    <div>
                        <div id="foto">
                            <div id="wrapper">
                                <div id="splash-info">
                                    <form action="" method="post">
                                        <img id="picture" src="./uploads/<?= htmlspecialchars($seller->profile_img); ?>"
                                            class="img-thumbnail border-0" />
                                </div>
                            </div>
                        </div>

                        <div id="info">
                            <h5 class="text-primary"><?= htmlspecialchars($seller->fullname); ?></h5>
                            <p class="text-primary"><?= htmlspecialchars($seller->location); ?></p>
                            <p class="text-primary"><?= htmlspecialchars($seller->company);  ?></p>
                            <p class="text-primary"> Afstand:
                                <?= getDistance($user->getAddress(),$user->getPostal_code(), htmlspecialchars($seller->address), htmlspecialchars($seller->postal_code), "K");  ?>
                            </p>


                            <form id="favor" action="" method="post">

                                <div class="fav-but" class="form-group">
                                    <button id="knop" type="submit" name="favorite-person" class="fav"
                                        value="<?= htmlspecialchars($seller->id); ?>" name="fav"> <img class="favor-img"
                                            src="images\icon\star.png" alt=""></button>
                                </div>
                            </form>


                        </div>
                        <?php endforeach ?>
                    </div>
            </li>
        </ul>

    </div>
    <div id="space"></div>







    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>