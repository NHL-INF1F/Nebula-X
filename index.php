<?php
require('components/translation/en.php');
require_once('controllers/database/dbconnect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nebula-X</title>

    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- script for closing divs -->
    <script type="text/javascript" src="assets/scripts/slider.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/index.css">
</head>

<body>

    <div class="container-fluid header">
        <div class="row">
            <div class="col-12 col-md-6 d-flex justify-content-md-start">
                <img src="assets/img/logo/logoWit.svg" class="img-fluid" alt="Logo">
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end">
                <ul class="p-0 mt-4">
                    <li class="headerList"><a href="index.php">Gallery</a></li>
                    <li class="headerList"><a href="index.php">About Us</a></li>
                    <li class="headerList"><a href="index.php">Rooms</a></li>
                    <li class="headerList"><a href="index.php">Booking</a></li>
                    <li class="headerList"><a href="pages/contact.php">Contact</a></li>
                    <li class="headerList"><a href="pages/register.php">Login/Register</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid min-vh-100 m-0 p-0 spaceBackground">
        <div class="row w-100 min-vh-100 m-0">
            <div class="col-md-6 bg-succes spaceStation">

            </div>
            <div class="col-md-6 text-white min-vh-100">
                <div id="slidebar" class="row min-vh-100 d-flex justify-content-start align-items-center">
                    <div class="col-1">
                        <div onclick="hide()">
                            <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                    <div class="col-11">
                        <div>
                            <h2 class="d-block">nebula-x</h2>
                            <h1 class="d-block midText">A NEW WAY TO EXPERIENCE SPACE AS NEVER BEFORE</h1>
                            <a class="text-decoration-none text-white learnMore" href="index.php">
                                <h2 class="d-block">Learn more</h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid footer">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span class="SpaceXLogo">EMPOWERED BY</span>
                    <img src="assets/img/logo/spacerx-logo.svg" class="img-fluid" alt="Logo">
                </div>
            </div>
        </div>
    </div>
    
    <div id="slideFooter" class="container-fluid footer">
        <div class="row">
            <div class="col-md-12 text-center">
                <div onclick="show()">
                    <span class="arrow"><i class="fas fa-chevron-down"></i></span>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img src="assets/img/logo/logoWit.svg" class="img-fluid" alt="Logo">
                <p>Space as never before!</p>
            </div>
            <div class="col-sm-3">
                <h1>Explore</h1>
                <ul class="p-0 m-0">
                    <li><a href="">About us</a></li>
                    <li><a href="">Rooms</a></li>
                    <li><a href="">Booking</a></li>
                    <li><a href="pages/contact.php">Contact</a></li>
                    <li><a href="pages/register.php">Login/Register</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <div>
                    <h1>Visit</h1>
                    <p>1030 15th Street N.W.</p>
                    <p>Suike 220E Distruct of Columbia DC</p>
                    <p>20005-1503</p>
                </div>

                <div>
                <h1>HQ</h1> 
                <p>Rocket road HawtHorne.</p>
                <p>Calafornia</p>
                </div>
            </div>
            <div class="col-sm-3">
                <h1>Legal</h1> 
                <p>Terms</p>
                <p>Privacy</p>
            </div>
        </div>
        <div class="row text-start">
            <div class="col-md-12">
                <span class="SpaceXLogo">EMPOWERED BY</span>
                <img src="assets/img/logo/spacerx-logo.svg" class="img-fluid" alt="Logo">
            </div>
        </div>
    </div>

</body>

</html>