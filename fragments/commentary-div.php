<?php
$comments = retrieve_comments($id);
while($comment = $comments->fetch_assoc()) {
    $comment = array_map("htmlspecialchars", $comment);
    $is_assigned = $PRJ['contractor_id'] == $comment['participant_id'];
    $is_own_comm = $comment['participant_id'] == $login_id;
    $is_ass_able = $PRJ['client_id'] == $login_id;
?>
<form class="commentary" action="<?=($is_own_comm
        ?'delete-commentary-action.php'
        :'assign-contract-action.php')
    ?>" method="post">
    <input id="participant-id" name="participant-id" type="hidden">
    <div class="double-row">
        <label for="participant" class="block-label-white"><?=$MSG['user']?>:</label>
        <label id="participant" class="transparent-input">
            <a href="user.php?id=<?=$comment['participant_id']?>"><?=$comment['author']?></a>
        </label>
    </div>
    <div class="double-row">
        <label for="message" class="block-label-white"><?=$MSG['comment']?>:</label>
        <label></label>

    </div>
    <label id="message" class="transparent-input"><?=multiline($comment['text_data'])?></label>
    <div class="double-row">
        <label for="date" class="block-label-white"><?=$MSG['comment_date']?>:</label>
        <label id="date" class="transparent-input"><?=multiline($comment['sent_time'])?></label>
    </div>
    <?php 
    if($is_assigned) {
        ?><label class="block-label-blue"><?=$MSG['contractor_assigned']?></label><?php
    } else if($is_own_comm) {
        ?><input type="hidden" id="id" name="comment_id" value="<?=$comment['id']?>">
        <button type="submit" class="block-label-red"><?=$MSG['action_delete']?></button><?php
    } else if($is_ass_able) {
        ?><input type="hidden" id="id" name="contractor_id" value="<?=$comment['participant_id']?>">
        <button type="submit" class="block-label-blue"><?=$MSG['action_assign']?></button><?php
    }
    ?>
    <input type="hidden" id="id" name="id" value="<?=$id?>">
</form>
<?php
}
?>
<a name="end"></a>
