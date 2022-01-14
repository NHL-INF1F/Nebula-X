<?php
session_start();
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
            $fileName = substr_replace($file,"",-4);
            $fileName = str_replace('_', ' ', $fileName);
            echo "
            <div class='col-xl-4'>
                <div class='image'>
                    <img class='img-fluid' alt='". $fileName ." ' src='" . $dir . "/" . $file . "'>
                    <span class='text'>". $fileName ."</span>
                </div>
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
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- script for closing divs -->
    <script type="text/javascript" src="../assets/scripts/slider.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/registerLoginContact.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/gallery.css">
    <link rel="stylesheet" href="../assets/styles/header.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
</head>
<body>

<main class="min-vh-100">
    <?php
    require_once("../components/header.php"); ?>

<div class="container-fluid d-flex align-items-top">
        <div class="row">
            <div class="col-12 ">
                <h1 class="gallery-title"><?php echo $message['gallery']; ?></h1>
            </div>
            <?php
            getImage();
            ?>
        </div>
    <?php
    require_once("../components/footer.php"); ?>
</body>

</html>