<?php
//Include database connections
require_once('../controllers/database/dbconnect.php');

//Define variables
$error = array();

/**
 * Function checkRegisterFields
 * 
 */
function checkRegisterFields($email, $firstname, $lastname, $password, $password2, $error)
{
    if (!$email && empty($email)) {
        $error[] = 'Email is not correct';
    }
    if (!$firstname && empty($firstname)) {
        $error[] = 'Firstname may not be empty';
    }
    if (!$lastname && empty($lastname)) {
        $error[] = 'Lastname is not correct';
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

    if (empty($error)) {
        return true;
    } else {
        echo '<div class="errorBox">';
        foreach ($error as $value) {
            echo $value . '<br>';
        }
        echo '</div>';
        return false;
    }
}

function checkUserInDataBase($conn) {

    // $query = "SELECT * FROM user";

    // $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

    // mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $password, $test) or die('niet goed');

    // mysqli_stmt_execute($stmt) or die('<br>message');

    // $test = mysqli_stmt_get_result($stmt);

    // $test2 = mysqli_num_rows($test);

    // echo $test2;
}

//Check if submitted
if (isset($_POST['submit'])) {
    //Submitted form data
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (checkRegisterFields($email, $firstname, $lastname, $password, $password2, $error)) {
        checkUserInDataBase($conn);


        // //Hash the password before putting in database
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // //Define standard role, user
        // $test = 'user';
        // define('ROLE', 'user');

        // $query = "INSERT INTO user (firstname, lastname, email, password, role) VALUES (?,?,?,?,?)";

        // $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

        // mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $password, $test) or die('niet goed');

        // mysqli_stmt_execute($stmt) or die('<br>message');

        // //Close the statement
        // mysqli_stmt_close($stmt);
        // mysqli_close($conn);

        // header('location: index.php');
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
</head>

<body>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" placeholder="youremail@domain.com" name="email" id="email" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['email']);} ?>">
        </div>
        <div>
            <label for="firstname">Firstname</label>
            <input type="text" placeholder="John" name="firstname" id="firstname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['firstname']);} ?>">
        </div>
        <div>
            <label for="lastname">Lastname</label>
            <input type="text" placeholder="Doo" name="lastname" id="lastname" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['lastname']);} ?>">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password']);} ?>">
        </div>
        <div>
            <label for="password2">Repeat password</label>
            <input type="password" placeholder="Password" name="password2" id="password2" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['password2']);} ?>">
        </div>
        <div>
            <input type="submit" name="submit" value="submit">
        </div>
    </form>
</body>

</html>