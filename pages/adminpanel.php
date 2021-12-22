<?php
//Start a session
session_start();

//Check if user is logged
if (isset($_SESSION['email'])) {
    //Send user to index.php
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/styles/adminpanel.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
        <link rel="stylesheet" href="../assets/styles/index.css">

    </head>
    <body>
        <?php
            include('../controllers/database/dbconnect.php');
            require_once('../components/header.php');
            require('../components/translation/en.php');
        ?>
        <div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
        <div class="row w-75 h-100" style="height: 500px; margin: 0 auto;">
            <div class="col-md-6 p-4 bg-white order-md-1 order-2">
                <div>
                <h2>Reservations</h2>        
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
            </div>
        
        
        
        
        
        <div  class="col-md-6 p-4 bg-white order-md-1 order-2">
        <h2>Contact Messages</h2>
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