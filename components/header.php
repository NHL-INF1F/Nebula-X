<?php
require_once ('translation/en.php');
?>
<div class="container-fluid header">
    <div class="row">
        <div class="col-12 col-md-6 d-flex justify-content-md-start">
            <img src="../assets/img/logo/logoWit.svg" class="img-fluid logoImg" alt="Logo">
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-md-end">
            <ul class="p-0 headerLinks">
                <li class="headerList"><a href="../index.php"><?php echo $message['home']; ?></a></li>
                <li class="headerList"><a href="gallery.php"><?php echo $message['gallery']; ?></a></li>
                <li class="headerList"><a href="aboutus.php"><?php echo $message['aboutus']; ?></a></li>
                <li class="headerList"><a href="suite-overview.php"><?php echo $message['booking']; ?></a></li>
                <li class="headerList"><a href="contact.php"><?php echo $message['contact']; ?></a></li>
                <?php
                    if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
                        echo '<li class="headerList"><a href="adminpanel.php" class="text-primary">ADMIN-PANEL</a></li>';
                    }
                    if (isset($_SESSION['email'])) {
                        echo '<li class="headerList"><a href="logout.php" class="text-danger">LOGOUT</a></li>';
                    } else {
                        echo '<li class="headerList"><a href="login.php">'. $message['loginregister'] .'</a></li>';
                    }
                    ?>
            </ul>
        </div>
    </div>
</div>