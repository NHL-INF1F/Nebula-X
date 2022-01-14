<?php
session_start();
require('../components/translation/en.php');
require_once('../controllers/database/dbconnect.php');
require_once("../controllers/database/reservation-db-functions.php");

if (!isset($_SESSION['email'])) {
    $_SESSION['redirected'] = $message['redirected'];
    header('location: ./login.php');
}

$today = date("Y-m-d");
$tomorrow = date("Y-m-d", time()+60*60*24);

function getImage($selected) {
    $dir = "../assets/img/suites/" . $selected . "/";
    $fileType = "*.png";
    $dirOpen = opendir($dir);

    echo '
    <div class="slideshow-container">
    ';
    while (($file = readdir($dirOpen))) {
        if (is_dir($file)) {
            continue;
        }

        if (fnmatch($fileType, $file)) {

            $fileName = substr_replace($file,"",-4);
            echo '
            <div class="mySlides">
                <img src="'. $dir . "/" . $file .'" class="img-fluid" alt="'.$fileName.'" alt="'.$fileName.'">
            </div>
            ';
        }
    }
    closedir($dirOpen);

    echo '
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    ';
}

if (!isset($_GET['floor'])){
    $floor = 1;
} else {
    $floor = (int) filter_input(INPUT_GET, 'floor', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (!isset($_GET['selected'])){
    $selected = 1;
} else {
    $selected = (int) filter_input(INPUT_GET, 'selected', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (!isset($_GET['dateStart'])){
    $startDate = $today;
} else {
    $startDate = filter_input(INPUT_GET, 'dateStart', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (!isset($_GET['dateEnd'])){
    $endDate = $tomorrow;
} else {
    $endDate = filter_input(INPUT_GET, 'dateEnd', FILTER_SANITIZE_SPECIAL_CHARS);
}

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

    <!-- script for closing divs -->
    <script type="text/javascript" src="../assets/scripts/slider.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/suites.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/header.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">
</head>
<body>
<main>
    <?php 
    require_once("../components/header.php");
    ?>

    <div class="container-fluid min-vh-100 spaceBackground pt-5">
        <div class="row bg-white w-75 m-auto">
            <div class="col-sm-12 col-xl-6">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Available Suites</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="get" class="mw-50">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6">
                                    <label for="dateStart" class="form-label">From</label>
                                    <input class="form-control" type="date" id="dateStart" name="dateStart" required value="<?php echo  $_GET['dateStart'] ?? $today;?>">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">To</label>
                                    <input class="form-control" type="date" id="dateEnd" name="dateEnd" required value="<?php echo $_GET['dateEnd'] ?? $tomorrow;?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="btn btn-primary" type="submit" value="Check dates">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-5 text-center">
                    <div class="col-sm-12">
                        <?php
                        if (isset($floor)) {
                            echo '<p>You are currently looking on floor: '.$floor.'</p>';
                        }
                        ?>
                        
                    </div>
                    <div class="col-sm-12 svgBlock">
                        <?php
                        if ($startDate < $endDate && $startDate >= $today) {
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
                            foreach($allReservations as $checkReservations => $reservation){
                                if($startDate <= $reservation['endDate'] && $endDate >= $reservation['startDate']){
                                    array_push($reservedRooms, $reservation['id']);
                                }
                                elseif($endDate >= $reservation['startDate'] && $endDate <= $reservation['endDate']){
                                    array_push($reservedRooms, $reservation['id']);
                                }
                            }
                            
                            echo "<svg>";
                            // coordinates generated with https://www.image-map.net/
                            if ($floor === 1){
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=1'>'";
                                echo "<polygon points='198,128 199,5 171,7 141,14 121,22 97,33 78,48 61,61 49,75 38,89 30,101 26,109 132,170 139,158 149,147 161,139 173,133 185,130' style='fill:";
                                    if(in_array(1, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=2'>'";
                                echo "<polygon points='199,6 198,128 210,130 223,133 235,139 245,146 251,151 257,158 261,163 265,168 375,118 364,96 353,80 335,60 315,43 293,29 269,18 248,11 223,7' style='fill:";
                                    if(in_array(2, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=3'>'";
                                echo "<polygon points='375,117 384,140 391,174 393,200 391,226 388,244 381,266 373,284 364,300 354,314 347,324 335,335 251,250 262,236 269,221 272,204 271,184 265,168' style='fill:";
                                    if(in_array(3, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=4'>'";
                                echo "<polygon points='151,256 76,348 93,361 116,373 140,383 167,389 196,392 230,390 253,384 288,371 305,360 320,349 335,335 251,250 240,258 225,266 210,270 196,272 184,270 170,265 160,261' style='fill:";
                                    if(in_array(4, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=5'>'";
                                echo "<polygon points='25,109 132,169 126,188 125,204 129,222 135,236 143,247 151,256 76,349 50,325 35,304 24,282 15,262 7,231 4,207 4,184 9,157 15,135' style='fill:";
                                    if(in_array(5, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";     
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=".$selected."'>";
                                echo "<circle cx='200' cy='199' r='38' style='fill:lime;stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                            } elseif ($floor === 2){
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=6'>'";
                                echo "<polygon points='198,128 199,5 171,7 141,14 121,22 97,33 78,48 61,61 49,75 38,89 30,101 26,109 132,170 139,158 149,147 161,139 173,133 185,130' style='fill:";
                                    if(in_array(6, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=7'>'";
                                echo "<polygon points='199,6 198,128 210,130 223,133 235,139 245,146 251,151 257,158 261,163 265,168 375,118 364,96 353,80 335,60 315,43 293,29 269,18 248,11 223,7' style='fill:";
                                    if(in_array(7, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=8'>'";
                                echo "<polygon points='375,117 384,140 391,174 393,200 391,226 388,244 381,266 373,284 364,300 354,314 347,324 335,335 251,250 262,236 269,221 272,204 271,184 265,168' style='fill:";
                                    if(in_array(8, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=9'>'";
                                echo "<polygon points='151,256 76,348 93,361 116,373 140,383 167,389 196,392 230,390 253,384 288,371 305,360 320,349 335,335 251,250 240,258 225,266 210,270 196,272 184,270 170,265 160,261' style='fill:";
                                    if(in_array(9, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                                echo "<a href='./suite-overview.php?floor=2&dateStart=".$startDate."&dateEnd=".$endDate."&selected=10'>'";
                                echo "<polygon points='25,109 132,169 126,188 125,204 129,222 135,236 143,247 151,256 76,349 50,325 35,304 24,282 15,262 7,231 4,207 4,184 9,157 15,135' style='fill:";
                                    if(in_array(10, $reservedRooms, true)){
                                        echo "red";
                                    }else{
                                        echo "lime";
                                    }
                                echo ";stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";     
                                echo "<a href='./suite-overview.php?floor=1&dateStart=".$startDate."&dateEnd=".$endDate."&selected=".$selected."'>";
                                echo "<circle cx='200' cy='199' r='38' style='fill:lime;stroke:black;stroke-width:1;fill-rule:evenodd;' /></a>";
                            }
                            echo "</svg>";
                        } else {
                            echo "The start date can't be later or the same day as the end date.";
                        }
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-xl-6">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        if (!empty($selected)){
                            getImage($selected);
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        if (!empty($selected)) {
                            $info = getSuite($selected);
                        }
                        ?>
                        <h3><?php echo $info['name'];?></h3>
                        <p><?php echo $info['name'];?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <?php
                        if(in_array($selected, $reservedRooms, true)) {
                            echo "The selected room is unavailable";
                        } else {
                            echo "<a class='btn btn-primary' href='booking.php' class='button' onclick='";
                            echo $_SESSION['suiteId'] = $selected;
                            echo $_SESSION['dateFrom'] = $startDate;
                            echo $_SESSION['dateTo'] = $endDate;
                            echo "'>".$message['bookNow']."</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
}
</script>
</body>
</html>