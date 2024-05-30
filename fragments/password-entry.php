<?php
if(array_key_exists('password', $mfieldkeys)){
    ?>
    <label class="errmsg"><?=$MSG['fill_in']?></label>
    <br/>
    <?php
}
?>
    <div class="double-row" style="margin: 2%">
        <label for="password" class="block-label-white"><?=$MSG['new_p']?></label>
        <input name="password" id="new_password" type="password" autocomplete="new-password">
    </div>
<?php
if(@$_GET['passmatch']){
    ?>
    <label class="errmsg"><?=$MSG['mismatch_p']?></label>
    <br/>
    <?php
}?>
    <div class="double-row" style="margin: 2%">
        <label for="password" class="block-label-white"><?=$MSG['retype_p']?></label>
        <input name="passcopy" id="copy_password" type="password" autocomplete="new-password">
    </div>
