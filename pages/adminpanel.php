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
            // Select queries
            //$reservationview = mysqli_query("SELECT * FROM reservation", $conn);
            //$contactview = mysqli_query("SELECT * FROM contact_messsage", $conn);
            //$Suites = mysqli_query("SELECT * FROM suite", $conn);
            //$USERS = mysqli_query("SELECT * FROM user", $conn); 
        ?>
        <div>
            <h2>Reservations</h2>
        </div>
        <div>        
            <?php
                echo "<table id=tablereserv>";
                echo "<tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name user</th>
                    <th>Suite ID</th>
                    <th>Suite Name</th>
                    <th>Start date</th>
                    <th>End date</th>
                </tr>";
                // here comes code for the rest of the table
                echo "</table>";
            ?>
        </div>
        <div>
            <h2>Contact Messages</h2>
        </div>
        <div>        
            <?php
                echo "<table id=tablecontact>";
                echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>";
                // here comes code for the rest of the table
                echo "</table>";
            ?>
        </div>
    </body>
</html>