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
    </head>
    <body>
        <!-- the modal -->
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
                    $reservationstmt = mysqli_prepare($conn, $reservationsql) or die(mysqli_error($conn));
                    mysqli_stmt_execute($reservationstmt) or die("Error");
                    mysqli_stmt_bind_result($reservationstmt, $id, $user_id, $suite_id, $date_from, $date_to);

                    // while loop to echo the query results in a table
                    
                    while (mysqli_stmt_fetch($reservationstmt)) {
                        echo "<tr>
                            <td>" . $id ."</td>
                            <td>" . $user_id ."</td>
                            <td>" . $suite_id ."</td>
                            <td>" . $date_from ."</td>
                            <td>" . $date_to . "</td>
                            <td><a href=../components/adminpanel/view_reservation.php?id=" . $id . ">Details</a></td>
                        </tr>";
                    }
                    
                ?>
            </table>
            <?php
                mysqli_stmt_close($reservationstmt);
            ?>
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
                    $contactstmt = mysqli_prepare($conn, $contactsql) or die(mysqli_error($conn));
                    mysqli_stmt_execute($contactstmt) or die("Error");
                    mysqli_stmt_bind_result($contactstmt, $id, $name, $email, $subject, $message);
                    
                    // while loop to echo the query results in a table
                    while(mysqli_stmt_fetch($contactstmt)) {
                        echo "<tr>
                            <td>" . $id ."</td>
                            <td>" . $name ."</td>
                            <td>" . $email ."</td>
                            <td>" . $subject . "</td>
                            <td>" . $message ."</td>
                            <td> <a href=mailto:$email?subject=Response%20$subject>Send Mail</a></td>
                            <td> <a href=../components/adminpanel/delete_message.php?id=". $id .">Delete</a></td>
                        </tr>";
                    }
                ?>
            </table>
            <?php
                // close the statement
                mysqli_stmt_close($contactstmt);
                mysqli_close($conn)
            ?>
        </div>
    </body>
</html>