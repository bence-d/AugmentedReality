<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1 id="page_title">Image Tagging System</h1>

        <div id="fileUploadHolder">
            <form action="." method="post" enctype="multipart/form-data">
            <h3 style="text-align:center;">submit an image</h3>
            <label for="imageName">Name:</label><br>
            <input type="text" name="imageName"><br>
            <label for="userfile">Choose a file to upload</label><br>
            <input type="file" name="userfile" id="userfile"><br>

            <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </body>
</html>

<?php
    if (isset($_POST['submit'])) {
        echo "Name: " . $_POST['imageName'] . "<br>"; 
        echo "Dateiname: " . $_FILES['userfile']['name'];
    }
?>