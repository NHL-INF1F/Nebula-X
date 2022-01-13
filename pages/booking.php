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

if (!isset($_SESSION['email'])) {
    $_SESSION['redirected'] = $message['redirected'];
    header('location: ./login.php');
}

require_once "../controllers/database/dbconnect.php";
require_once "../controllers/database/reservation-db-functions.php";

if (!isset($_SESSION['suiteId']) || !isset($_SESSION['dateFrom']) || !isset($_SESSION['dateTo'])) {
    showError("no_information_passed");
}

$dateFrom = $_SESSION['dateFrom'];
$dateTo = $_SESSION['dateTo'];


if(!strtotime($dateFrom)){
    showError("invalid_start_date");
}

if(!strtotime($dateTo)){
    showError("invalid_end_date");
}

$suiteID = $_SESSION['suiteId'];

$suiteData = getSuite($suiteID);

if(empty($suiteData)){
    showError("invalid_suite_id");
}

$userID = $_SESSION['id'];
?>

<div id="booking-confirm-page" class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <div class="row w-75 h-100 mx-auto my-0">
        <div class="offset-3 col-6 p-4 bg-white text-center">
            <h1><?php echo $message['booking_confirm_title'] ?></h1>

            <?php
            if(isset($_POST['cancel'])){
                unset($_SESSION['dateFrom']);
                unset($_SESSION['dateTo']);
                unset($_SESSION['suiteId']);
                header('location: suite-overview.php');
            }

            if (isset($_POST['confirm'])) {
                if(!bookSuite($userID, $suiteID, $dateFrom, $dateTo)){
                    showError("reservation_save_error");
                }

                header("location: booking-confirm.php");
            }

            //null should never appear outside development.
            $firstName = $_SESSION['firstname'] ?? null;
            $lastname = $_SESSION['lastname'] ?? null;
            $email = $_SESSION['email'] ?? null;

            if(!isset($firstName) || !isset($lastname) || !isset($email)){
                showError("user_load_error");
            }

            echo "<span class='fw-bold'>" . $message['booking_user'] . "</span><br>";
            echo $message['booking_firstname'] . $firstName . "<br>";
            echo $message['booking_lastname'] . $lastname . "<br>";
            echo $message['booking_email'] . $email . "<br>";
            echo "<hr>";
            echo "<span class='fw-bold'>" . $message['booking_suite'] . "</span><br>";
            echo $message['booking_suite_name'] . $suiteData['name'] . "<br>";
            echo $message['booking_suite_size'] . $suiteData['suite_size'] . "<br>";
            echo $message['booking_suite_rooms'] . $suiteData['rooms'] . "<br>";
            echo "<hr>";
            echo $message['booking_period'] . $dateFrom . " - " . $dateTo . "<br>";
            echo $message['booking_suite_price'] . "$" . $suiteData['price'] . "<br><br>";
              ?>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post">
            <div class="row">
                    <div class="col-xxl-4 offset-xxl-1 col-12 col-xl-6 mb-4 mb-xl-0 buttonBox cancelBox">
                        <input class="ps-3 button" type="submit" name="cancel" value="<?php echo $message['booking_cancel'];?>">
                    </div>
                    <div class="col-xxl-4 offset-xxl-2 col-12 col-xl-6 buttonBox">
                        <input class="ps-3 button" type="submit" name="confirm" value="<?php echo $message['booking_confirm'];?>">
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
<?php

function showError($errorKey){
    $_SESSION['error'] = $errorKey;
    header("location: ./error.php");
}
?>
</body>
</html>