<?php session_start(); 

//Translation
require_once ('../components/translation/en.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nebula-X</title>
    <!--<link href="../assets/styles/suits.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>
    <link href="../assets/styles/bookingconfirm.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/header-fixed.css">
</head>
<body>

<?php
require_once("../components/header.php");
if(!isset($_SESSION['error'])){
    header('location: ../index.php');
}
$errorMessage = $message[$_SESSION['error']];

unset($_SESSION['error']);
?>

<div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
    <main class="row w-75 h-100 mx-auto my-0">
        <div class="offset-3 col-6 p-4 bg-white text-center">
            <h1><?php echo $message['error_title'] ?></h1>

            <div class='error-content'>
                <?php echo $errorMessage. "<br>" . $message['error_contact_message'];?>
            </div>
            <div class="row">
                <div class="col-xxl-6 col-12 mb-4 mb-xxl-0 buttonBox">
                    <a href="../index.php"><input class="ps-3 button" type="button" name="return" value="<?php echo $message['error_back'] ?>"></a>
                </div>
                <div class="col-xxl-6  col-12 buttonBox">
                    <a href="contact.php"><input class="ps-3 button" type="button" name="contact" value="<?php echo $message['error_contact'] ?>"></a>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>