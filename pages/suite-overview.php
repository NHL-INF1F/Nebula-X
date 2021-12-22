<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nebula-X</title>
    <link href="../assets/styles/suits.css" rel="stylesheet">
</head>
<body>
<div id="suite-overview">
    <h1>Available Suites</h1>
    <div class="suite-dates">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label>
            DateFrom
            <input type="date" id="date-from" name="date-from" required value="<?php echo  $_POST['date-from'] ?? "2021-01-01"?>">
        </label>
        <label>
            DateTo
            <input type="date" id="date-to" name="date-to" required value="<?php echo $_POST['date-to'] ?? "2021-01-01" ?>">
        </label>
        <input type="submit" value="Zoeken">
        </form>
    </div>
    <?php
    include_once "../controllers/database/dbconnect.php";
    include_once "../controllers/database/reservation-db-functions.php";
    $startDate = filter_input(INPUT_POST, 'date-from', FILTER_SANITIZE_STRING, array('options' => array('default' => "2021-01-01")));
    $endDate = filter_input(INPUT_POST, 'date-to', FILTER_SANITIZE_STRING, array('options' => array('default' => "2021-01-01")));

    if(!strtotime($startDate) || !strtotime($endDate)){
        die("Invalid date.");
    }

    $suites = getFreeSuites($startDate, $endDate);
    if(empty($suites)){
        echo "No available suites";
    } else {
    foreach ($suites as $suite) { ?>
        <div class="suite">
            <?php
            $dirPath = "../assets/img/suites/" . $suite['ID'] . "/";
            if (!file_exists($dirPath)) {
                mkdir($dirPath);
            }

            $photos = scandir($dirPath);
            $photoPath = "../assets/img/suites/placeholder.png";
            foreach ($photos as $photo) {
                $path = $dirPath . $photo;
                if (!isImage($path)) {
                    continue;
                }
                $photoPath = $path;
                break;
            }
            echo "<div class='suite-image'><img src='" . $photoPath . "' alt='" . $suite['name']  . "'></div>";
            ?>
            <div class="suite-text">
                <h2 style="display: inline-block"><a href="booking.php?id=<?php echo $suite['ID'] ?>">
                        <?php echo $suite['name']  ?></a></h2>
                <div class="suite-details">
                    Size: <?php echo $suite['suite_size']?>
                    Rooms: <?php echo $suite['rooms'] ?>
                </div>
                <p><?php echo $suite['description'] ?></p>
                <div class="suite-price">Price: &dollar;<?php echo $suite['price']?></div>
            </div>
        </div>

    <?php }
    }

    function isImage($path): bool {
        if (@is_array(getimagesize($path))) {
            $image = true;
        } else {
            $image = false;
        }
        return $image;
    }

    ?>
</div>
</body>
</html>