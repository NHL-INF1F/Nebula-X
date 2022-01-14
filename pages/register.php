<?php
//Start a session
session_start();

//Translation
require_once ('../components/translation/en.php');

//Check if user is logged
if (isset($_SESSION['email'])) {
    //Send user to index.php
    header('location: ../index.php');
}
//Include database connections
require_once('../controllers/database/dbconnect.php');

//Define global variable(s)
$error = array();

/**
 * Function checkRegisterFields.
 * Function to check if fields are correct and not empty.
 * Display Error message if needed.
 * @param string    $email  Filled in email
 * @param string    $firstname  Filled in firstname
 * @param string    $lastname  Filled in lastname
 * @param string    $password  Filled in password
 * @param string    $password2  Filled in password2
 * @param array     $error  Array with errors
 * @return string/boolean  $error  False or error message
 */
function checkRegisterFields(string $email, string $firstname, string $lastname, string $password, string $password2) {
    //Call global variable(s)
    global $error;
    global $message;

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$email && empty($email)) {
        $error[] = $message['emailnotcorrect'];
    }
    if (!$firstname && empty($firstname)) {
        $error[] = $message['firstnameempty'];
    }
    if (!$lastname && empty($lastname)) {
        $error[] = $message['lastnameempty'];
    }
    if (!$password && empty($password)) {
        $error[] = $message['passwordempty'];
    }
    if (!$password2 && empty($password2)) {
        $error[] = $message['passwordrepeat'];
    }
    if ($password != $password2) {
        $error[] = $message['passwordnotmatch'];
    }
    if (strlen($email) > 255) {
        $error[] = $message['emailtoolong'];
    }
    if (strlen($firstname) > 255) {
        $error[] = $message['firstnametoolong'];
    }
    if (strlen($lastname) > 255) {
        $error[] = $message['lastnametoolong'];
    }
    if (strlen($password) > 255) {
        $error[] = $message['passwordtoolong'];
    }

    if (empty($error)) {
        return false;
    } else {
        return $error;
    }
}

/**
 * Function checkUserInDatabase
 * Function to check if user already exists in database
 * Display Error message if needed.
 * @param   mysqli          $conn   Database connection
 * @param   string          $email  Filled in email
 * @return  string/boolean  $error  False or error message
 */
function checkUserInDataBase(mysqli $conn, string $email) {
    //Call global variable(s)
    global $error;
    global $message;

    //SQL Query for selecting all users where an email is in DB
    $query = "SELECT * FROM user WHERE email = ?";

    //Prpeparing SQL Query with database connection
    $stmt = mysqli_prepare($conn, $query);
    if(!$stmt){
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Binding params into ? fields
    if(!mysqli_stmt_bind_param($stmt, "s", $email)){
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    }

    //Executing statement
    if(mysqli_stmt_execute($stmt)){
        $_SESSION['error'] = "database_error";
        header("location: error.php");
    };

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $ID, $one, $two, $three, $four, $five);

    //Store STMT data
    mysqli_stmt_store_result($stmt);

    //Check if a result has been found with number of rows
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        $error[] = $message['emailinuse'];
        return $error;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

//Check if submitted
if (isset($_POST['submit'])) {
    //Submitted form data validation
    $email      = filter_input(INPUT_POST, 'email',     FILTER_VALIDATE_EMAIL);
    $firstname  = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname   = filter_input(INPUT_POST, 'lastname',  FILTER_SANITIZE_SPECIAL_CHARS);
    $password   = filter_input(INPUT_POST, 'password',  FILTER_SANITIZE_SPECIAL_CHARS);
    $password2  = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkRegisterFields($email, $firstname, $lastname, $password, $password2)) {
        if (!checkUserInDataBase($conn, $email)) {
            //Hash the password before putting in database
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Define standard role, user
            $role = 'user';

            //SQL Query for inserting into user table
            $query = "INSERT INTO user (firstname, lastname, email, password, role) VALUES (?,?,?,?,?)";

            //Prpeparing SQL Query with database connection
            $stmt = mysqli_prepare($conn, $query);
            if(!$stmt){
                $_SESSION['error'] = "database_error";
                header("location: error.php");
            }

            //Binding params into ? fields
            if(!mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $password, $role)){
                $_SESSION['error'] = "database_error";
                header("location: error.php");
            }

            //Executing statement
            if(!mysqli_stmt_execute($stmt)){
                $_SESSION['error'] = "database_error";
                header("location: error.php");
            }

            //Close the statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            //Set user message
            $_SESSION['registered'] = $message['accountregister'];

            //Send user to index.php
            header('location: login.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "../components/translation/en.php"; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- Prevent resubmitting on page refresh -->
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>

   <!-- script for closing divs -->
   <script type="text/javascript" src="../assets/scripts/slider.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/registerLoginContact.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/header-fixed.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">
</head>

<body>
    <?php
    require_once('../components/header.php');
    ?>
    <div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
        <main class="row w-75 h-100 hBox">
            <?php
            if (isset($_POST['submit']) && !empty($error)) {
            ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-danger text-black fw-bold p-4 rounded-0" role="alert">
                    <ul>
                        <?php
                        foreach($error as $errorMsg) {
                            echo '<li>' . $errorMsg . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="col-md-8 p-4 bg-white order-md-1 order-2">
                <h1><?php echo $message['register']; ?></h1>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-1">
                        <label for="email" class="form-label"><?php echo $message['email'] ?></label>
                        <input maxlength="255" required type="email" class="form-control" placeholder="youremail@domain.com" name="email" id="email" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['email']);} ?>" aria-describedby="emailHelp">                    </div>
                    <div class="mb-1">
                        <label for="firstname" class="form-label"><?php echo $message['firstname'] ?></label>
                        <input maxlength="255" required type="text" class="form-control" placeholder="<?php echo $message['firstname'] ?>" name="firstname" id="firstname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['firstname']);} ?>">
                    </div>
                    <div class="mb-1">
                        <label for="lastname" class="form-label"><?php echo $message['lastname'] ?></label>
                        <input maxlength="255" required type="text" class="form-control" placeholder="<?php echo $message['lastname'] ?>" name="lastname" id="lastname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['lastname']);} ?>">
                    </div>
                    <div class="mb-1">
                        <label for="password" class="form-label"><?php echo $message['password'] ?></label>
                        <input maxlength="255" required type="password" class="form-control" placeholder="<?php echo $message['password1'] ?>" name="password" id="password" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password']);} ?>">
                    </div>
                    <div class="mb-4">
                        <label for="password2" class="form-label"><?php echo $message['password2'] ?></label>
                        <input maxlength="255" required type="password" class="form-control" placeholder="<?php echo $message['password1'] ?>" name="password2" id="password2" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password2']);} ?>">
                    </div>
                    <div class="buttonBox">
                        <input class="button" type="submit" name="submit" value=<?php echo $message['registerbutton'] ?>>
                    </div>  
                </form>
            </div>

            <div class="col-md-4 p-4 seeThroughBox order-md-2 order-1">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-white"><?php echo $message['alreadymember'] ?></h1>
                        <p class="text-white"><?php echo $message['logininfo'] ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="buttonBox">
                            <a href="login.php">
                                <input class="button" type="submit" name="login" value=<?php echo $message['login'] ?>>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php 
        require_once("../components/footer.php"); ?>
</body>

</html>