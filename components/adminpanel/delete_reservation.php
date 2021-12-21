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

      $sql = "DELETE FROM reservation WHERE ID='$_GET[id]'";
      $stmt = mysqli_prepare($conn, $sql) or die(mysqli_error($conn));
      mysqli_stmt_execute($stmt) or die("Something went wrong, please try again later or contact support.");
      echo "<p>Deletion successful, please wait to be redirected.</p>";
      header("refresh:2 url=../../pages/adminpanel.php");
    ?>
  </body>
</html>