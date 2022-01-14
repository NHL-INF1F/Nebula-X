<?php
session_start();
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
    <link rel="stylesheet" href="../assets/styles/aboutus.css">
    <link rel="stylesheet" href="../assets/styles/header.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>About us</title>
</head>
<body>
<?php
    require_once("../components/header.php"); ?>
    <div class="container-fluid min-vh-100 m-0 p-0 spaceBackground">
        <div class="row">
        <!-- Leftside text -->
            <div class="col-md-5 p-tl text-white">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="d-block"><?php echo $message['about'] ?></h4>
                        <h5 class="d-block midText"><?php echo $message['aim'] ?></h5>
                        <p class="d-block"><?php echo $message['aboutusinfo'] ?></p>
                    </div>
                </div>
        <!-- Leftside image -->
                <div class="row m-t">
                    <div class="col-md-12">
                        <img class="img-fluid" src="../assets/img/pngwing.com.png" alt="universe">
                    </div>
                </div>
            </div>
        <!-- Rightside image -->
            <div class="col-md-7 bg-succes  min-vh-100 d-flex align-items-center justify-content-center">
                <div class="row imgBorder mx-auto d-none d-md-block">
                    <div class="col-md-12">
                        <img class="img-fluid imgP" src="../assets/img/SpaceX_Crew.jpg" alt="SpaceX Crew">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php 
        require_once("../components/footer.php"); ?>
</body>
</html>