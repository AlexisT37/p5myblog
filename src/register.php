<?php
include "config.php";
require_once('classes/JWT.php');
require_once('../src/controllers/user/add.php');

use Application\Controllers\User\Add\AddUser;

if (isset($_POST['register_submit'])) {
    (new AddUser())->execute();

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);
    $passwordVerify = mysqli_real_escape_string($con, $_POST['txt_password_verify']);
}
include('./templates/register.php');
