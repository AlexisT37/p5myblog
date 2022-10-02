<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<script>
        var login = "<?php
                        if (!empty($_COOKIE['TOKEN'])) {
                            $login = "in";
                        } else {
                            $login = "out";
                        }
                        echo $login; ?>";
        if (login == 'in' && document.getElementById("login_button") != null) {
            document.getElementById("login_button").style.display = "none";
            document.getElementById("register_button").style.display = "none";
        }
        var logoutButtonFind = document.getElementById("logout_button");
        if (login == 'out' && document.getElementById("logout_button")) {
            document.getElementById("logout_button").style.display = "none";
        }
    </script>