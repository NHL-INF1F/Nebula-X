<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nebula-X</title>
    <!--<link href="../assets/styles/suits.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>
    <link href="../assets/styles/bookingconfirm.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/header.css">
</head>
<body>
<?php
require_once("../components/header.php");
require_once "../controllers/database/dbconnect.php";
require_once "../controllers/database/reservation-db-functions.php";

$suiteID = $_SESSION['suite_id'];
unset($_SESSION['suite_id']);

if(!isset($_SESSION['id'])){
    header("location: ./index.php");
}

$userID = $_SESSION['id'];
?>

<div id="booking-confirm-page" class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <div class="row w-75 h-100 mx-auto my-0">
        <div class="offset-3 col-6 p-4 bg-white text-center">
            <h1><?php echo $message['booking_confirmed_title'] ?></h1>

            <?php
            $dateFrom = $_SESSION['date-from'];
            $dateTo = $_SESSION['date-to'];

            if(!isset($dateFrom) || $dateTo){
               showError("no_information_passed");
            }

            //$suiteID = $_SESSION['suite_id'];
            unset($_SESSION['date-from']);
            unset($_SESSION['date-to']);

            //Check if the reservation is correctly saved in the database.
            if(!getReservation($suiteID, $userID, $dateFrom, $dateTo)){
                //If this happens then something is really wrong.
                showError("reservation_save_error");
            }

            echo $message['booking_confirmed_message'];

            if (isset($_POST['return'])) {
                header("location: ../index.php");
            }
              ?>
            <div class="row">
                <div class="col-xxl-6 offset-xxl-3 col-12 buttonBox">
                    <a href="../index.php"><input class="ps-3 button" type="button" name="confirm" value="<?php echo $message['booking_back'];?>"</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function showError($errorKey){
    $_SESSION['error'] = $errorKey;
    header("location: ./error.php");
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
</body>
</html>