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
        var adminButtonFind = document.getElementById("admin_button");
        var admin = "<?php echo $admin; ?>";
        if (admin != 1 && adminButtonFind != null) {
            document.getElementById("admin_button").style.display = "none";
        }
    </script>
</body>
</html>