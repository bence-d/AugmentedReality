<?php 
    include "../header.php";
    include "./upload.php";
    getHeader(true, "IMAGE SELECTOR");


    if ($_POST)
    {
        if (isset($_POST['deleteID']))
        {
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");
                $queryString = "DELETE FROM images WHERE ID = " . $_POST['deleteID'] . ";";
                $qR = $dbh->query($queryString);
                
            } catch (PDOException $e) {
                echo "Fehler beim MYSQL: " . $e->getMessage();
            }
    
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");
                $queryString = "DELETE FROM tags WHERE imageID = " . $_POST['deleteID'] . ";";
                $qR = $dbh->query($queryString);
            } catch (PDOException $e) {
                echo "Fehler beim MYSQL: " . $e->getMessage();
            }
        } 
    }


?>

<html>
    <head>
        <link rel="stylesheet" href="./styles.css"> 
    </head>
    
    <body>
    <form action="." method="post" id="deleteIDForm">
        <input type="hidden" name="deleteID" value="" id="deleteID">
    </form>
    <div id="imageGrid">

<?php
    include "./imageCardGenerator.php";
    
    $result = "";

    /* schauen ob Punkte für dieses Bild schon in my sql */
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");
        $queryString = "SELECT * from images limit 14";
        $qR = $dbh->query($queryString);

        if ($qR) {
            $result = $qR->fetchAll();

            if (count($result) > 0)
            {
            // Eintrag in MYSQL über den aktuellen Bild gefunden
            $foundEntry = true;
            }
        }
    } catch (PDOException $e) {
        echo "Fehler beim MYSQL: " . $e->getMessage();
    }

    for ($i = 0; $i < count($result); $i++) {
        generateImageBox($result[$i][2], $result[$i][0]);
    }

    generateUpload();

?>

    </div>

    <script>
        function setDeleteId(id) {
            document.getElementById('deleteID').value = id;
            document.getElementById('deleteIDForm').submit();
        }
    </script>
    </body>
</html>