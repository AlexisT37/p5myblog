<?php
require_once('../src/classes/dotenv.php');
use Dotenv\DotEnv;
(new DotEnv("../.env"))->load();
$host = getenv('HOST');
$user = getenv('USER');
$password = getenv('PASSWORD');
$dbname = getenv('DBNAME');
$port = (int)getenv('PORT');


try {

    $con = mysqli_connect($host, $user, $password, $dbname, $port);

    // Check connection
    if (!$con) {
        throw new Exception("Connection failed.");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
