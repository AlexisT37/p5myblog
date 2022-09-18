<?php
include "config.php";
require_once('classes/JWT.php');


if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {


        $sql_query = "select count(*) as cntUser from user where username='" . $uname . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $queryPassword = "select password from user where username='" . $uname . "'";
            $resultPassword = mysqli_query($con, $queryPassword);
            $hash = mysqli_fetch_row($resultPassword);
            $goodpassword = password_verify($password, $hash[0]);

            if ($goodpassword == true) {


                $username = $uname;


                $queryId = "select id from user where username='" . $username . "'";
                $resultId = mysqli_query($con, $queryId);
                $userIdString = mysqli_fetch_row($resultId)[0];
                $userId = (int)$userIdString;



                $queryRoles = "select roles from user where username='" . $username . "'";
                $resultRoles = mysqli_query($con, $queryRoles);
                $rowRoles = mysqli_fetch_row($resultRoles);

                $rolesRaw = $rowRoles[0];
                $rolesquote = str_replace("'", "", $rolesRaw);
                $roles = explode(",", $rolesquote);


                //header
                $header = [
                    'typ' => 'JWT',
                    'alg' => 'HS256',
                ];

                //payload made for the user
                $payload = [
                    'userId' => $userId,
                    // 'user_id' => $uname,
                    'username' => $uname,
                    'roles' => $roles
                ];

                //generates a jwt for the user if the login is successful
                //the jwt will be used for other actions
                $jwt = new JWT();

                //validity is 60 seconds
                //new token is 1 hour not one day like the tutorial
                $token = $jwt->generate($header, $payload, SECRET, 3600);


                setcookie("TOKEN", $token);
                header('Location: index.php');
            } else {
                echo "Invalid password";
            }
        } else {
            echo "Invalid username";
        }
    }
}

include('./templates/login.php');
