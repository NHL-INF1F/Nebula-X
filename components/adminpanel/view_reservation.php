<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../assets/styles/adminpanel.css">
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
        </script>
    </head>
    <body>
        <?php
                // Reservation show Reservated suite, Start/End dates, Account details of person reservating the suite, edit button.
                $reserv = "SELECT FROM reservations WHERE id='$_GET[id]'";
        ?>
        <div>
            <h1>Reservation Details</h1>
        </div>
        <div>
            <a href="../../pages/adminpanel.php"><- Return to the Adminpanel</a>
        </div>
        <div>
            <?php
                //display the reservated suite
                echo "<h2>Reservated Suite</h2>";
                echo "<p>Size:</p>";
                echo "<p>Name:</p>";
                echo "<p>Discription:</p>";
                echo "<p>Price:</p>";
                echo "<p>Reservated from:</p>";
                echo "<p>Reservated until:</p>";
            ?>            
        </div>
        <div>
            <?php
                //display the account reservating the suite
                echo "<h2>Reservating User</h2>";
                echo "<p>First name:</p>";
                echo "<p>Last name:</p>";
                echo "<p>email:</p>";
            ?>
        </div>
        <div>
            <?php
                //Edit and Delete buttons
                echo "<a href='view_reservation.php'>Edit</a>";
                echo "<button onclick=document.getElementById('delbtnpress').style.display='block'>Delete</button>";
            ?>
        </div>
        <!-- Pop-up confirmation for deletion, using the Modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp -->
        <div id="delbtnpress" class="modal">
            <span onclick="document.getElementById('delbtnpress').style.display='none'" class="close" title="Close Modal">×</span>
            <form class="modal-content" action="/action_page.php">
                <div class="container">
                    <h1>Delete Confirmation</h1>
                    <p>Are you sure you want to delete the reservation?</p>
                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="deletebtn">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>