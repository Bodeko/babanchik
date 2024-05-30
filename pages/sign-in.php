<?php
$missing = @$_GET['missing'];
$failed = @$_GET['failed'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
require("../connect/language.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign-in page</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/sign-in.css">
    </head>

    <body>
    <div id="sign-in-block-main">
        <form action="sign-in-action.php" method="post">
     <?php
        if ($failed){
            ?>
            <p class="errmsg"><?=$MSG['mismatch_lp']?></p>
        <?php
        }
    ?>
            <?php
                if(array_key_exists('login', $mfieldkeys)){
                    ?>
                        <div class="warning-label">
                            <label class="errmsg"><?=$MSG['fill_in']?></label>
                        </div>
            <?php
                }
            ?>
                <div class="double-row">
                <label for="login" class="block-label-white"><?=$MSG['your_login']?></label>
                <input name="login" id="login" type="text">
            </div>
            <br/>
            <?php
            if(array_key_exists('password', $mfieldkeys)){
                ?>
                <label class="errmsg"><?=$MSG['fill_in']?></label>
                <br/>
                <?php
            }
            ?>
                <div class="double-row">
                <label for="password" class="block-label-white"><?=$MSG['your_password']?></label>
                <input name="password" id="password" type="password">
            </div>
            <button type="submit" class="block-label-blue" id="sign-in-button"><?=$MSG['the_login']?></button>
        </form>
     </div>
    <div id="sign-in-block-picture" class="centered-text">
        <img src="../images/цвеееет.png">
    </div>
    </body>
</html>
