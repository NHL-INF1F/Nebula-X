<?php
//Start a session
session_start();

//Include database connections
require_once('../controllers/database/dbconnect.php');

//Include translations
require_once('../components/translation/en.php');

//Define global variable(s)
$error = array();

/**
 * Function checkContactFields.
 * Function to check if fields are correct and not empty.
 * Display Error message if needed.
 * @param string    $email  Filled in email
 * @param string    $name  Filled in name
 * @param string    $contactMessage  Filled in contactMessage
 * @param string    $subject  Filled in subject
 * @param array     $error  Array with errors
 * @return string/boolean  $error  False or error message
 */
function checkContactFields(string $email, string $name, string $contactMessage, string $subject) {
    //Call global variable(s)
    global $error;

    //If statements so the error messages will be displayed all at once instead of each individual.
    if (!$email && empty($email)) {
        $error[] = 'Email is not correct';
    }
    if (!$name && empty($name)) {
        $error[] = 'Name may not be empty';
    }
    if (!$contactMessage && empty($contactMessage)) {
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
    if (strlen($contactMessage) > 255) {
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
    $contactMessage    = filter_input(INPUT_POST, 'message',   FILTER_SANITIZE_SPECIAL_CHARS);
    $subject    = filter_input(INPUT_POST, 'subject',   FILTER_SANITIZE_SPECIAL_CHARS);

    //Check form data fields
    if (!checkContactFields($email, $name, $contactMessage, $subject)) {
        //SQL Query for inserting contact messages with values
        $query = "INSERT INTO contact_message (name, email, subject, message) VALUES (?,?,?,?)";

        //Prpeparing SQL Query with database connection
        $stmt = mysqli_prepare($conn, $query) or die(mysqli_error($conn));

        //Binding params into ? fields
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $contactMessage) or die('Binding params went wrong');

        //Executing statement
        mysqli_stmt_execute($stmt) or die('Executing statement went wrong');

        //Close the statement
        mysqli_stmt_close($stmt);
        //Close the connection
        mysqli_close($conn);

        //Set succes message
        $_SESSION['succesMessage'] = 'Your message has been sent to the administrator';

        //Refresh page, prefent spam
        header("Refresh:0");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

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
    <link rel="stylesheet" href="../assets/styles/header.css">
    <link rel="stylesheet" href="../assets/styles/footer.css">
</head>

<body>
    <?php
    require_once('../components/header.php');
    ?>
    <div class="container-fluid d-flex align-items-center min-vh-100 spaceBackground">
        <div class="row w-75 h-100 hBox">
            <?php
            if (isset($_POST['submit']) && !empty($error)) {
            ?>
                <div class="col-md-12 p-0">
                    <div class="alert alert-danger text-black fw-bold p-4 rounded-0" role="alert">
                        <ul>
                            <?php
                            foreach ($error as $errorMsg) {
                                echo '<li>' . $errorMsg . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php
            }
            if (isset($_SESSION['succesMessage']) && !empty($_SESSION['succesMessage'])) {
            ?>
            <div class="col-md-12 p-0">
                <div class="alert alert-success text-black fw-bold p-4 rounded-0" role="alert">
                    <ul>
                        <?php
                        echo '<li>' . $_SESSION['succesMessage'] . '</li>';
                        $_SESSION['succesMessage'] = '';
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="col-md-8 p-4 bg-white order-md-1 order-2">
                <h1>CONTACT</h1>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-1">
                        <label for="name" class="form-label">Name</label>
                        <input required type="text" class="form-control" placeholder="John" name="name" id="name" value="<?php if(isset($_SESSION['firstname'])) {echo $_SESSION['firstname'];} else { if (isset($_POST['submit'])) {echo htmlentities($_POST['name']);} } ?>">
                    </div>
                    <div class="mb-1">
                        <label for="subject" class="form-label">Subject</label>
                        <input required type="text" class="form-control" placeholder="Problem" name="subject" id="subject" value="<?php if (isset($_POST['submit'])) {echo htmlentities($_POST['subject']);} ?>">
                    </div>
                    <div class="mb-1">
                        <label for="email" class="form-label"><?php echo $message['email'] ?></label>
                        <input required type="email" class="form-control" placeholder="youremail@domain.com" name="email" id="email" value="<?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];} else { if (isset($_POST['submit'])) {echo htmlentities($_POST['email']);} } ?>">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="form-label">Message</label>
                        <textarea required class="form-control" placeholder="I have a problem" name="message" id="message"><?php if (isset($_POST['submit'])) {echo htmlentities($_POST['message']);} ?></textarea>
                    </div>
                    <div class="buttonBox">
                        <input class="button" type="submit" name="submit" value="Send">
                    </div>
                </form>
            </div>

            <div class="col-md-4 p-4 seeThroughBox order-md-2 order-1">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-white">Other contact?</h1>
                        <p class="text-white">You can always contact us through phone or visit us.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        require_once("../components/footer.php"); ?>
</body>

</html>