<!DOCTYPE html>
<html>
  <head>
    <title>Adminpanel</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/styles/adminpanel.css">
  </head>
  <body>
    <?php
      require_once '../../controllers/database/dbconnect.php';

      $sql = "DELETE FROM contact_message WHERE ID='$_GET[id]'";

      if(mysqli_query($conn, $sql)){
        echo "Deletion Successful, please wait to be redirected.";
        header("refresh url=../../pages/adminpanel.php");
      }
      else {
        echo "Something went wrong, please try again later or contact support.";
        header("refresh url=../../pages/adminpanel.php");
      }
    ?>
  </body>
</html>