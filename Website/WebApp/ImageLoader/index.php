<?php
    try {
    $dbh = new PDO('mysql:host=localhost;dbname=webapp', "root", "");

    if (!isset($_GET["id"])) {
        echo "Please specify an image ID in the query string";
    }
    else {
        $qR = $dbh->query('SELECT * from images where id =' . $_GET["id"]);

        $result = $qR->fetchAll();
    
        echo "<img src='/images/" . $result[0][2] ."'>";
    
        echo '<br> ID: ' . $result[0][0] . '<br>';
        echo 'Author ID: ' . $result[0][1] . '<br>';
        echo 'filename: ' . $result[0][2] . '<br>';
        echo 'title: ' . $result[0][3] . '<br>';
        echo 'description: ' . $result[0][4] . '<br>';
        echo 'date: ' . $result[0][5] . '<br>';
        
        $dbh = null;
    }
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
?>
