<?php
//Start a session
session_start();

//Check if user is logged
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    //Send user to index.php
    header('location: ../../index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Adminpanel</title>
    <meta charset="UTF-8">
    <!-- CSS -->
      <link rel="stylesheet" href="../assets/styles/adminpanel.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
      <link rel="stylesheet" href="../assets/styles/index.css">
  </head>
  <body>
    <?php
      require_once '../../controllers/database/dbconnect.php';

      $sql = "DELETE FROM contact_message WHERE ID='$_GET[id]'";
      $stmt = mysqli_prepare($conn, $sql) or die(mysqli_error($conn));
      mysqli_stmt_execute($stmt) or die("Something went wrong, please try again later or contact support.");
      echo "<p>Deletion successful, please wait to be redirected.</p>";
      header("refresh:2 url=../../pages/adminpanel.php");
    ?>
  </body>
</html>