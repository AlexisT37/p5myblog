<?php 
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
