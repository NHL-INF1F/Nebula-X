<?php
//Require ENV
require_once('env.php');

// Connect to server (localhost server)
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// Test the connection
if (!$conn) {
    die("Could not connect: " . mysqli_connect_error());
}