<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
    <!-- dynamic content from the blog -->
    <?= $content ?>




    <!-- photo de moi -->
    <img src="../assets/images/alex.png" width="80" height="80" alt="photo-alex">

    <!-- me contacter -->
    <div class="contact_form">
        <form action="index.php" method="post">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="subject" placeholder="Subject">
            <textarea name="message" id="" cols="10" rows="5" placeholder="Message"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- login page -->
    <div class="login"><a id="login_button" href="login.php">Login</a></div>
    <!-- <div class="logout"><a id="logout_button" href="logout.php">Logout</a></div> -->

    <form id="logout_button" action="index.php" method="post">
        <input type="submit" name="actionLogout" value="LOGOUT" />
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actionLogout'])) {
        func();
    }
    function func()
    {
        unset($_COOKIE['TOKEN']);
    }
    ?>


    <script>
        var login = "<?php
                        if (!empty($_COOKIE['TOKEN'])) {
                            $login = "in";
                        } else {
                            $login = "out";
                        }
                        echo $login; ?>";

        console.log(login);
        if (login == 'in') {
            document.getElementById("login_button").style.visibility = "hidden";
        }
        if (login == 'out') {
            document.getElementById("logout_button").style.visibility = "hidden";
        }
    </script>
    <!-- login page -->
    <div class="register"><a href="register.php">Register</a></div>

    <!-- social logos -->
    <div class="social">
        <a href="https://www.linkedin.com/in/alexis-tro%C3%AFtzky-245b66211/">
            <img src="../assets/images/Linkedin.png" width="64" height="64" alt="linkedin">
        </a>
        <a href="https://www.reddit.com/">
            <img src="../assets/images/reddit.png" width="64" height="64" alt="reddit">
        </a>
    </div>

    <!-- footer -->
    <footer>
        <a href="#">Administration</a>
        <p>&copy; 2022</p>
    </footer>

</body>

</html>