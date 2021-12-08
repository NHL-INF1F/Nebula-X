<?php
    $conn= mysqli_connect("localhost","root","")
    or die("Can't connect to server");
    if($conn){
        echo "Connection OK <br>";
    }
    
    mysqli_select_db($conn, "nebulax")
    or die("Can't find it my jigga <br>");

    
?>