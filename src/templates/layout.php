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



<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Le blog d'Alexis - Apprenez le PHP</title>

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


<!-- ██████████████████████████████████████████████████████████████████████████████████████████████████████ -->
<!-- BOOTSTRAPT CONTENT -->

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php#page-top">Alexis Troïtzky</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#portfolio">Liste des Posts</a>
                    </li>
                    <li class="page-scroll">
                        <a id="createPostButton" href="#create-post-section">Créer un post</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">À propos</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Contact</a>
                    </li>
                    <li class="page-scroll">
                        <a id="login_button" href="login.php">Login</a>
                    </li>
                    <li class="page-scroll">
                        <a id="logout_button" href="?logout">logout</a>
                    </li>
                    <li class="page-scroll">
                        <a id="register_button" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="skills currentUser" ><?php if (isset($currentUser)) {echo "Bonjour, ".$currentUser;}?></h4>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="img/profile.png" alt="">
                    <div class="intro-text">
                        <span class="name">Alexis Troïtzky</span>
                        <hr class="star-light">
                        <span class="skills">Développeur Web - Développeur d'applications</span>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <script>
        console.log("before login 1");
        var login = "<?php
                        if (!empty($_COOKIE['TOKEN'])) {
                            $login = "in";
                        } else {
                            $login = "out";
                        }
                        echo $login; ?>";
        console.log(login);
        if (login == 'in' && document.getElementById("login_button") != null) {
            document.getElementById("login_button").style.display = "none";
            document.getElementById("register_button").style.display = "none";
            
            console.log('after login');
        }
        console.log("depart");
        var logoutButtonFind = document.getElementById("logout_button");
        console.log("logout find");
        console.log(logoutButtonFind);

        if (login == 'out' && document.getElementById("logout_button")) {
            document.getElementById("logout_button").style.display = "none";
            // document.getElementById("create-post").style.display = "none";
            // document.getElementById("create-post-section").style.display = "none";
        }

        console.log("after logout");
        console.log("before  admin");
        // if (login == 'out' && document.getElementById("logout_button")) {
        //     document.getElementById("admin_button").style.display = "none";
        // }
        console.log("after admin");
        console.log("fin");
    </script>




    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Liste des posts</h2>
                    <hr class="star-primary">
                </div>
            </div>

            <!-- dynamic content from the blog -->
            <?= $content ?>

        </div>
    </section>


    <!-- Create Post Section -->
    <section class="success" id="create-post-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Créer un post</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">

                <div class="col-lg-12 text-center">
                    <form action="index.php?action=addPost" method="post">
                        <div>
                            <label for="title">Titre</label><br />
                            <input class="form-control" type="text" id="title" name="title" />
                        </div>
                        <div>
                            <label for="leadParagraph">Chapô</label><br />
                            <textarea class="form-control" id="leadParagraph" name="leadParagraph"></textarea>
                        </div>
                        <div>
                            <label for="content">Contenu</label><br />
                            <textarea class="form-control" id="content" name="content"></textarea>
                        </div>
                        <div>
                            <input class="btn btn-lg btn-outline" type="submit" id="submitPost" value="Soumettre Post" />
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <script>
        console.log("before create post")
        createPostFind = document.getElementById("createPostButton");
        console.log(createPostFind);
        if (login == 'out' && createPostFind != null) {
            console.log("after create post check")
            document.getElementById("createPostButton").style.display = "none";
        }
        console.log("after create post hide")
    </script>

<script>
        console.log("before create post section")
        createPostSectionFind = document.getElementById("create-post-section");
        console.log(createPostSectionFind);
        if (login == 'out' && createPostSectionFind != null) {
            console.log("after create post section check")
            document.getElementById("create-post-section").style.display = "none";
        }
        console.log("after create post section hide")
    </script>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>À propos de moi</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <p>Je suis actuellement en alternance full remote chez Myddleware dans le cadre de ma formation développeur PHP Symfony chez Open Classrooms.</p>
                </div>
                <div class="col-lg-4">
                    <p>Myddleware est une entreprise qui se spécialise dans les CRM et la migration de données. Mon équipe est formidable et mon travail passionant !</p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="./assets/files/alexiscv.pdf" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> Mon CV
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Me contacter</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Nom</label>
                                <input type="text" class="form-control" placeholder="Nom" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Adresse Email</label>
                                <input type="email" class="form-control" placeholder="Adresse Email" id="email" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Numéro de téléphone</label>
                                <input type="tel" class="form-control" placeholder="Numéro de téléphone" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>




    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Adresse</h3>
                        <p>15 Rue Poitevine
                            <br>Loches, 37600
                        </p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Me trouver sur le web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="https://www.facebook.com/alexj.mercier.1" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/AlexisTroitzky" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/alexis-tro%C3%AFtzky-245b66211/" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="footer-col col-md-4">
                        <h3>About Freelancer</h3>
                        <p>Freelance is a free to use, open source Bootstrap theme created by <a href="http://startbootstrap.com">Start Bootstrap</a>.</p>
                    </div> -->

                    <div class="footer-col col-md-4">
                        <a id="admin_button" href="./administration.php">
                            <h3>Administration</h3>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; alexistroitzky.com 2022
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        var adminButtonFind = document.getElementById("admin_button");
        console.log("admin find");
        console.log(adminButtonFind);



        var admin = "<?php echo $admin; ?>";
        // console.log("this is admin");
        // console.log(admin);
        if (admin != 1 && adminButtonFind != null) {
            document.getElementById("admin_button").style.display = "none";
        }
    </script>


    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>






</body>

</html>