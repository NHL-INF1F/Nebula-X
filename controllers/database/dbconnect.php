<?php
//Require ENV
require_once('env.php');

// Connect to server (localhost server)
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// Test the connection
if (!$conn) {
    $_SESSION['error'] = "database_connect_error";
    header("location: error.php");
}