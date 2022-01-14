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
 * @param string $email Filled in email
 * @param string $firstname Filled in firstname
 * @param string $lastname Filled in lastname
 * @param string $password Filled in password
 * @param string $password2 Filled in password2
 * @param array $error Array with errors
 * @return string/boolean  $error  False or error message
 */
function checkRegisterFields($email, $password) {
    //Call global variable(s)
    global $error;

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$email && empty($email)) {
        $error[] = 'Email is not correct';
    }
    if (!$password && empty($password)) {
        $error[] = 'Password may not be empty';
    }
    if (strlen($email) > 255) {
        $error[] = 'Email is too long';
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

//Check if submitted
if (isset($_POST['submit'])) {
    //Submitted form data validation
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkRegisterFields($email, $password)) {
        //SQL query to select all from user where the email is ...
        $query = "SELECT * FROM user WHERE email = ?";

        //Prpeparing SQL Query with database connection
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            $_SESSION['error'] = "database_error";
            header("location: error.php");
        }

        //Binding params into ? fields
        if(!mysqli_stmt_bind_param($stmt, "s", $email)){
            $_SESSION['error'] = "database_error";
            header("location: error.php");
        }

        //Executing statement
        if(!mysqli_stmt_execute($stmt)){
            $_SESSION['error'] = "database_error";
            header("location: error.php");
        }

        //Bind the STMT results(sql statement) to variables
        mysqli_stmt_bind_result($stmt, $ID, $firstname, $lastname, $email2, $password2, $role);

        //Fetch STMT data
        while (mysqli_stmt_fetch($stmt)) {
        }

        //Check if no result has been found
        if (mysqli_stmt_num_rows($stmt) > 0) {
            //Check password
            if (password_verify($password, $password2)) {
                //Put value's in session
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['email'] = $email2;
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $ID;

                //Close the statement and connection
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                header('location: ../index.php');
                exit();
            } else {
                $error[] = 'Login credentials are incorrect';
            }
        } else {
            $error[] = 'No user has been found with that email';
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
    <title>Login</title>

    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/f9ece565b9.js" crossorigin="anonymous"></script>

    <!-- Prevent resubmitting on page refresh -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <!-- script for closing divs -->
    <script type="text/javascript" src="../assets/scripts/slider.js"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
<div class="container-fluid d-flex align-items-center min-vh-100">
    <div class="row w-75 h-100 hBox">
        <?php
        if (isset($_POST['submit']) && !empty($error) || isset($_SESSION['redirected']) && !empty($_SESSION['redirected'])) {
            ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-danger text-black fw-bold p-4 rounded-0" role="alert">
                    <ul>
                        <?php
                        foreach ($error as $errorMsg) {
                            echo '<li>' . $errorMsg . '</li>';
                        }
                        if (isset($_SESSION['redirected']) && !empty($_SESSION['redirected'])) {
                            echo '<li>' . $_SESSION['redirected'] . '</li>';
                            $_SESSION['redirected'] = '';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        if (isset($_SESSION['registered']) && !empty($_SESSION['registered'])) {
            ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-success text-black fw-bold p-4 rounded-0" role="alert">
                    <ul>
                        <?php
                        echo '<li>' . $_SESSION['registered'] . '</li>';
                        $_SESSION['registered'] = '';
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-8 p-4 bg-white order-md-1 order-2">
            <h1><?php echo $message['login'] ?></h1>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-1">
                    <label for="email" class="form-label"><?php echo $message['email'] ?></label>
                    <input maxlength="255" required type="email" class="form-control" placeholder="youremail@domain.com"
                           name="email" id="email" value="<?php if (isset($_POST['submit'])) {
                        echo htmlentities($_POST['email']);
                    } ?>">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label"><?php echo $message['password'] ?></label>
                    <input maxlength="255" required type="password" class="form-control" placeholder=<?php echo $message['password1'] ?>
                           name="password" id="password" value="<?php if (isset($_POST['submit'])) {
                        echo htmlentities($_POST['password']);
                    } ?>">
                </div>
                <div class="buttonBox">
                    <input class="button" type="submit" name="submit" value=<?php echo $message['login'] ?>>
                </div>
            </form>
        </div>

        <div class="col-md-4 p-4 seeThroughBox order-md-2 order-1">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-white"><?php echo $message['notamember'] ?></h1>
                    <p class="text-white"><?php echo $message['registerinfo'] ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="buttonBox">
                        <a href="register.php">
                            <input class="button" type="submit" name="register" value="<?php echo $message['register'] ?>">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once("../components/footer.php"); ?>
</body>

</html>