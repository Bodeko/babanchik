<?php
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project WHERE completed = FALSE AND ISNULL(contractor_id);");
    $stmt->execute();
    $open_projs = $stmt->get_result()->fetch_row()[0];
?>
<h1 class="centered-text">Шукайте роботу серед <?=$open_projs?> відкритих фриланс-проєктів</h1>
<div id="index-projects-main-block">
    <?php require("../fragments/projtypes.php");?>

    <div id="index-projects-secondary-block">
        <div id="index-projects-picture-block">
            <img src="../images/Women%20Programmer.jpeg.img.jpeg"/>
        </div>


    </div>
</div>

