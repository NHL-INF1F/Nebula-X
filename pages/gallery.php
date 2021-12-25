<?php
$error = '';

function getImage()
{
    $dir = "../assets/img/gallery";
    $fileType = "*.png";
    $dirOpen = opendir($dir);

    while (($file = readdir($dirOpen))) {
        if (is_dir($file)) {
            continue;
        }

        if (fnmatch($fileType, $file)) {

            echo "
            <div class='image'>
                <img style='width:30vw;' src='" . $dir . "/" . $file . "'>
            </div>
            ";
        }
    }
    closedir($dirOpen);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/registerLogin.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/gallery.css">
    <link rel="stylesheet" href="../assets/styles/header.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
</head>
<body>
    <?php 
    require_once("../components/header.php"); ?>
    <div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
        <div class="container-fluid">
            <div>
                <h1>Gallery</h1>
            </div>
            <div class="gallery">
                <?php
                    getImage();
                ?>
            </div>
        </div>
    </div>
</body>

</html>