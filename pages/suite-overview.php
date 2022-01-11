<?php
session_start();
require('../components/translation/en.php');
require_once('../controllers/database/dbconnect.php');
require_once("../controllers/database/reservation-db-functions.php");
$today = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suites</title>

    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- CSS only -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/suites.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/header.css"> -->
</head>
<body>
    <main>
        <h1>Available Suites</h1>
        <div>
            <form action="<?php htmlentities($_SERVER['PHP_SELF']);?>" method="get">
                <div>
                    <label>
                        From
                        <input type="date" id="dateStart" name="dateStart" required value="<?php echo  $_GET['dateStart'] ?? $today;?>">
                    </label>
                <!-- </div>
                <div> -->
                    <label>
                        To
                        <input type="date" id="dateEnd" name="dateEnd" required value="<?php echo $_GET['dateEnd'] ?? $today;?>">
                    </label>
                <!-- </div>
                <div> -->
                    <input type="submit" value="Check dates">
                </div>
            </form>
        </div>
        <?php
        $startDate = filter_input(INPUT_GET, 'dateStart');
        $endDate = filter_input(INPUT_GET, 'dateEnd');
        if ($startDate < $endDate){
            $getReserved = "SELECT suite_id, date_from, date_to FROM reservation";
            $stmt = mysqli_prepare($conn, $getReserved);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $suiteId, $dateFrom, $dateTo);
            $allReservations = array();
            $reservedRooms = array();
            while(mysqli_stmt_fetch($stmt)){
                array_push($allReservations, array("id" => $suiteId, "startDate" => $dateFrom, "endDate" => $dateTo)
                );
            }
            mysqli_stmt_close($stmt);
            // echo "<br>".$startDate."<br>".$endDate."<br><br>";
            foreach($allReservations as $checkReservations => $reservation){
                // echo $reservation['id']."<br>";
                // echo $reservation['startDate']."<br>";
                // echo $reservation['endDate']."<br>";
                if($startDate < $endDate){
                    if($startDate <= $reservation['endDate']){
                        if($endDate >= $reservation['startDate']){
                            // echo "check 1<br>".$reservation['id'];
                            array_push($reservedRooms, $reservation['id']);
                        }
                    }
                    elseif($endDate >= $reservation['startDate']){
                        if($endDate <= $reservation['endDate']){
                            // echo "check 2<br>".$reservation['id'];
                            array_push($reservedRooms, $reservation['id']);
                        }
                    }
                }
            }
            echo "<div>";
            echo "<svg width='400' height='400'>";
            // coordinates generated with https://www.image-map.net/
            echo "<polygon points='198,128 199,5 171,7 141,14 121,22 97,33 78,48 61,61 49,75 38,89 30,101 26,109 132,170 139,158 149,147 161,139 173,133 185,130'
                style='fill:";
                if(in_array(1, $reservedRooms, true)){
                    echo "red";
                }else{
                    echo "lime";
                }
            echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' />
                <polygon points='199,6 198,128 210,130 223,133 235,139 245,146 251,151 257,158 261,163 265,168 375,118 364,96 353,80 335,60 315,43 293,29 269,18 248,11 223,7'
                style='fill:";
                if(in_array(2, $reservedRooms, true)){
                    echo "red";
                }else{
                    echo "lime";
                }
            echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' />
                <polygon points='375,117 384,140 391,174 393,200 391,226 388,244 381,266 373,284 364,300 354,314 347,324 335,335 251,250 262,236 269,221 272,204 271,184 265,168'
                style='fill:";
                if(in_array(3, $reservedRooms, true)){
                    echo "red";
                }else{
                    echo "lime";
                }
            echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' />
                <polygon points='151,256 76,348 93,361 116,373 140,383 167,389 196,392 230,390 253,384 288,371 305,360 320,349 335,335 251,250 240,258 225,266 210,270 196,272 184,270 170,265 160,261'
                style='fill:";
                if(in_array(4, $reservedRooms, true)){
                    echo "red";
                }else{
                    echo "lime";
                }
            echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' />
                <polygon points='25,109 132,169 126,188 125,204 129,222 135,236 143,247 151,256 76,349 50,325 35,304 24,282 15,262 7,231 4,207 4,184 9,157 15,135'
                style='fill:";
                if(in_array(5, $reservedRooms, true)){
                    echo "red";
                }else{
                    echo "lime";
                }
            echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' />
                    <circle cx='200' cy='199' r='38'
                    style='fill:lime;stroke:black;stroke-width:1;fill-rule:evenodd;' />';";
            echo "</svg>";
            echo "</div>";
        } else {
            echo "The start date can't be later or the same day as the end date.";
        }
        // , array('options' => array('default' => $today))
        // , array('options' => array('default' => $today))
        
            // foreach ($suites as $suite) { ?>
             <!-- <div class="suite"> -->
                 <?php
            //     $dirPath = "../assets/img/suites/" . $suite['ID'] . "/";
            //     if (!file_exists($dirPath)) {
            //         mkdir($dirPath);
            //     }

            // $photos = scandir($dirPath);
            // $photoPath = "../assets/img/suites/placeholder.png";
            // foreach ($photos as $photo) {
            //     $path = $dirPath . $photo;
            //     if (!isImage($path)) {
            //         continue;
            //     }
            //     $photoPath = $path;
            //     break;
            // }
            // echo "<div class='suite-image'><img src='" . $photoPath . "' alt='" . $suite['name']  . "'></div>";
            // ?>
            <!-- <div class="suite-text">
                <h2 style="display: inline-block"><a href="suite.php?id=<?php echo $suite['ID'] ?>">
                        <?php echo $suite['name']  ?></a></h2>
                <div class="suite-details">
                    Size: <?php echo $suite['suite_size']?>
                    Rooms: <?php echo $suite['rooms'] ?>
                </div>
                <p><?php echo $suite['description'] ?></p>
                <div class="suite-price">Price: &dollar;<?php echo $suite['price']?></div>
            </div>
        </div> -->

    <?php 
    // }
    

    // function isImage($path): bool {
    //     if (@is_array(getimagesize($path))) {
    //         $image = true;
    //     } else {
    //         $image = false;
    //     }
    //     return $image;
    // }

    ?>
    <!-- <script>
        function showSuite($suiteId){
            
        }
    </script> -->
</div>
</body>
</html>