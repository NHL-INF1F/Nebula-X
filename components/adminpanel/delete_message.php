<?php
  require_once '../../controllers/database/dbconnect.php';

  $sql = "DELETE FROM contact_message WHERE ID='$_GET[id]'";

  if(mysqli_query($conn, $sql)){
    echo "Deletion Successful, please wait to be redirected.";
    header("refresh url=../../pages/adminpanel.php");
  }
  else {
    echo "Something went wrong.";
  }
?>