<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nebula-X</title>
    <link href="assets/styles/suits.css" rel="stylesheet">
</head>
<body>
<?php
include_once "controllers/database/dbconnect.php";
include_once "controllers/database/reservation-db-functions.php";

if (!isset($_GET['id'])) {
    die("No suite ID was given.");
}

$suiteID = filter_input(INPUT_GET, "id");
$suiteData = getSuite($suiteID);?>

<div id="suite-single">
    <h1 class="suite-name"><?php echo $suiteData['name']?></h1>
    <form method="post" action="suite.php?id=<?php echo $suiteID ?>">
    <div class="suite-dates">
        <label>
            DateFrom
            <input type="date" id="date-from" name="date-from" required value="2021-01-01">
        </label>
        <label>
            DateTo
            <input type="date" id="date-to" name="date-to" required value="2021-01-01">
        </label>
    </div>
    <?php
    if(isset($_POST['booksuite'])){
        $dateFrom = filter_input(INPUT_POST, "date-from");
        $dateTo = filter_input(INPUT_POST, "date-to");

        if(!strtotime($dateFrom) || !strtotime($dateTo)){
            die("Invalid date.");
        }

        if($dateFrom > $dateTo){
            die("The start date cannot be after the end date");
        }

        //Tijdelijk totdat het login systeem er is.
        $userID = 1;

        bookSuite($userID, $suiteID, $dateFrom, $dateTo);
        die("Suite booked");

    }


    $dirPath = "assets/img/suites/" . $suiteID . "/";
    if (!file_exists($dirPath)) {
        mkdir($dirPath);
    }
    $photos = scandir($dirPath);
    $hasPhotos = false;
    foreach ($photos as $photo) {
        $path = $dirPath . $photo;
        if (!isImage($path)) {
            continue;
        }
        $hasPhotos = true;
        echo "<img src='" . $path . "' alt='" . $suiteData['name'] . "'>";
    }

    if(!$hasPhotos){
        echo "<img src='assets/img/suites/placeholder.png' alt='" .
            $suiteData['name'] . "'>";
    }
    ?>
    <div class="suite-text">
        <div class="suite-details">
            Size: <?php echo $suiteData['suite_size'] ?>
            Rooms: <?php echo $suiteData['rooms'] ?>
        </div>
        <p><?php echo $suiteData['description']?></p>
        <div class="left-align">
            <div class="suite-price">Price: &dollar;<?php echo $suiteData['price']?></div>

                <input type="submit" id="booksuite" name="booksuite" value="Book now!">
        </div>
    </div>
    </form>
</div>


<?php

function isImage($path) : bool {
    if(@is_array(getimagesize($path))){
        $image = true;
    } else {
        $image = false;
    }
    return $image;
}
?>

</body>
</html>