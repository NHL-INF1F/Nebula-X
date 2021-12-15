<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../assets/styles/adminpanel.css">

        <!-- connect to database -->
        <?php
            include('../controllers/database/dbconnect.php');
        ?>
        <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>

    </head>
    <body>
        <div>
            <h2>Reservations</h2>
        </div>
        <div>        
            <table id=tablereserv>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Suite ID</th>
                    <th>Start date</th>
                    <th>End date</th>
                </tr>
                <?php
                    // run query from database
                    $reservationsql = "SELECT * from reservation";
                    $reservationresult = $conn-> query($reservationsql);

                    // while loop to echo the query results in a table
                    if ($reservationresult-> num_rows > 0) {
                        while ($reservationrow = $reservationresult-> fetch_assoc()) {
                            echo "<tr>
                                <td>" . $reservationrow["ID"] ."</td>
                                <td>" . $reservationrow["USER_ID"] ."</td>
                                <td>" . $reservationrow["SUITE_ID"] ."</td>
                                <td>" . $reservationrow["date_from"] ."</td>
                                <td>" . $reservationrow["date_to"] . "</td>
                            </tr>";
                        }
                    }
                ?>
            </table>

        </div>
        
        <div>
            <h2>Contact Messages</h2>
        </div>
        <div>
            <table id=tablecontact>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th></th>
                </tr>
                
                <?php
                    // run query from database
                    $contactsql = "SELECT * from contact_message";
                    $contactresult = $conn-> query($contactsql);
                    
                    // while loop to echo the query results in a table
                    if ($contactresult-> num_rows > 0) {
                        while ($contactrow = $contactresult-> fetch_assoc()) {
                            echo "<tr>
                                <td>" . $contactrow["ID"] ."</td>
                                <td>" . $contactrow["name"] ."</td>
                                <td>" . $contactrow["email"] ."</td>
                                <td>" . $contactrow["subject"] . "</td>
                                <td>" . $contactrow["message"] ."</td>
                                <td> <a href=mailto:$contactrow[email]?subject=Response%20$contactrow[subject]>Send Mail</a></td>
                                <td><button onclick=document.getElementById('id01').style.display='block'>Delete</button>
                                
                                </td>
                            </tr>";
                        }
                    }
                ?>
            </table>
            <div>
                <p id=test></p>
            </div>
        </div>
<!-- the modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
  <form class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Delete Message</h1>
      <p>Are you sure you want to delete the message?</p>
    
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
      </div>
    </div>
  </form>
</div>
    </body>
</html>