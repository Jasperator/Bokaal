<?php

include_once(__DIR__ . "/bootstrap.include.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">

    <title>Home</title>
</head>
<body>
<?php include_once("nav.include.php");
echo $_SESSION['user'];
echo $_SESSION['user-status']
?>


  	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>  
</body>
</html>