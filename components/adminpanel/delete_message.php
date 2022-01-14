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
<html lang="en">
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

      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

      $sql = "DELETE FROM contact_message WHERE ID=?";;
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id);
      if(!$stmt){
          $_SESSION['error'] = "database_error";
          header("location: error.php");
      }
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error'] = "message_delete_error";
        header("location: error.php");
      }

      header("location: ../../pages/adminpanel.php");
    ?>
  </body>
</html>