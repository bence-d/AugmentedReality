<?php
  $status = "";

  if (isset($_POST['submit']))
  {
    //Stores the filename as it was on the client computer.
    $imagename = $_FILES['uploadedFile']['name'];
    //Stores the filetype e.g image/jpeg
    $imagetype = $_FILES['uploadedFile']['type'];
    //Stores any error codes from the upload.
    $imageerror = $_FILES['uploadedFile']['error'];
    //Stores the tempname as it is given by the host when uploaded.
    $imagetemp = $_FILES['uploadedFile']['tmp_name'];
  
    //The path you wish to upload the image to
    $imagePath = $_SERVER["DOCUMENT_ROOT"]."/Images/" . $_POST['filename'];

    $filename = $_POST['filename'];

    if ($_FILES['uploadedFile']['type'] == "image/jpeg")
    {
      $imagePath = $imagePath . ".jpg";
      $filename = $filename . ".jpg";
    }
    else
    {
      $imagePath = $imagePath . ".png";
      $filename = $filename . ".png";
    }
  
    if(is_uploaded_file($imagetemp)) {
        if(move_uploaded_file($imagetemp, $imagePath)) {
            $status = "Bild erfolgreich hochgeladen.";
        }
        else {
            $status = "Hochladen fehlgeschlagen."; //"Failed to move your image.";
        }
    }
    else {
      $status = "Hochladen fehlgeschlagen."; //echo "Failed to upload your image.";
    }

    /* Bild in DB speichern */
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=webapp', "admin", "webapp99");

      $queryString = "insert into images (authorid, filename, title, description) values ('0', '" . $filename . "', '" . $_POST['title'] ."', '" . $_POST['description'] . "')";

      echo $queryString;

      $qR = $dbh->query($queryString);
    } catch (PDOException $e) {
      echo "Fehler beim MYSQL: " . $e->getMessage();
    }
  }
?>

<html>
  <head>
    <style>
      * {
        margin: 0px;
        padding: 0px;
      }

      #uploadHolder {
        position: relative;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 30vh;
        height: fit-content;
        background-color: gray;
        padding: 2.5vh;
        border-radius: 2vh;
      }
      
      #uploadBackground {
        background-color: rgba(0,0,0,0.6);
        width: 100vw;
        height: 100vh;
      }

      .inputfield
      {
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 2vh;
      }

      .inputLabel
      {
        position: relative;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div id="uploadBackground">
      <div id="uploadHolder">
        <form action="." method="post" enctype="multipart/form-data">
          <h1 style="text-align: center; font-family: Arial; font-size: 3vh; margin: 2vh 0vh 5vh 0vh;">IMAGE UPLOADING</h1>
          <input class="inputfield" type="file" name="uploadedFile" id="uploadedFile">
          <p class="inputLabel">Filename</p>
          <input class="inputfield" type="text" name="filename" id="filename"><br>
          <p class="inputLabel">Title</p>
          <input class="inputfield" type="text" name="title" id="filename"><br>
          <p class="inputLabel">Description</p>
          <textarea name="description" class="inputfield" cols="40" rows="5"></textarea>
          <input class="inputfield" type="submit" value="Upload Image" name="submit">
        </form> 

        <p>status: <?php echo $status; ?></p>
      </div>
    </div>

  </body>
</html> 