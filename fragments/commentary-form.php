<form action="add-commentary-action.php" method="post" class="commentary">
    <div class="double-row">
        <label for="participant" class="block-label-white"><?=$MSG['user']?>:</label>
        <label id="participant" class="transparent-input">(<?=$MSG['you']?>)</label>
    </div>
    <label for="message" class="<?=field_label_style('message')?>"><?=$MSG['comment']?>:</label>
    <label></label>
    <input id="message" name="message" class="transparent-input">
    <label></label>
    <input type="hidden" id="id" name="id" value="<?=$id?>">
    <button type="submit" class="block-label-blue"><?=$MSG['comment_send']?></button>
</form>
