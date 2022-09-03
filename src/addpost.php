<?php
include "config.php";
require_once('classes/JWT.php');


if (isset($_POST['but_submit'])) {

    $title = mysqli_real_escape_string($con, $_POST['txt_title']);
    $content = mysqli_real_escape_string($con, $_POST['txt_content']);
    $leadParagraph = mysqli_real_escape_string($con, $_POST['txt_leadParagraph']);


    if ($title != "" && $content != "" && $leadParagraph != "") {

        $sql_query = "select count(*) as cntPost from posts where title='" . $title . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntPost'];

        if ($count == 0) {





            header('Location: home.php');
        } else {
            echo "Post already exists";
        }
    } else {
        echo "You have to fill all the fields";
    }
}
?>
<html>

<head>
    <title>Add a post</title>
</head>

<body>
    <div class="container">
        <form method="post" action="index.php?action=addPost&id=<?= $user->identifier ?>">
            <div id="div_addpost">
                <h1>Add a post</h1>
                <div>
                    <input type="text" class="textbox" id="txt_title" name="txt_title" placeholder="title" />
                </div>
                <div>
                    <input type="text" class="textbox" id="txt_content" name="txt_content" placeholder="content" />
                </div>
                <div>
                    <input type="text" class="textbox" id="txt_leadParagraph" name="txt_leadParagraph" placeholder="leadParagraph" />
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>