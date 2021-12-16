<?php
//Start a session
session_start();

//Include database connections
require_once('../controllers/database/dbconnect.php');

//Define global variable(s)
$error = array();

//If form has been succesfull submitted
if (isset($_SESSION['succesMessage'])) {
    echo $_SESSION['succesMessage'];
    $_SESSION['succesMessage'] = '';
}

/**
 * Function checkContactFields.
 * Function to check if fields are correct and not empty.
 * Display Error message if needed.
 * @param string    $email  Filled in email
 * @param string    $name  Filled in name
 * @param string    $message  Filled in message
 * @param string    $subject  Filled in subject
 * @param array     $error  Array with errors
 * @return string/boolean  $error  False or error message
 */
function checkContactFields($email, $name, $message, $subject)
{
    //Call global variable(s)
    global $error;

    if (!$email && empty($email)) {
        $error[] = 'Email is not correct';
    }
    if (!$name && empty($name)) {
        $error[] = 'Name may not be empty';
    }
    if (!$message && empty($message)) {
        $error[] = 'Message may not be empty';
    }
    if (!$subject && empty($subject)) {
        $error[] = 'Subject may not be empty';
    }

    if (strlen($email) > 255) {
        $error[] = 'Email is too long';
    }
    if (strlen($name) > 255) {
        $error[] = 'Name is too long';
    }
    if (strlen($message) > 255) {
        $error[] = 'Message is too long';
    }
    if (strlen($subject) > 50) {
        $error[] = 'Subject is too long';
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
    $email      = filter_input(INPUT_POST, 'email',     FILTER_VALIDATE_EMAIL);
    $name       = filter_input(INPUT_POST, 'name',      FILTER_SANITIZE_SPECIAL_CHARS);
    $message    = filter_input(INPUT_POST, 'message',   FILTER_SANITIZE_SPECIAL_CHARS);
    $subject    = filter_input(INPUT_POST, 'subject',   FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkContactFields($email, $name, $message, $subject)) {
        //SQL Query for inserting contact messages with values
        $query = "INSERT INTO contact_message (name, email, subject, message) VALUES (?,?,?,?)";

        //Prpeparing SQL Query with database connection
        $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

        //Binding params into ? fields
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message) or die('Binding params went wrong');

        //Executing statement
        mysqli_stmt_execute($stmt) or die('<br>message');

        //Close the statement
        mysqli_stmt_close($stmt);
        //Close the connection
        mysqli_close($conn);

        //Set succes message
        $_SESSION['succesMessage'] = 'Message has been send to the admin';

        //Refresh page, prefent spam
        header("Refresh:0");
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
    <?php
    foreach($error as $message) {
        echo $message . '<br>';
    }
    ?>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label for="name">Name</label>
            <input type="text" placeholder="John" name="name" id="name" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['name']);} if(isset($_SESSION['firstname'])) {echo $_SESSION['firstname'];} ?>">
        </div>
        <div>
            <label for="subject">Subject</label>
            <input type="text" placeholder="Problem" name="subject" id="subject" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['subject']);} ?>">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" placeholder="youremail@domain.com" name="email" id="email" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['email']);} if(isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>">
        </div>
        <div>
            <label for="message">Message</label>
            <textarea placeholder="I have a problem" name="message" id="message"><?php if (isset($_POST['submit'])) {echo htmlentities($_POST['message']);} ?></textarea>
        </div>
        <div>
            <input type="submit" name="submit" value="submit">
        </div>
    </form>
</body>

</html>