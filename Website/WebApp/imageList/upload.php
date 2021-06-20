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
    $imagePath = $_SERVER["DOCUMENT_ROOT"]."/WebApp/Images/" . $_POST['filename'];

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

      //echo $queryString;

      $qR = $dbh->query($queryString);
    } catch (PDOException $e) {
      echo "Fehler beim MYSQL: " . $e->getMessage();
    }
  }
?>

<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&display=swap" rel="stylesheet">


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
        width: 35vh;
        height: fit-content;
        background-color: white;
        padding: 2.5vh;
        box-shadow: 0px 0px 5vh rgba(0,0,0,0.2);
      }
      
      #uploadBackground {
        position: fixed;
        z-index: 3;
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
        height: 6vh;
        width: 20vh;
        background-color: rgba(240,240,240,1);
        border: 1px solid gray;
      }

      .shortInput {
        text-align: center;
      }

      .input_textarea {
        width: 30vh;
        height: 10vh;
        padding: 1vh;
      }

      .inputfield:focus {
        outline: none;
      }

      .inputLabel
      {
        font-family: "Lato";
        color: rgba(90,90,90,1);
        position: relative;
        text-align: center;
        margin-bottom: 0.5vh;
      }

      .hide {
        display: none;
      }

      .show {
        display: block;
      }

      #uploadedFile {
        position: relative;
        color: rgba(0,0,0,0);
        left: 50%;
        transform: translateX(-22%);
      }

      input:active, input:enabled, input:focus, {
        outline: none;
      }

      #uploadTitle {
        text-align: center;
        font-family: "Lato";
        color: rgba(100,100,100,1);
        font-size: 4vh;
        font-weight: 750;
        margin: 2vh 0vh 2vh 0vh;
      }

      #uploadedFileButton {
        position: relative;
        left: 31%;
        width: 20vh;
        height: 15vh;
        padding: 1.5vh;
        border: 1px solid gray;
        margin-bottom: 2vh;
        font-family: "Lato";
        font-weight: 600;
        color: rgba(60,60,60,1);
      }

      #uploadedFileButton:hover {
        color: rgba(120,120,120,1);
        background-color: rgba(220,220,220,1);
        cursor: pointer;
      }

      #uploadButton {
        background:linear-gradient(to bottom, #44c767 5%, #38a354 100%);
        background-color:#44c767;
        border-radius:10px;
        border:1px solid #ffffff;
        display:block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:18px;
        font-weight:bold;
        padding:10px 51px;
        text-decoration:none;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 0.5vh;
      }

      #uploadButton:hover {
        background:linear-gradient(to bottom, #3bad5a 5%, #318f49 100%);
      }

      #cancelButton {
        background:linear-gradient(to bottom, #c74545 5%, #a33838 100%);
        background-color:#c74545;
        border-radius:10px;
        border:1px solid #ffffff;
        display:block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:18px;
        font-weight:bold;
        padding:10px 81px;
        text-decoration:none;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
      }

      #cancelButton:hover {
        background:linear-gradient(to bottom, #a13838 5%, #872e2e 100%);
      }

    </style>
  </head>
  <body>
    <div id="uploadBackground" class="hide">
      <div id="uploadHolder">
        <form action="." method="post" enctype="multipart/form-data">
          <h1 id="uploadTitle">IMAGE UPLOAD</h1>
          <hr style="margin-bottom: 5vh;">
          <label for="uploadedFile" id="uploadedFileButton">SELECT FILE</label>
          <input class="inputfield" type="file" name="uploadedFile" id="uploadedFile" hidden>
          <p class="inputLabel" style="margin-top: 4vh;">FILENAME</p>
          <input class="inputfield shortinput" type="text" name="filename" id="filename"><br>
          <p class="inputLabel">TITLE</p>
          <input class="inputfield shortinput" type="text" name="title" id="filename"><br>
          <p class="inputLabel">DESCRIPTION</p>
          <textarea name="description" class="inputfield input_textarea" cols="40" rows="5"></textarea>
          <input id="uploadButton" type="submit" value="Upload Image" name="submit">
        </form> 

        <button id="cancelButton" onclick="hideDialog()">Cancel</button>
      </div>
    </div>

  </body>

  <script>
  function showDialog() {
    document.getElementById('uploadBackground').classList.remove('hide');
    document.getElementById('uploadBackground').classList.add('show');
  }

  function hideDialog() {
    document.getElementById('uploadBackground').classList.remove('show');
    document.getElementById('uploadBackground').classList.add('hide');
  }
  </script>
</html> 