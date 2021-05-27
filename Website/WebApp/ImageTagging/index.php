<html>
    <head>
        <title>Image Editor</title>
        <link rel="stylesheet" href="./styles-imageEditor.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Cantarell:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <h1 id="title">Image Editor</h1>
    <?php 
        $imageName;
        if (isset($_GET['name'])) {
            $imageName = $_GET['name'];
            echo "<h1 id=\"subtitle\">Selected Image: " . $imageName . "</h1>";
        } else {
            echo "<h1 id=\"subtitle\">No image selected</h1>";
        }
    ?>
</html>
