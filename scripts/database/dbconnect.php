<?php
//Require ENV
require_once('env.php');

// Connect to server (localhost server)
$conn = mysqli_connect($_ENV["hostname"], $_ENV["username"], $_ENV["password"], $_ENV["database"]);

// Test the connection
if (!$conn) {
    die("Could not connect: " . mysqli_connect_error());
}
