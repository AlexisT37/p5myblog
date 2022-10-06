<?php
include "config.php";
require_once('classes/JWT.php');
// require('classes/dotenv.php');

use Dotenv\DotEnv;

(new DotEnv("../.env"))->load();

$SECRET = getenv('SECRET');

// dev



if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {

        //Better sql without injection
        $sql = "SELECT count(*) as cntUser FROM user WHERE username=?"; // SQL with parameters
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc(); // fetch the data   

        $count = $row['cntUser'];

        if ($count > 0) {
            //Better sql without injection
            $sql = "SELECT password, id, roles FROM user WHERE username=?"; // SQL with parameters
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            $row = $result->fetch_assoc(); // fetch the data   

            $databasePassword = $row['password'];

            $goodpassword = password_verify($password, $databasePassword);

            if ($goodpassword === true) {


                $username = $uname;

                $userId = $row['id'];

                $rolesRaw = $row['roles'];
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
                $token = $jwt->generate($header, $payload, $SECRET, 3600);


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
