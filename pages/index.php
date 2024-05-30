<?php
require_once("../connect/session.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$MSG[$login?'page_dashboard':'page_main']?></title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/index.css">
    </head>
    <body>
        <?php
            require("../fragments/top-pane.php");

            if(@$login){
                require("../fragments/dashboard.php");
                if($is_contractor) {
                    require ("../fragments/index-projects.php");
                }else{
                    require("../fragments/index-gallery.php");
                }
                require ("../fragments/index-info.php");
                require ("../fragments/index-faq.php");

             } else if(!@$_GET['short']) {
                require ("../fragments/index-intro.php");
                require ("../fragments/index-gallery.php");
                require ("../fragments/index-promotional.php");
                require ("../fragments/index-projects.php");
                require ("../fragments/index-info.php");
                require ("../fragments/index-faq.php");
            }
        ?>
    </body>

</html>
