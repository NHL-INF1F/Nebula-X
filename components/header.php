<div class="container-fluid header">
    <div class="row">
        <div class="col-12 col-md-6 d-flex justify-content-md-start">
            <img src="../assets/img/logo/logoWit.svg" class="img-fluid headerImg" alt="Logo">
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-md-end">
            <ul class="p-0 mt-4">
                <li class="headerList"><a href="../index.php">Home</a></li>
                <li class="headerList"><a href="../index.php">Gallery</a></li>
                <li class="headerList"><a href="../index.php">About Us</a></li>
                <li class="headerList"><a href="../index.php">Rooms</a></li>
                <li class="headerList"><a href="../index.php">Booking</a></li>
                <li class="headerList"><a href="contact.php">Contact</a></li>
                <?php
                    if (isset($_SESSION['email'])) {
                        echo '<li class="headerList"><a href="logout.php" class="text-danger">LOGOUT</a></li>';
                    } else {
                        include_once('../components/translation/en.php');
                        echo '<li class="headerList"><a href="register.php">'. $message['loginregister'] .'</a></li>';
                    }
                    ?>
            </ul>
        </div>
    </div>
</div>