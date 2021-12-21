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

    <style>
        /* global */
        ul {
            list-style-type: none;
        }

        h1,
        h2 {
            font-family: Bebas Neue;
        }

        p,
        a {
            font-family: Arimo;
        }

        img {
            max-width: 180px !important;
        }

        .arrow {
            font-size: 2em;
            cursor: pointer;
        }

        /* Backgrounds */
        .spaceBackground {
            background-image: url('assets/img/space.jpg');
            background-repeat: no-repeat, repeat;
            background-size: cover;
        }

        .spaceStation {
            background-image: url('assets/img/a140a5c1206d3cd334cf1781d0d41d0b.png');
            background-repeat: no-repeat, repeat;
            background-size: 500px;
            background-position: center;
        }

        .seeThrough {
            background-color: rgba(0, 0, 0, 0.185);
        }

        .footerBackground {
            background-color: #0f2636;
        }

        /* header */
        .header {
            position: fixed;
        }

        .headerList {
            display: inline;
            margin: 6px;

        }

        .headerList a {
            font-family: Bebas Neue;
            color: white;
            text-decoration: none;
            font-size: 1.5em;
        }

        .headerList a:hover {
            border-bottom: 2px solid white;
        }

        /* content */
        .midText {
            max-width: 400px;
        }

        /* footer */
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            color: white;
        }

        .footer li a {
            color: white;
            text-decoration: none;
        }

        .footer li a:hover {
            border-bottom: 1px solid white;
        }
    </style>
</head>

<body>

    <div class="container-fluid header">
        <div class="row">
            <div class="col-12 col-md-6 d-flex justify-content-md-start">
                <img src="assets/img/logoWit.svg" class="img-fluid" alt="Logo">
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end">
                <ul class="p-0 mt-4">
                    <li class="headerList"><a href="index.php">Gallery</a></li>
                    <li class="headerList"><a href="index.php">About Us</a></li>
                    <li class="headerList"><a href="index.php">Rooms</a></li>
                    <li class="headerList"><a href="index.php">Booking</a></li>
                    <li class="headerList"><a href="index.php">Contact</a></li>
                    <li class="headerList"><a href="index.php">Login/Register</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid min-vh-100 m-0 p-0 spaceBackground">
        <div class="row w-100 min-vh-100 m-0">
            <div class="col-md-6 bg-succes spaceStation">

            </div>
            <div class="col-md-6 text-white min-vh-100">
                <div class="row min-vh-100 d-flex justify-content-start align-items-center seeThrough">
                    <div class="col-1">
                        <span onclick="hide()" class="arrow"><i class="fas fa-chevron-right"></i></span>
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
                <div class="text-center">
                    <span class="arrow"><i class="fas fa-chevron-up"></i></span>
                </div>
                <div>
                    <img src="assets/img/spacerx-logo.svg" class="img-fluid" alt="Logo">
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid footer footerBackground">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="arrow"><i class="fas fa-chevron-down"></i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img src="assets/img/logoWit.svg" class="img-fluid" alt="Logo">
                <p>Space as never before!</p>
            </div>
            <div class="col-sm-3">
                <h1>Explore</h1>
                <ul class="p-0 m-0">
                    <li><a href="">About us</a></li>
                    <li><a href="">Rooms</a></li>
                    <li><a href="">Booking</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Login/Register</a></li>
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
                <img src="assets/img/spacerx-logo.svg" class="img-fluid" alt="Logo">
            </div>
        </div>
    </div> -->

</body>

</html>