<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
        var singlePost = "<?php
                        if ($_GET['action'] === 'post') {
                            $singlePost = "yes";
                        } else {
                            $singlePost = "no";
                        }
                        echo $singlePost; ?>";
        if (singlePost == 'yes' && document.getElementById("list_of_posts") != null) {
            document.getElementById("list_of_posts").style.display = "none";
        }
    </script>
</body>
</html>