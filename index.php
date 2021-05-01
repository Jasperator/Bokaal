<?php


include_once(__DIR__ . "/bootstrap.include.php");
$user = new classes\User($_SESSION['user']);
$favorite = new classes\Favorite($_SESSION['user']);



$favorites = $favorite->getAllFavorites($user);

// $address ='Antwerpen'; // Google HQ
// $prepAddr = str_replace(' ','+',$address);
// $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
// $output= json_decode($geocode);
// $latitude = $output->results[0]->geometry->location->lat;
// $longitude = $output->results[0]->geometry->location->lng;
  
// echo "latitude - ".$latitude;
// echo "longitude - ".$longitude;

function getDistance($addressFrom, $addressTo, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyAZvw5R_4B6VsHG9MTrobGTrWFAL3gosNk';
    
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
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

$addressFrom = 'Adolf Mortelmansstraat 74';
$addressTo   = 'Dascoottelei 890';

// Get distance in km
$distance = getDistance($addressFrom, $addressTo, "K");
echo($distance);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/bootstrap.css">-->
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/svg" href=images/Logo/LogoWhite.svg>

    <title>Home</title>
</head>
<body>
<?php include_once("nav.include.php");
?>
    <div class="container">
        <div class="jumbotron">
            <h2>Home</h2>
            <p>Home Page</p>
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