<?php
require_once('controllers/database/dbconnect.php');
require('en.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="pages/register.php" name="register"><?php echo ($messages['register']);?></a>
</body>
</html>