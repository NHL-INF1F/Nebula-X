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
</head>
<body>
<?php
include_once "../controllers/database/dbconnect.php";
include_once "../controllers/database/reservation-db-functions.php";

//TODO: This is temp as the header is not on this branch.
require_once('../components/translation/en.php');

//TODO: Tijdelijk een GET override voor testen.
//TODO: Pak het ID uit get en anders uit POST.
if(isset($_GET['id'])){
    $suiteID = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
} else {
    if (!isset($_POST['id'])) {
        showError("no_information_passed");
    }
    $suiteID = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
}

$suiteData = getSuite($suiteID);

//TODO: Dit wordt straks uit SESSION gehaald.
$userID = 1;

/*if(!isset($_SESSION['user'])){
    die("Not logged in.");
}

$userID = $_SESSION['user'];*/
?>

<div id="booking-confirm-page" class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <div class="row w-75 h-100 mx-auto my-0">
        <div class="offset-3 col-6 p-4 bg-white text-center">
            <h1><?php echo $message['booking_confirm_title'] ?></h1>

            <?php

            if(isset($_POST['cancel'])){
                header('location: suite-overview.php');
            }

            if (isset($_POST['confirm'])) {
                $dateFrom = filter_input(INPUT_POST, "date-from", FILTER_SANITIZE_STRING);
                $dateTo = filter_input(INPUT_POST, "date-to", FILTER_SANITIZE_STRING);

                if(!strtotime($dateFrom)){
                    showError("invalid_start_date");
                }

                if(!strtotime($dateTo)){
                    showError("invalid_end_date");
                }

                if ($dateFrom > $dateTo) {
                    showError("invalid_start_date");
                }

                bookSuite($userID, $suiteID, $dateFrom, $dateTo);
                die("Suite booked");
            }

            //null should never appear outside development.
            $firstName = $_SESSION['firstname'] ?? "null";
            $lastname = $_SESSION['lastname'] ?? "null";
            $email = $_SESSION['email'] ?? "null";

            echo $message['booking_firstname'] . $firstName . "<br>";
            echo $message['booking_lastname'] . $lastname . "<br>";
            echo $message['booking_email'] . $email . "<br>";
            echo "<hr>";
            echo "<span class='font-weight-bold'>" . $message['booking_suite'] . "</span>";
            echo $message['booking_suite_name'] . $suiteData['name'] . "<br>";
            echo $message['booking_suite_size'] . $suiteData['suite_size'] . "<br>";
            echo $message['booking_suite_rooms'] . $suiteData['rooms'] . "<br>";
            echo "<hr>";
            echo $message['booking_suite_price'] . "$" . $suiteData['price'] . "<br><br>";
              ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post">
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
    header("./booking-error.php");
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