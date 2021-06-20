<?php 
    function generateImageBox($imageLocation, $id) {
        echo
        "
        <div class=\"imageHolder\">
            <div class=\"imageHolder_imageBox\">
                <img class=\"imageHolder_image\" src=\"../Images/" . $imageLocation . "\" alt=\"reference image from DB\">
            </div>
            <div class=\"imageHolder_buttonBar\">
                <button class=\"imageHolder_button\"><img class=\"buttonIcon\" src=\"/Icons/eye.png\" onclick=\"window.location.replace('/WebApp/imageViewer/?id=" . $id . "')\"></button>
                <button class=\"imageHolder_button\"><img class=\"buttonIcon\" src=\"/Icons/pen.png\" onclick=\"window.location.replace('/WebApp/imageTaggingNew/?id=" . $id ."')\"></button>
                <button class=\"imageHolder_button\"><img class=\"buttonIcon\" src=\"/Icons/trash.png\" onclick=\"setDeleteId($id)\"></button>
            </div>
        </div>
        ";
    }

    function generateUpload() {
        echo
        "
        <div id=\"imageBox_uploadHolder\">
            <p id=\"imageBox_uploadText\" onclick=\"showDialog()\">+</p>
        </div>
        ";
    }
?>
