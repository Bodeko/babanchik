<?php
$collision = @$_GET['collision'];
$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
require("../connect/language.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/styles.css">


    <title>Registration page.</title>
</head>
<body>

<div id="register-block-main">

    <form action="register-action.php" method="post">
        <?php
        if(array_key_exists('new_login', $mfieldkeys)){
            ?>
            <div class="warning-label">
                <label class="errmsg"><?=$MSG['fill_in_login']?></label>
            </div>
            
            <?php
        }
        else if($collision){
            ?>
            <div class="warning-label centered-text">
                <label class="errmsg"><?=$MSG['collision']?></label>
            </div>
            
            <?php
        }?>
            <div class="double-row"  style="margin: 2%">
                <label for="login" class="block-label-white"><?=$MSG['your_login']?></label>
                <input name="new_login" id="login" type="text"/>
            </div>


        <?php
        if(array_key_exists('first_name', $mfieldkeys)){
        ?>
            <div class="warning-label centered-text">
                <label class="errmsg"><?=$MSG['fill_in']?></label>
            </div>
        
        <?php
        }?>
            <div class="double-row" style="margin: 2%">
                <label for="first_name" class="block-label-white"><?=$MSG['your_name']?></label>
                <input name="first_name" id="first_name" type="text">
            </div>

        <?php
        if(array_key_exists('last_name', $mfieldkeys)){
            ?>
            <div class="warning-label centered-text">
                <label class="errmsg"><?=$MSG['fill_in']?></label>
            </div>
            
            <?php
        }?>
            <div class="double-row" style="margin: 2%">
                <label for="last_name" class="block-label-white"><?=$MSG['your_surname']?></label>
                <input name="last_name" id="last_name" type="text">
            </div>


        <?php
        if(array_key_exists('role', $mfieldkeys)){
            ?>
            <div class="warning-label centered-text">
                <label class="errmsg"><?=$MSG['fill_in']?></label>
            </div>
            
            <?php
        }?>
            <div class="double-row" style="margin: 2%">
                <label for="role" class="block-label-white"><?=$MSG['your_role']?></label>
                <select name="role" id="role" class="block-label-blue">
                    <option value="contractor">Freelancer</option>
                    <option value="client">Client</option>
                </select>
            </div>


        <?php
            require("../fragments/password-entry.php")
        ?>

            <button type="submit" class="block-label-blue" id="register-button"><?=$MSG['the_registration']?></button>
    </form>
</div>
<div id="register-block-picture" class="centered-text">
    <img src="../images/xSKQKrUdIшетер1E.AIT)%20копия.png">
</div>
</body>
</html>
