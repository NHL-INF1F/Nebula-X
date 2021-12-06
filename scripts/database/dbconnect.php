<?php
    // Connect to server (localhost server)
    $conn = mysqli_connect("127.0.0.1", "nebulax", "P@ssw0rd");
    // Test the connection
    if(!$conn)
    {
        DIE("Could not connect: " . mysqli_connect_error());
    }
            
    // Select the database for Nebula-X
    $db = mysqli_select_db($conn, "nebulax");
    // Assure the database exists
	if(!$db)
	{
		DIE('Can\'t find database');
	}
?>