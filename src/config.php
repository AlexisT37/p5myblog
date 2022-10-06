<?php

const SECRET = 'p9uh020dp03bpo0ugouontu';

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = "root"; /* Password */
$dbname = "oc4"; /* Database name */

try {

    $con = mysqli_connect($host, $user, $password, $dbname);

    // Check connection
    if (!$con) {
        throw new Exception("Connection failed.");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
