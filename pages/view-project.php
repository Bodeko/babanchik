<?php
require_once("../connect/session.php");
require_once("../fragments/vignettes.php");

$id = 0 + $_GET['id'];
$PRJ = retrieve_project($id);
check_auth_or_redirect($PRJ);     //  At least because comments.
$is_my_project = $login_id == $PRJ['client_id'];
$PRJ = array_map("htmlspecialchars", $PRJ);


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
<form action="delete-project-action.php" class="double-row" method="post">
    <label for="title" class="block-label-white"><?=$MSG['project_name']?></label>
    <label id="title" class="transparent-input"><?=$PRJ['title']?></label>
    <label for="description" class="block-label-white"><?=$MSG['project_desc']?></label>
    <label id="description" class="transparent-input"><?=multiline($PRJ['description'])?></label>
    <label for="type" class="block-label-white"><?=$MSG['project_type']?></label>
    <label id="type" class="transparent-input"><?=$PRJ['type']?></label>
    <label for="price" class="block-label-white"><?=$MSG['project_reward']?></label>
    <div class="payment">
        <label id="price" class="transparent-input"><?=$PRJ['price']?></label>
        <label id="currency" class="block-label-white"><?=$MSG['currency_uah']?></label>
    </div>

    <label for="client" class="block-label-white"><?=$MSG['client']?>: </label>
    <label id="client" class="transparent-input"><a href="user.php?id=<?=$PRJ['client_id']?>"><?=$PRJ['client']?></a></label>
    <label for="date" class="block-label-white"><?=$MSG['project_date']?>: </label>
    <label id="date" class="transparent-input"><?=$PRJ['sent_time']?></label>

    <label for="completed" class="block-label-white"><?=$MSG['project_completed']?>? </label>
    <label id="completed" class="transparent-input"><?=$MSG[$PRJ['completed']?"yes":"no"]?></label>
    <label for="contractor" class="block-label-white"><?=$MSG['contractor']?>: </label>
    <label id="contractor" class="transparent-input"><?=$PRJ['contractor']?></label>
    <?php if($is_customer /* redundant; extra caution */ && $PRJ['client_id'] == $login_id && !$PRJ['completed']) {
        if($PRJ['contractor_id']) {
            ?>
                <div class="double-row">
                    <button type="submit" name="revoke" class="block-label-red"><?=$MSG['action_revoke']?></button>
                    <button type="submit" name="finish" class="block-label-blue"><?=$MSG['action_finish']?></button>
                </div>
            <?php
        } else {
            ?><a href="edit-project.php?id=<?=$id?>" class="block-label-blue"><?=$MSG['action_edit']?></a><?php
        } ?>
        <button type="submit" name="delete" class="block-label-red"><?=$MSG['action_delete']?></button>
    <input type="hidden" id="id" name="id" value="<?=$id?>">
    <?php } ?>
</form>
<?php
include("../fragments/commentary-div.php");

if($is_contractor || $is_my_project) { // commentaries can be left by freelancers or the publisher himself
    include ("../fragments/commentary-form.php");
}
?>

</body>
<?php

