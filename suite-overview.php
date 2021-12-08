<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nebula-X</title>
    <link href="assets/styles/suits.css" rel="stylesheet">
</head>
<body>
<div id="suite-overview">
    <?php
    include_once "controllers/database/dbconnect.php";
    include_once "controllers/database/reservation-db-functions.php";
    include_once "Suite.class.php";
    $suites = getSuites();
    /* @var $suite Suite */
    foreach ($suites as $suite) { ?>
        <div class="suite">
            <?php
            $dirPath = "assets/img/suites/" . $suite->getId() . "/";
            if (!file_exists($dirPath)) {
                mkdir($dirPath);
            }

            $photos = scandir($dirPath);
            $photoPath = "assets/img/suites/placeholder.png";
            foreach ($photos as $photo) {
                $path = $dirPath . $photo;
                if (!isImage($path)) {
                    continue;
                }
                $photoPath = $path;
                break;
            }
            echo "<div class='suite-image'><img src='" . $photoPath . "' alt='" . $suite->getName() . "'></div>";
            ?>
            <div class="suite-text">
                <h2 style="display: inline-block"><a href="suite.php?id=<?php echo $suite->getId() ?>">
                        <?php echo $suite->getName(); ?></a></h2>
                <div class="suite-details">
                    Size: <?php echo $suite->getSize(); ?>
                </div>
                <p><?php echo $suite->getDescription(); ?></p>
                <div style="text-align: right">price...</div>
            </div>
        </div>

    <?php }

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
<style>


</style>
</html>