<?php
include "config.php";
require_once('classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/controllers/user/add.php');

use Application\Controllers\User\Add\AddUser;

// if ($_GET['action'] === 'addUser') {
// }


if (isset($_POST['register_submit'])) {
    (new AddUser())->execute();

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from user where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            echo "This user already exist";
        } else {
            // if ($_GET['action'] === 'addUser') {
            //     if (isset($_GET['id']) && $_GET['id'] > 0) {
            //         $identifier = $_GET['id'];

            //         (new AddUser())->execute();
            //     } else {
            //         throw new Exception('Aucun identifiant de billet envoyé');
            //     }
            // header('Location: register.php');
        }
    }
}
?>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <div class="container">
        <form action="register.php?action=addUser" method="post">
            <!-- <form method="post" action=""> -->
            <div id="div_login">
                <h1>Register</h1>
                <div>
                    <input type="text" class="textbox" id="txt_email" name="txt_email" placeholder="Email" />
                </div>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Password" />
                </div>
                <div>
                    <input type="submit" value="Submit" name="register_submit" id="register_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>