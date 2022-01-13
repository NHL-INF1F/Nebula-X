<?php
//Start a session
session_start();

//Check if user is logged
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    //Send user to index.php
    header('location: ../index.php');
}

$error = array();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Adminpanel</title>
        <meta charset="UTF-8">

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap%27" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Bebas+Neue&display=swap%27" rel="stylesheet">
        <link rel="stylesheet" href="../assets/styles/header.css">
        <link rel="stylesheet" href="../assets/styles/adminpanel.css">
        
        <!-- modal script -->
        <script>
            // Script for the modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp
            // Get the modal
            var modal = document.getElementById('delbtnpress');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </head>
    <body>
        <?php
            include('../controllers/database/dbconnect.php');
            require_once('../components/header.php');
            require('../components/translation/en.php');
        ?>

        <div class="container-fluid blueBackground">
            <div class="row p-5">
                <div class="col-md-4 pt-5">
                    <h2 class="text-white"><?php echo $message['reservations']; ?></h2>

                    <div class="table-responsive">
                        <table class="bg-white">
                            <thead>
                                <th><?php echo $message['id']; ?></th>
                                <th><?php echo $message['userid']; ?></th>
                                <th><?php echo $message['suiteid']; ?></th>
                                <th><?php echo $message['startdate']; ?></th>
                                <th><?php echo $message['enddate']; ?></th>
                            </thead>
                            
                            <tbody>
                            <?php
                            // run query from database
                            $reservationsql = "SELECT * from reservation";
                            $reservationstmt = mysqli_prepare($conn, $reservationsql) or die(mysqli_error($conn));
                            mysqli_stmt_execute($reservationstmt) or die("Error");
                            mysqli_stmt_bind_result($reservationstmt, $id, $user_id, $suite_id, $date_from, $date_to);

                            // while loop to echo the query results in a table
                            while (mysqli_stmt_fetch($reservationstmt)) {
                                echo "<tr>
                                    <td>" . $id ."</td>
                                    <td>" . $user_id ."</td>
                                    <td>" . $suite_id ."</td>
                                    <td>" . $date_from ."</td>
                                    <td>" . $date_to . "</td>
                                    <td><a href=adminpanel-view.php?id=" . $id . ">$message['details'];</a></td>
                                    </tr>";
                            }
                            mysqli_stmt_close($reservationstmt);
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="text-white"><?php echo $message['contactmessages']; ?></h2>

                    <div class="table-responsive">
                        <table class="bg-white">
                            <thead>
                                <th><?php echo $message['id']; ?></th>
                                <th><?php echo $message['name']; ?></th>
                                <th><?php echo $message['email']; ?></th>
                                <th><?php echo $message['subject']; ?></th>
                                <th><?php echo $message['message']; ?></th>
                                <th></th>
                            </thead>

                            <tbody>
                            <?php
                            // run query from database
                            $contactsql = "SELECT * from contact_message";
                            $contactstmt = mysqli_prepare($conn, $contactsql) or die(mysqli_error($conn));
                            mysqli_stmt_execute($contactstmt) or die("Error");
                            mysqli_stmt_bind_result($contactstmt, $id, $name, $email, $subject, $message);
                            
                            // while loop to echo the query results in a table
                            while(mysqli_stmt_fetch($contactstmt)) {
                                echo "<tr>
                                    <td>" . $id ."</td>
                                    <td>" . $name ."</td>
                                    <td>" . $email ."</td>
                                    <td>" . $subject . "</td>
                                    <td>" . $message ."</td>
                                    <td> <a href=mailto:$email?subject=Response%20$subject>Send Mail</a></td>
                                    <td> <button class='btn btn-primary' onclick=document.getElementById('delbtnpress').style.display='block'>Delete</button></td>
                                    </tr>";
                            }
                            mysqli_stmt_close($contactstmt);
                            ?>
                            <!-- Pop-up confirmation for deletion, using the Modal from: https://www.w3schools.com/howto/howto_css_delete_modal.asp -->
                            <div id="delbtnpress" class="modal">
                                <span onclick="document.getElementById('delbtnpress').style.display='none'" class="close" title="Close Modal">×</span>
                                <form class="modal-content" action="/action_page.php">
                                    <div class="container">
                                        <h1>Delete Confirmation</h1>
                                        <h2>Are you sure you want to delete the Message?</h2>
                                        <p>WARNING: MAKE SURE TO SEND AN EMAIL TO THE USER BEFORE DELETING THE Message IT WILL BE GONE FOREVER!</p>
                                        <div class="clearfix">
                                            <?php 
                                                echo "<a href=../components/adminpanel/delete_message.php?id=". $id .">Delete</a></div>"; 
                                            ?>
                                            <button type="button" onclick="document.getElementById('delbtnpress').style.display='none'" class="cancelbtn">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </tbody>
                        </table>
                    </div>

                </div>
                
                <div class="col-md-4 pt-5">
                    <h2 class="text-white">Gallery</h2>

                    <?php
                    function checkImage($image) {
                        global $error;

                        if (is_uploaded_file($image['tmp_name'])){
                            if ($image['size'] <= 3000000){
                                $acceptedFileTypes = ["image/jpg", "image/jpeg", "image/png"];
                                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                                $uploadedFileType = finfo_file($fileinfo, $image['tmp_name']);
                                if (in_array($uploadedFileType, $acceptedFileTypes)) {
                                    if ($image['error'] == 0) {
                                        if (strlen($image['name']) <= 50) {
                                            if (!ctype_lower($image['name'])) {
                                                if (!file_exists('../assets/img/gallery/' . $image['name'])) {
                                                    if (move_uploaded_file($image['tmp_name'], '../assets/img/gallery/' . $image['name'])) {
                                                        return true;
                                                    }
                                                } else {
                                                    $error[] = 'Oeps! Een fout. Probeer het opnieuw.';
                                                    return false;
                                                }
                                            } else {
                                                $error[] = 'Bestandsnaam: ' . $image['name'] . ' bestaat nu al. Upload een foto met een andere naam a.u.b.';
                                                return false;
                                            }
                                        } else {
                                            $error[] = 'Bestandnaam is te lang. De naam moet 50 karakters of minder zijn.';
                                            return false;
                                        }
                                    } else {
                                        $error[] = 'Oeps! Een fout. Probeer het met een andere foto.';
                                        return false;
                                    }
                                } else {
                                    $error[] = 'Het bestandstype van de foto is niet correct. Upload een jpg/jpeg/png.';
                                    return false;
                                }
                            } else {
                                $error[] = 'Het bestand dat je uploadt is te groot. Upload een foto van maximaal 3MB of minder.';
                                return false;
                            }
                        } else {
                            $error[] = 'Niks gedetecteerd. Weet je zeker dat je iets hebt geuploadt?';
                            return false;
                        }
                    }

                    function getImage() {
                        $dir = "../assets/img/gallery";

                        $dirOpen = opendir($dir);

                        while (($file = readdir($dirOpen)) !== false) {
                            if (is_dir($file)) {
                                continue;
                            }

                            echo "
                            <div class='col-sm-12 col-md-6 mb-3'>
                                <div class='border border-primary p-2'>
                                    <img class='img-fluid mb-2' src='" . $dir . "/" . $file . "'>

                                    <form action='" . htmlentities($_SERVER['PHP_SELF']) . "' method='post'>
                                        <input type='hidden' name='imageName' value='" . $file  . "'>
                                        <input class='btn btn-primary' type='submit' name='delete' value='Verwijderen'>
                                    </form>
                                </div>
                            </div>
                            ";
                        }
                        closedir($dirOpen);
                    }

                    if (isset($_POST['sendImage'])) {
                        if (checkImage($_FILES['photo'])) {
                            echo "<h3> Bestand geupload!</h3>";
                        }
                    }

                    if (isset($_GET['getImage'])) {
                        $supportedFileTypes = array("jpg, jpeg, png");
                        foreach ($supportedFileTypes as $subarray) {

                            if (!in_array(htmlentities($_GET['fileType']), $supportedFileTypes)) {
                                echo "Manipulatie met het bestandstype!!!";
                                exit;
                            }
                        }

                        getImage(htmlentities($_GET['fileType']));
                    }

                    if (isset($_POST['delete'])) {
                        if (unlink('../assets/img/gallery/' . htmlentities($_POST['imageName']))) {
                            echo 'De foto is verwijderd.';
                        } else {
                            $error[] = 'Niet gevonden';
                        }
                    }
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
                    <form class="mb-3" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="image" class="form-label text-white">Upload gallery picture</label>
                            <input class="form-control" type="file" name="photo" id="image">
                        </div>
                        <div>
                            <input class="btn btn-primary" type="submit" name="sendImage" value="Upload">
                        </div>
                    </form>

                    <div class="row">
                    <?php
                    getImage();
                    ?>
                    </div>

                </div>
            </div>
        </div>
        
    <?php
    // close the connection
    mysqli_close($conn);
    ?>

    </body>
</html>