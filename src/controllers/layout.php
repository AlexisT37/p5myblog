<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actionLogout'])) {
    func();
}
function func()
{
    unset($_COOKIE['TOKEN']);
}

if (isset($_GET['logout'])) {

    setcookie("TOKEN", null, 1);

    setcookie($_COOKIE['TOKEN'], '', time() - 3600);

    unset($_COOKIE['TOKEN']);

    session_destroy();

    header('Location: index.php');

    exit;
}

// Set admin flag
if (!empty($_COOKIE['TOKEN'])) {
    $myToken = $_COOKIE['TOKEN'];
    $adminJWTCheck = new JWT();
    $adminInJWT = $adminJWTCheck->isAdmin($myToken);
    if ($adminInJWT === true) {
        $admin = 1;
    } else {
        $admin = 0;
    }
} else {
    $admin = 0;
}


// Set User flag
if (!empty($_COOKIE['TOKEN'])) {
    $currentUserPayload = $adminJWTCheck->getPayload($myToken);
    $currentUser = $currentUserPayload['username'];
}
?>


<?php $login = (isset($_COOKIE['TOKEN'])) ? "in" : "out";?>
    <?php $singlePost = ($_GET['action'] === 'post') ? "yes" : "no";?>
    <?php $token = (isset($_COOKIE['TOKEN'])) ? $_COOKIE['TOKEN'] : false;?>