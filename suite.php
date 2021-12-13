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

<div class="suite-single">
    <h1><?php echo $suiteData['name']?></h1>
    <?php
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
        </div>
        <p><?php echo $suiteData['description']?></p>
    </div>
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