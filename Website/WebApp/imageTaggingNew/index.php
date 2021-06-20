<?php
    include "../header.php"; 
    getHeader(false, "IMAGE TAGGING");

    if ($_POST) {
      // image ID festlegen, dass es später eingeladet werden kann.
      $_GET['id'] = $_POST['imageID'];

      $foundEntry = false;

      /* schauen ob Punkte für dieses Bild schon in my sql */
      try {
        $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");
        $queryString = "SELECT * from tags where imageid = " . $_GET['id'];
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

      /* neue Punkte speichern */
      try {
        $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");

        if ($foundEntry) {
          $queryString = "update tags set tagList='" . $_POST['tagData'] . "' where imageid=" . $_POST['imageID'];
        }
        else
        {
          $queryString = "insert into tags (imageID, tagList) values (" . $_POST['imageID'] . ", '" . $_POST['tagData'] ."')";
        }

        //echo $queryString;

        $qR = $dbh->query($queryString);
      } catch (PDOException $e) {
        echo "Fehler beim MYSQL: " . $e->getMessage();
      }
    }

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
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;900&display=swap" rel="stylesheet">
  </head>

  <body>
    <form action="." id="tagForm" method="post">
        <input type="hidden" id="tagData" name="tagData" value='<?php echo $tagDataSQL; ?>'>
        <input type="hidden" id="imageID" name="imageID" value="<?php echo $_GET['id']; ?>">
    </form>

    <div id="gridDiv">
      <div id="editor">
        <div id="editorDiv">
          <img src="<?php echo $imgSource; ?>" id="editor_image" alt="Selected Image for Tagging">
          <div id="tags">
          </div>
        </div>


        <div id="cords">
          <p id="cordX">X:</p>
          <p id="cordY">Y:</p>
        </div>
      </div>

      <div id="dataHandler">
        <h1 id="title2" class="customHeader">DATA EDITOR</h1>
        <hr style="position: relative; top: 6vh; margin-bottom: 5vh;">

        <h3 id="title3" class="customHeader">TAG SELECTION</h3>
        <select id="tagList">
          <option value="default" class="tag_option">(none)</option>
        </select>

        <h3 id="title4" class="customHeader">TITLE</h3>
        <input type="text" id="field_name">

        <h3 id="title5" class="customHeader">Description</h3>
        <textarea name="field_description" id="field_description" cols="30" rows="10"></textarea>

        <button type="submit" class="dataButton" id="button_submit">Submit</button>
        <button type="delete" class="dataButton" id="button_delete">Delete</button>


      </div>
    </div>

    <script type="module" src="./tagging.js"></script>
  </body>
</html>
