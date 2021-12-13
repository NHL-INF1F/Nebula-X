<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">
        <link href="../assets/styles/adminpanel.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <h1>Admin panel</h1>
        </div>
        <?php
            //Require ENV
            require_once('../controllers/database/env.php');

            // Connect to server (localhost server)
            $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

            // Test the connection
            if (!$conn) {
                die("Could not connect: " . mysqli_connect_error());
            }
        ?>
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
                    <th>Message</th>
                    <th>.</th>
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
                                <td>" . $contactrow["message"] ."</td>
                                <td> <a href=mailto:$contactrow[email]>Respond</a></td>
                            </tr>";
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>