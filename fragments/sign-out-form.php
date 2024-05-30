
                    <!--    Obsolete. Replaced by fragments/top-pane.php.   -->

<?php
if(@$login){
    ?>


    <form action="sign-out-action.php" method="post">
        <?=$MSG['user_current']?>: <strong><?=$first_name?> <?=$last_name?></strong>
        <button type="submit" name="submit" style="background-color: red"><?=$MSG['user_log_out']?></button>
        <a href="user.php"><?=$MSG['user_profile']?></a>
    </form>
    <?php
}
else {
    ?><?=$MSG['user_unknown']?>
    <a href="sign-in.php"><?=$MSG['user_sign_in']?></a>
    <?=$MSG['user_sign_or']?>
    <a href="register.php"><?=$MSG['user_sign_up']?></a>.
<?php
}
?>
