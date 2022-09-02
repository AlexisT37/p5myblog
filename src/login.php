<?php
include "config.php";
require_once('classes/JWT.php');


if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from user where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $username = $uname;

            $queryRoles = "select roles from user where username='" . $username . "'";
            $resultRoles = mysqli_query($con, $queryRoles);
            $rowRoles = mysqli_fetch_row($resultRoles);

            $rolesRaw = $rowRoles[0];
            //todo use jwt instead
            // $_SESSION['uname'] = $uname;
            $rolesquote = str_replace("'", "", $rolesRaw);
            $roles = explode(",", $rolesquote);


            //header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256',
            ];

            //payload made for the user
            $payload = [
                'user_id' => $uname,
                'roles' => $roles
            ];

            //generates a jwt for the user if the login is successful
            //the jwt will be used for other actions
            $jwt = new JWT();

            //validity is 60 seconds
            //new token is 1 hour not one day like the tutorial
            $token = $jwt->generate($header, $payload, SECRET, 3600);


            header('Location: home.php');
        } else {
            echo "Invalid username and password";
        }
    }
}
?>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Password" />
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>