<html>

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/freelancer.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>
    <div class="container col-lg-12 text-center" id="container_register">
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
                    <input type="password" class="textbox" id="txt_password" name="txt_pwd" placeholder="Password" />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_password_verify" name="txt_password_verify" placeholder="Password" />
                </div>
                <div>
                    <input class="btn btn-success btn-lg" type="submit" value="Submit" name="register_submit" id="register_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>
