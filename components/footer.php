<div class="container-fluid footer">
        <div class="row">
            <div class="col-md-12 text-center">
                <div onclick="show()">
                    <span class="arrow"><i class="fas fa-chevron-up"></i></span>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span class="SpaceXLogo">EMPOWERED BY</span>
                    <img class="spaceXLogo" src="../assets/img/logo/spacerx-logo.svg" class="img-fluid" alt="Logo">
                </div>
            </div>
        </div>
    </div>
   
   <div id="slideFooter" class="container-fluid footer">
        <div class="row">
            <div class="col-md-12 text-center">
                <div onclick="show()">
                    <span class="arrow"><i class="fas fa-chevron-down"></i></span>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img src="../assets/img/logo/logoWit.svg" class="img-fluid" alt="Logo">
                <p><?php echo $message['nebulaxmotto'] ?></p>
            </div>
            <div class="col-sm-3">
                <h1><?php echo $message['explore'] ?></h1>
                <ul class="p-0 m-0">
                    <li><a href="pages/gallery.php"><?php echo $message['exploregallery'] ?></a></li>
                    <li><a href="pages/aboutus.php"><?php echo $message['exploreaboutus'] ?></a></li>
                    <li><a href="pages/suite-overview.php"><?php echo $message['explorebooking'] ?></a></li>
                    <li><a href="pages/contact.php"><?php echo $message['explorecontact'] ?></a></li>
                    <?php
                    if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
                        echo '<li><a href="pages/adminpanel.php">ADMIN-PANEL</a></li>';
                    }
                    if (isset($_SESSION['email'])) {
                        echo '<li><a href="pages/logout.php">logout</a></li>';
                    } else {
                        echo '<li><a href="pages/login.php">'. $message['loginregister2'] .'</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-3">
                <div>
                    <h1><?php echo $message['visit'] ?></h1>
                    <p>1030 15th Street N.W.</p>
                    <p>Suite 220E District of Columbia DC</p>
                    <p>20005-1503</p>
                </div>

                <div>
                <h1><?php echo $message['hq'] ?></h1> 
                <p>Rocket Road Hawthorne.</p>
                <p>California</p>
                </div>
            </div>
            <div class="col-sm-3">
                <h1><?php echo $message['legal'] ?></h1> 
                <p><?php echo $message['terms'] ?></p>
                <p><?php echo $message['privacy'] ?></p>
            </div>
        </div>
        <div class="row text-start">
            <div class="col-md-12">
                <span class="SpaceXLogo">EMPOWERED BY</span>
                <img class="spaceXLogo" src="../assets/img/logo/spacerx-logo.svg" class="img-fluid" alt="Logo">
            </div>
        </div>
    </div>