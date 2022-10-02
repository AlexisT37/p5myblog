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
        createPostFind = document.getElementById("createPostButton");
        if (login == 'out' && createPostFind != null) {
            document.getElementById("createPostButton").style.display = "none";
        }

        createPostSectionFind = document.getElementById("create-post-section");
        if (login == 'out' && createPostSectionFind != null) {
            document.getElementById("create-post-section").style.display = "none";
        }
    </script>
</body>
</html>