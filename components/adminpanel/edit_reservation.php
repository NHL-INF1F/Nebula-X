<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel</title>
</head>
<body>
    <?php
        include('../../controllers/database/dbconnect.php');

        
    ?>
    <div>
        <h1>Reservation details</h1>
    </div>
    <div>
        <form>
            <label> User: </label>
            <select> <?php  ?> </select>
            <label> Suite: </label>
            <select> <?php  ?> </select>
            <input type= 'date'> </input>
            <input type= 'date'> </input>
        </form>
    </div>


    <div>
        <a href=../../pages/adminpanel.php><- Back to the admin panel</a>
    </div>
    <?php

    ?>
</body>
</html>