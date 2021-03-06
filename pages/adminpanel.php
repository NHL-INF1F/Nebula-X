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
<html lang="en">
<head>
    <title>Adminpanel</title>
    <meta charset="UTF-8">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        function openModal(id) {
            var a = document.getElementById('delete-button');
            a.href = "../components/adminpanel/delete_message.php?id=" + id;
            document.getElementById('delbtnpress').style.display='block'
        }
    </script>
</head>
<body>
<main>
    <?php
    require_once ('../components/translation/en.php');
    include('../controllers/database/dbconnect.php');
    require_once('../components/header.php');
    ?>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-4 pt-5">
                <h2 class="text-white"><?php echo $message['reservations']; ?></h2>

                <div class="table-responsive">
                    <table class="bg-white">
                        <tr>
                            <th><?php echo $message['id']; ?></th>
                            <th><?php echo $message['userid']; ?></th>
                            <th><?php echo $message['suiteid']; ?></th>
                            <th><?php echo $message['startdate']; ?></th>
                            <th><?php echo $message['enddate']; ?></th>
                        </tr>

                        <tbody>
                        <?php
                        // run query from database
                        $reservationsql = "SELECT * from reservation";
                        $reservationstmt = mysqli_prepare($conn, $reservationsql);
                        if (!$reservationstmt) {
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        if (!mysqli_stmt_execute($reservationstmt)) {
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        };
                        mysqli_stmt_bind_result($reservationstmt, $id, $user_id, $suite_id, $date_from, $date_to);

                        // while loop to echo the query results in a table
                        while (mysqli_stmt_fetch($reservationstmt)) {
                            echo "<tr>
                                    <td>" . $id . "</td>
                                    <td>" . $user_id . "</td>
                                    <td>" . $suite_id . "</td>
                                    <td>" . $date_from . "</td>
                                    <td>" . $date_to . "</td>
                                    <td><a href=adminpanel-view.php?id=" . $id . ">" . $message['details'] . ";</a></td>
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
                        <tr>
                            <th><?php echo $message['id']; ?></th>
                            <th><?php echo $message['name']; ?></th>
                            <th><?php echo $message['email']; ?></th>
                            <th><?php echo $message['subject']; ?></th>
                            <th><?php echo $message['message']; ?></th>
                            <th></th>
                            <th></th>
                        </tr>

                        <tbody>
                        <?php
                        // run query from database
                        $contactsql = "SELECT * from contact_message";
                        $contactstmt = mysqli_prepare($conn, $contactsql);
                        if (!$contactstmt) {
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        if (!mysqli_stmt_execute($contactstmt)) {
                            $_SESSION['error'] = "database_error";
                            header("location: error.php");
                        }
                        mysqli_stmt_bind_result($contactstmt, $id, $name, $email, $subject, $message);

                        // while loop to echo the query results in a table
                        while (mysqli_stmt_fetch($contactstmt)) {
                            ?> <tr>
                                    <td><?php echo $id ?></td>
                                    <td><?php echo $name ?></td>
                                    <td><?php echo $email ?></td>
                                    <td><?php echo $subject ?></td>
                                    <td><?php echo $message ?></td>
                                    <td> <a href=mailto:$email?subject=Response%20$subject>Send Mail</a></td>
                                    <td> <button class='btn btn-primary' onclick='openModal(<?php echo $id ?>)'>Delete</button></td>
                                    </tr> <?php
                        }
                        mysqli_stmt_close($contactstmt);
                        ?>
                        <div id="delbtnpress" class="modal">
                            <form action="/action_page.php">
                                <div class="modal-content">
                                    <h1>Delete Confirmation</h1>
                                    <h2>Are you sure you want to delete the Message?</h2>
                                    <p class="text-danger fw-bold">WARNING: MAKE SURE TO SEND AN EMAIL TO THE USER
                                        BEFORE DELETING THE Message IT WILL BE GONE FOREVER!</p>
                                    <div>
                                        <a id="delete-button" class='btn btn-danger'>Delete</a>
                                        <button type="button"
                                                onclick="document.getElementById('delbtnpress').style.display='none'"
                                                class="btn btn-warning">Cancel
                                        </button>
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
                    /**
                     * Uploads the given image.
                     *
                     * @param $image array An array containing the data of the image.
                     * @return bool
                     */
                    function uploadImage(array $image): bool {
                        global $error;

                        if (!is_uploaded_file($image['tmp_name'])) {
                            $error[] = 'Nothing detected. Are you sure you uploaded something?';
                            return false;
                        }

                        if ($image['size'] > 3000000) {
                            $error[] = 'The file you uploaded is too big. Upload a file with max of 3MB.';
                            return false;
                        }

                        $acceptedFileTypes = ["image/jpg", "image/jpeg", "image/png"];
                        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                        $uploadedFileType = finfo_file($fileinfo, $image['tmp_name']);
                        if (!in_array($uploadedFileType, $acceptedFileTypes)) {
                            $error[] = 'The filetype is not correct. Upload a jpg/jpeg/png.';
                            return false;
                        }
                        if ($image['error'] != 0) {
                            $error[] = 'A error. Try again with another picture';
                            return false;
                        }

                        if (strlen($image['name']) > 50) {
                            $error[] = 'Filename is too long. The name has to be 50 characters or less.';
                            return false;
                        }
                        if (file_exists('../assets/img/gallery/' . $image['name'])) {
                            $error[] = 'Filename: ' . $image['name'] . ' exists. Upload a picture with another filename.';
                            return false;
                        }

                        if (!move_uploaded_file($image['tmp_name'], '../assets/img/gallery/' . $image['name'])) {
                            $error[] = 'file not supported';
                            return false;
                        }
                        return true;
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
                                    <img alt='$file' class='img-fluid mb-2' src='" . $dir . "/" . $file . "'>

                                    <form action='" . htmlentities($_SERVER['PHP_SELF']) . "' method='post'>
                                        <input type='hidden' name='imageName' value='" . $file  . "'>
                                        <input class='btn btn-primary' type='submit' name='delete' value='Delete'>
                                    </form>
                                </div>
                            </div>
                            ";
                        }
                        closedir($dirOpen);
                    }

                    if (isset($_POST['sendImage'])) { 
                        if (uploadImage($_FILES['photo'])) {
                            echo "<h3 class='text-white'>File uploaded!</h3>";
                        }
                    }

                    if (isset($_GET['getImage'])) {
                        $supportedFileTypes = array("jpg, jpeg, png");
                        foreach ($supportedFileTypes as $subarray) {

                            if (!in_array(htmlentities($_GET['fileType']), $supportedFileTypes)) {
                                echo "Manipulation with the filetype!";
                                exit;
                            }
                        }

                        getImage(htmlentities($_GET['fileType']));
                    }

                    if (isset($_POST['delete'])) {
                        if (unlink('../assets/img/gallery/' . htmlentities($_POST['imageName']))) {
                            echo 'Picture deleted';
                        } else {
                            $error[] = 'Not found.';
                        }
                    }
                    ?>
                <div class="row">
                    <?php
                    global $error;
                    if (!empty($error)) {
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
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-3" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post"
                              enctype="multipart/form-data">
                            <div class="mb-2">
                                <label for="image" class="form-label text-white">Upload gallery picture</label>
                                <input required class="form-control" type="file" name="photo" id="image">
                            </div>
                            <div>
                                <input class="btn btn-primary" type="submit" name="sendImage" value="Upload">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <h3 class="text-white">Uploaded images</h3>
                    <?php
                    getImage();
                    ?>
                </div>

            </div>
        </div>
    </div>
</main>

<?php
// close the connection
mysqli_close($conn);
?>

</body>
</html>