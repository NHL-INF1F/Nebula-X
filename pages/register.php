<?php
//Start a session
session_start();

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
function checkRegisterFields($email, $firstname, $lastname, $password, $password2)
{
    //Call global variable(s)
    global $error;

    if (!$email && empty($email)) {
        $error[] = 'Email is not correct';
    }
    if (!$firstname && empty($firstname)) {
        $error[] = 'Firstname may not be empty';
    }
    if (!$lastname && empty($lastname)) {
        $error[] = 'Lastname may not be empty';
    }
    if (!$password && empty($password)) {
        $error[] = 'Password may not be empty';
    }
    if (!$password2 && empty($password2)) {
        $error[] = 'Password repeat may not be empty';
    }
    if ($password != $password2) {
        $error[] = 'Passwords do not match';
    }
    if (strlen($email) > 255) {
        $error[] = 'Email is too long';
    }
    if (strlen($firstname) > 255) {
        $error[] = 'Firstname is too long';
    }
    if (strlen($lastname) > 255) {
        $error[] = 'Lastname is too long';
    }
    if (strlen($password) > 255) {
        $error[] = 'Password is too long';
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
 * @param   object          $conn   Database connection
 * @param   string          $email  Filled in email
 * @return  string/boolean  $error  False or error message
 */
function checkUserInDataBase($conn, $email)
{
    //Call global variable(s)
    global $error;

    //SQL Query for selecting all users where an email is in DB
    $query = "SELECT * FROM user WHERE email = ?";

    //Prpeparing SQL Query with database connection
    $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

    //Binding params into ? fields
    mysqli_stmt_bind_param($stmt, "s", $email) or die('niet goed');

    //Executing statement
    mysqli_stmt_execute($stmt) or die('<br>message');

    //Bind the STMT results(sql statement) to variables
    mysqli_stmt_bind_result($stmt, $ID, $one, $two, $three, $four, $five);

    //Fetch STMT data
    while (mysqli_stmt_fetch($stmt)) {
    }

    //Check if a result has been found with number of rows
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $error[] = 'This email is already in use, try another email.';
        return $error;
    } else {
        return false;
    }

    //Close the statement
    mysqli_stmt_close($stmt);
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
            $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

            //Binding params into ? fields
            mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $password, $role) or die('niet goed');

            //Executing statement
            mysqli_stmt_execute($stmt) or die('<br>message');

            //Close the statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            //Set user message
            $_SESSION['registered'] = 'Account registered, you may now log in.';

            //Send user to index.php
            header('location: login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
    <link href="../assets/styles/register.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
        <div class="row w-75 h-100" style="height: 500px; margin: 0 auto;">
            <?php
            if (isset($_POST['submit']) && !empty($error)) {
            ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-danger text-black fw-bold p-4 rounded-0" role="alert">
                    <ul>
                        <?php
                        foreach($error as $message) {
                            echo '<li>' . $message . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="col-md-8 p-4 bg-white order-md-1 order-2">
                <h1>REGISTER</h1>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-1">
                        <label for="email" class="form-label">Email address</label>
                        <input required type="email" class="form-control" placeholder="youremail@domain.com" name="email" id="email" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['email']);} ?>" aria-describedby="emailHelp">                    </div>
                    <div class="mb-1">
                        <label for="firstname" class="form-label">Firstname</label>
                        <input required type="text" class="form-control" placeholder="John" name="firstname" id="firstname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['firstname']);} ?>">
                    </div>
                    <div class="mb-1">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input required type="text" class="form-control" placeholder="Doo" name="lastname" id="lastname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['lastname']);} ?>">
                    </div>
                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input required type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password']);} ?>">
                    </div>
                    <div class="mb-4">
                        <label for="password2" class="form-label">Password repeat</label>
                        <input required type="password" class="form-control" placeholder="Password" name="password2" id="password2" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password2']);} ?>">
                    </div>
                    <div class="buttonBox">
                        <input class="button" type="submit" name="submit" value="register">
                    </div>  
                </form>
            </div>

            <div class="col-md-4 p-4 seeThroughBox order-md-2 order-1">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-white">ALREADY A MEMBER?</h1>
                        <p class="text-white">If you are already a user you can use the button below to login to your account</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="buttonBox">
                            <a href="login.php">
                                <input class="button" type="submit" name="login" value="login">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>