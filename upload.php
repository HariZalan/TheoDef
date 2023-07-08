<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" value="Feltöltés" />
        </form>
        <?php
if ($_FILES["file"]) {
    $filedata = $_FILES["file"];
    echo(str($filedata));
} else {
    echo ("Működik");
}
?>
    </body>
</html>