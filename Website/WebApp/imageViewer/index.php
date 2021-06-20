<?php      
    include "../header.php"; 
    getHeader(false, "IMAGE VIEWER");

    $tagDataSQL = "";
    
    /* Punkte von MYSQL Abfragen */
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");
      $queryString = "SELECT * from tags where imageid = " . $_GET['id'];
      $qR = $dbh->query($queryString);

      if ($qR) {
        $result = $qR->fetchAll();

        if (count($result) > 0)
        {
          $tagDataSQL = $result[0][1];
        }
      }
    } catch (PDOException $e) {
      echo "Fehler beim MYSQL: " . $e->getMessage();
    }

    $imgSource = "";

    /* Bild-Pfad mit gegebenen ID vom Datenbank abfragen*/
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");

      if (isset($_GET["id"])) {
          $qR = $dbh->query('SELECT * from images where id =' . $_GET["id"]);
          $result = $qR->fetchAll();
          $imgSource = "../Images/" . $result[0][2];
      }
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
?>

<html>
  <head>
    <title>AR-App</title>
    <link href="./styles.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">

    <style>
      body {
        background-image: url("../Images/ar-background.png");
        overflow: hidden;
      }
    </style>
  </head>

  <body>
    <form action="." id="tagForm" method="post">
        <input type="hidden" id="tagData" name="tagData" value='<?php echo $tagDataSQL; ?>'>
        <input type="hidden" id="imageID" name="imageID" value="<?php echo $_GET['id']; ?>">
    </form>

    <div id="editor">
        <div id="editorDiv">
            <img id="editor_image" src="<?php echo $imgSource; ?>" alt="Selected Image for Tagging">
            <div id="tags">
            </div>
        </div>
    </div>

    <div id="infoBox" class="hide">
        <p id="infoBox_title">Title</p>
        <hr>
        <p id="infoBox_description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio nihil tenetur sit assumenda.</p>
    </div>

    <script type="module" src="dotHandler.js"></script>
  </body>
</html>
