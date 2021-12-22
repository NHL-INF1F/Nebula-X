<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../assets/styles/adminpanel.css">
        <script>
            // Script for the modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp
            // Get the modal
            var modal = document.getElementById('delbtnpress');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            var modal = document.getElementById('editbtnpress');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <?php
            include('../../controllers/database/dbconnect.php');

        ?>
    </head>
    <body>
        <div>
            <h1>Reservation Details</h1>
        </div>

        <?php
            $reservationid = filter_input(INPUT_GET, "id");

            $reservationsql = "SELECT ID, user_id, suite_id, date_from, date_to FROM reservation WHERE ID=$reservationid";
            $reservationstmt = mysqli_prepare($conn, $reservationsql) or die(mysqli_error($conn));
            mysqli_stmt_execute($reservationstmt) or die("Error");
            mysqli_stmt_bind_result($reservationstmt, $ID, $user_id, $suite_id, $date_from, $date_to);
            
            while (mysqli_stmt_fetch($reservationstmt)) {
                
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
                $suitesql = "SELECT ID, suite_size, name, description, price FROM suite WHERE ID=$suiteID";
                $suitestmt = mysqli_prepare($conn, $suitesql) or die(mysqli_error($conn));
                mysqli_stmt_execute($suitestmt) or die('error');
                mysqli_stmt_bind_result($suitestmt, $ID, $suite_size, $name, $description, $price);

                //display the reservated suite
                while(mysqli_stmt_fetch($suitestmt)){
                echo "<h2>Reservated Suite</h2><br>";
                echo "<p>Size:</p>" . $suite_size . ".<br>";
                echo "<p>Name:</p>" . $name . ".<br>";
                echo "<p>Discription:</p>" . $description . ".<br>";
                echo "<p>Price:</p>" . $price . ".<br>";
                }

                mysqli_stmt_close($suitestmt);
            ?>            
        </div>
        <div>
            <?php
                $usersql = "SELECT ID, firstname, lastname, email FROM user WHERE ID=$userID";
                $userstmt = mysqli_prepare($conn, $usersql) or die(mysqli_error($conn));
                mysqli_stmt_execute($userstmt) or die('error');
                mysqli_stmt_bind_result($userstmt, $ID, $firstname, $lastname, $email);

                //display the account reservating the suite
                while(mysqli_stmt_fetch($userstmt)){
                echo "<h2>Reservating User</h2>";
                echo "<p>First name:</p>" . $firstname . ".";
                echo "<p>Last name:</p>" . $lastname . ".";
                echo "<p>email:</p>" . $email . ".";
                }
                
                $userEmail = $email;
                mysqli_stmt_close($userstmt);
            ?>
        </div>
        <div>
            <?php
                //Edit and Delete buttons
                //echo "<a href='edit_reservation.php?id=$_GET[id]'>Edit</a><br>";
                echo "<button onclick=document.getElementById('editbtnpress').style.display='block'>Edit</button><br>";
                echo "<button onclick=document.getElementById('delbtnpress').style.display='block'>Delete</button><br>";
                echo "<a href=../../pages/adminpanel.php><- Return to the Adminpanel</a><br>"
            ?>
        </div>
        <!-- Pop-up confirmation for deletion, using the Modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp -->
        <div id="delbtnpress" class="modal">
            <span onclick="document.getElementById('delbtnpress').style.display='none'" class="close" title="Close Modal">×</span>
            <form class="modal-content" action="/action_page.php">
                <div class="container">
                    <h1>Delete Confirmation</h1>
                    <p>Are you sure you want to delete the reservation?</p>
                    <p>WARNING: MAKE SURE TO SEND AN EMAIL TO THE USER BEFORE DELETING THE RESERVATION IT WILL BE GONE FOREVER!</p>
                    <div class="clearfix">
                        <?php 
                            echo "<a href=delete_reservation.php?id=" . $_GET['id'] . "class=deletebtn>Delete</a>";
                            echo "<a href=mailto:$userEmail?subject=Cancellation%20of%20reservation>Send Email</a>"; 
                        ?>
                        <button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="cancelbtn">Cancel</button>
                        <!--<button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="deletebtn">Delete</button>-->
                    </div>
                </div>
            </form>
        </div>
        <!-- Pop-up confirmation for edit, using the Modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp -->
        <div id="editbtnpress" class="modal">
            <span onclick="document.getElementById('editbtnpress').style.display='none'" class="close" title="Close Modal">×</span>
            <form class="modal-content" action="/action_page.php">
                <div class="container">
                    <h1>Edit options</h1>
                    <p>What do you want to edit?</p>
                    <p>WARNING: CHANGES CAN NOT BE UNDONE!</p>
                    <div class="clearfix">
                        <?php 
                            echo "<a href=edit_reservation_date.php?id=$reservationid>Date of reservation </a>";
                            echo "<a href=edit_reservation_user.php?id=$userID>Reservating User </a>";
                            echo "<a href=edit_reservation_suite.php?id=$suiteID>Reservated Room </a>"; 
                        ?>
                        <button type="button" onclick="document.getElementById('editbtnpress').style.display='none'" class="cancelbtn">Cancel</button>
                        <!--<button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="deletebtn">Delete</button>-->
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>