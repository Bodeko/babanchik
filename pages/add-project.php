<?php
require_once("../connect/session.php");
require_once("../fragments/vignettes.php");

check_auth_or_redirect($is_customer);

require("../fragments/top-pane.php");
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <title><?=$MSG['project']?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/crud-project.css">
</head>
<body>

    <form action="set-project-action.php" method="post">
        <div class="double-row">
            <label for="title" class="<?=field_label_style('title')?>"><?=$MSG['project_name']?></label>
            <input id="title" name="title" class="transparent-input">
            <label for="type" class="<?=field_label_style('type')?>"><?=$MSG['project_type']?></label>
            <?php require("../fragments/project-type.php"); ?>
            <label for="description" class="<?=field_label_style('description')?>"><?=$MSG['project_desc']?></label>
            <textarea id="description" name="description" class="transparent-input"></textarea>
            <label for="price" class="<?=field_label_style('price')?>"><?=$MSG['project_reward']?></label>
            <div class="payment">
                <input name="price" id="price" type="number" class="transparent-input">
                <label id="currency" class="block-label-white"><?=$MSG['currency_uah']?></label>
            </div>
        </div>
        <button type="submit" class="block-label-blue"><?=$MSG['action_post']?></button>
    </form>

</body>
<?php

