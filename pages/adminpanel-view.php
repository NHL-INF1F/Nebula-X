<?php
//Start a session
session_start();

//Check if user is logged
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    //Send user to index.php
    header('location: ../index.php');
}

require_once ('../components/translation/en.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adminpanel</title>
    <meta charset="UTF-8">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/styles/adminpanel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/index.css">

    <!-- modal script -->
    <script>
        // Script for the modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp
        // Get the modal
        var modal = document.getElementById('delbtnpress');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <!-- Connect to database -->
    <?php
    include('../controllers/database/dbconnect.php');
    require_once('../components/header.php');
    require('../components/translation/en.php');
    ?>
</head>
<body>
<div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <main class="d-flex align-items-center">
        <div class="col-md-12 p-6 bg-white">
            <div class="text-center">
                <div>
                    <h1>Reservation Details</h1>
                </div>

                <?php
                $reservationid = filter_input(INPUT_GET, "id");

                $reservationsql = "SELECT ID, user_id, suite_id, date_from, date_to FROM reservation WHERE ID=$reservationid";
                $reservationstmt = mysqli_prepare($conn, $reservationsql);
                if (!$reservationstmt) {
                    $_SESSION['error'] = "database_error";
                    header("location: error.php");
                }
                if(!mysqli_stmt_execute($reservationstmt)){
                    $_SESSION['error'] = "database_error";
                    header("location: error.php");
                }
                mysqli_stmt_bind_result($reservationstmt, $ID, $user_id, $suite_id, $date_from, $date_to);

                while (mysqli_stmt_fetch($reservationstmt)) {
                    echo "<div> 
                    Reservation ID: " . $ID . ".
                </div>";
                    echo "<h2>Reservated dates</h2>";
                    echo "from: " . $date_from . ".<br>";
                    echo "to: " . $date_to . ".";
                }
                $userID = $user_id;
                $suiteID = $suite_id;
                mysqli_stmt_close($reservationstmt);
                ?>
                <div>
                    <div>
                        <?php
                        $suitesql = "SELECT ID, suite_size, name, price FROM suite WHERE ID=$suiteID";
                        $suitestmt = mysqli_prepare($conn, $suitesql);
                        if(!$suitestmt){
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        if(!mysqli_stmt_execute($suitestmt)){
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        mysqli_stmt_bind_result($suitestmt, $ID, $suite_size, $name, $price);

                        //display the reservated suite
                        while (mysqli_stmt_fetch($suitestmt)) {
                            echo "<h2>Reservated Suite</h2><br>";
                            echo "<table style=>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>size</th>
                            <th>Price</th>
                        </tr>
                        <tr>
                            <td>$ID</td>
                            <td>$name</td>
                            <td>$suite_size</td>
                            <td>$price</td>
                        </tr>
                    </table>";
                        }

                        mysqli_stmt_close($suitestmt);
                        ?>
                    </div>
                    <div>
                        <?php
                        $usersql = "SELECT ID, firstname, lastname, email FROM user WHERE ID=$userID";
                        $userstmt = mysqli_prepare($conn, $usersql);
                        if(!$userstmt){
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        if(!mysqli_stmt_execute($userstmt)){
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        };
                        mysqli_stmt_bind_result($userstmt, $ID, $firstname, $lastname, $email);

                        //display the account reservating the suite
                        while (mysqli_stmt_fetch($userstmt)) {
                            echo "<h2>Reservating User</h2>";
                            echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                        </tr>
                        <tr>
                            <td>$ID</td>
                            <td>$firstname $lastname</td>
                            <td>$email</td>
                        </tr>
                    </table>";
                        }

                        $userEmail = $email;
                        mysqli_stmt_close($userstmt);
                        ?>
                    </div>
                    <div>
                        <?php
                        //Delete button
                        echo "<div><a href=adminpanel.php><- Return to the Adminpanel</a></div>";
                        echo "<div><button onclick=document.getElementById('delbtnpress').style.display='block'>Delete Reservation</button></div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pop-up confirmation for deletion, using the Modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp -->
        <div id="delbtnpress" class="modal">
            <span onclick="document.getElementById('delbtnpress').style.display='none'" class="close"
                  title="Close Modal">??</span>
            <form class="modal-content" action="/action_page.php">
                <div class="container">
                    <h1>Delete Confirmation</h1>
                    <h2>Are you sure you want to delete the reservation?</h2>
                    <p>WARNING: MAKE SURE TO SEND AN EMAIL TO THE USER BEFORE DELETING THE RESERVATION IT WILL BE GONE
                        FOREVER!</p>
                    <div class="clearfix">
                        <?php
                        echo "<a id=linktobtnmail href=mailto:$userEmail?subject=Cancellation%20of%20reservation>Send Email</a>";
                        echo "<a id=linktobtndel href=../components/adminpanel/delete_reservation.php?id=" . $_GET['id'] . "class=deletebtn>Delete</a>";

                        ?>
                        <button class="delbtnstyle" type="button"
                                onclick="document.getElementById('delbtnpress').style.display='none'" class="cancelbtn">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
</body>
</html>