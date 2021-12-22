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
    <link href="../assets/styles/register.css" rel="stylesheet">
</head>
<body>
<?php
include_once "../controllers/database/dbconnect.php";
include_once "../controllers/database/reservation-db-functions.php";

//TODO: Give date and user.

if (!isset($_GET['id'])) {
    die("No suite ID was given.");
}

$suiteID = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$suiteData = getSuite($suiteID); ?>

<div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <div class="row w-75 h-100" style="height: 500px; margin: 0 auto;">
        <div class="offset-3 col-6 p-4 bg-white text-center">
            <h1>Booking Confirmation</h1>

            <?php

            if(isset($_POST['cancel'])){
                header('location: suite-overview.php');
            }

            if (isset($_POST['confirm'])) {
                $dateFrom = filter_input(INPUT_POST, "date-from", FILTER_SANITIZE_STRING);
                $dateTo = filter_input(INPUT_POST, "date-to", FILTER_SANITIZE_STRING);

                if (!strtotime($dateFrom) || !strtotime($dateTo)) {
                    die("Invalid date.");
                }

                if ($dateFrom > $dateTo) {
                    die("The start date cannot be after the end date");
                }

                //TODO: Tijdelijk totdat het login systeem er is.
                $userID = 1;

                bookSuite($userID, $suiteID, $dateFrom, $dateTo);
                die("Suite booked");
            }


            ?>

            Firstname: TEMP<br>
            Lastname: TEMP<br>
            Email-address: TEMP<br>
            <hr>
            <span class="font-weight-bold">Suite</span>
            <?php
            echo "Name: " . $suiteData['name'] . "<br>";
            echo "Size: " . $suiteData['suite_size'] . "<br>";
            echo "Rooms: " . $suiteData['rooms'] . "<br>";
            echo "<hr>";
            echo "Price: $" . $suiteData['price'] . "<br><br>";
              ?>
            <form action="booking.php?id=<?php echo $suiteID?>"  method="post">
            <div class="row">
                    <div class="col-4 offset-1 buttonBox cancelBox">
                        <input class="button" type="submit" name="cancel" value="cancel"
                               style="background-color: #8b2727">
                    </div>
                    <div class="col-4 offset-3 buttonBox" style="background-color: #425db8">
                        <input class="button" type="submit" name="confirm" value="confirm">
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
<style>
    .cancelBox:after {
        content: "\f00d";
    }
</style>
<?php

function isImage($path): bool
{
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