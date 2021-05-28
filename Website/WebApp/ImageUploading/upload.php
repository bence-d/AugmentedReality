<?php
    $file = $_FILES["uploadedFile"]["tmp_name"];
    $file_name = $_FILES["uploadedFile"]["name"];
    $path = "images\\" . $file_name;

    if(isset($_POST["submit"])) {
      $check = getimagesize($file);
      if($check !== false) {
          move_uploaded_file($file, $path);
          echo "<img src=". $path ." ></img>";
      }
    }
?>