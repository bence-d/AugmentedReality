<html>
    <head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&display=swap" rel="stylesheet">

        <style>
            * {
                margin: 0px;
                padding: 0px;
            }

            #headerBar
            {
                width: 100vw;
                height: 10vh;
                background-color: white;
                box-shadow: 0px 0px 4px 0px #000000;
            }
            
            #headerBar_homeButton {
                box-shadow: 0px 0px 4px 0px #000000;
                background:linear-gradient(to bottom, #ffffff 5%, #ffffff 100%);
                background-color:#ffffff;
                border-radius:8px;
                border:1px solid #ffffff;
                display:inline-block;
                cursor:pointer;
                color:#ffffff;
                font-family:Arial;
                font-size:17px;
                padding:15px 15px;
                text-decoration:none;
                text-shadow:0px 1px 0px #ffffff;
                position: relative;
                top: 50%;
                left: 2vh;
                transform: translateY(-50%);
                margin-right: 1vh;
            }

            #headerBar_staticButton {
                box-shadow: 0px 0px 4px 0px #000000;
                background:linear-gradient(to bottom, #ffffff 5%, #ffffff 100%);
                background-color:#ffffff;
                border-radius:8px;
                border:1px solid #ffffff;
                display:block;
                cursor:pointer;
                color:#ffffff;
                font-family:Arial;
                font-size:17px;
                padding:15px 15px;
                text-decoration:none;
                text-shadow:0px 1px 0px #ffffff;
                position: absolute;
                top: 5vh;
                left: 10vh;
                transform: translateY(-50%);
                margin-right: 1vh;
            }

            #headerBar_title {
                position: relative;
                text-align: center;
                top: -4vh;
                font-family: "Lato";
                color: rgb(80,80,80);
                font-size: 5vh;
                width: fit-content;
                left: 50%;
                transform: translateX(-50%);
            }

            #verticalRuler {
                width: 1px;
                height: 6vh;
                background-color: black;
                position: absolute;
                right: 20vh;
                top: 2.2vh;
            }

            #arlogo {
                position: absolute;
                right: 3.2vh;
                top: 0.2vh;
                width: 143px;
                height: 88px;
            }

            .buttonIcon {
                width: 3vh;
                heihgt: 3vh;
            }

            .buttonIcon:hover {
                cursor: pointer;
            }
            
        </style>
    </head>

    <body>
        
    </body>
</html>

<?php 
    function getHeader($staticButton, $title)
    {
        if ($staticButton == true)
        {
            echo "
            <div id=\"headerBar\">
            <button id=\"headerBar_staticButton\"><img class=\"buttonIcon\" src=\"/Icons/newspaper.png\" onclick=\"window.location.replace('../')\"></button>
            <button id=\"headerBar_homeButton\"><img class=\"buttonIcon\" src=\"/Icons/house.png\" onclick=\"window.location.replace('/imageList/')\"></button>
            <h1 id=\"headerbar_title\">" . $title ."</h1>
            <div id=\"verticalRuler\"></div>
            <img id=\"arlogo\" src=\"/logo.png\" alt=\"AR LOGO\">
            </div>
            ";
        } 
        else
        {
            echo "
            <div id=\"headerBar\">
            <button id=\"headerBar_homeButton\"><img class=\"buttonIcon\" src=\"/Icons/house.png\" onclick=\"window.location.replace('/imageList/')\"></button>
            <h1 id=\"headerbar_title\">" . $title ."</h1>
            <div id=\"verticalRuler\"></div>
            <img id=\"arlogo\" src=\"/logo.png\" alt=\"AR LOGO\">
            </div>
            ";
        }
    }
?>
