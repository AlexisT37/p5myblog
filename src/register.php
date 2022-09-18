<?php
include "config.php";
require_once('classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/controllers/user/add.php');

use Application\Controllers\User\Add\AddUser;

if (isset($_POST['register_submit'])) {
    (new AddUser())->execute();

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);
}
include('./templates/register.php');
