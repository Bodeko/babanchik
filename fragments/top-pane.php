<?php

require_once("../connect/session.php");
?>
<div id="top-panel" style="text-align: center">
<?php
if(!@$login){   //  Basic panel.
    ?>
    <div style="display: grid; grid-template-columns: 3fr 3fr">
        <a style="text-decoration: none; color: black; padding: 2%" href="../pages/index.php"><strong>Free</strong>lance</a>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr)">
            <a class="block-label-blue" href="../pages/sign-in.php"><?=$MSG['the_login']?></a>
            <a class="block-label-blue" href="../pages/register.php"><?=$MSG['the_registration']?></a>
        </div>
    </div>
    <?php
} elseif($is_contractor){   //  Contractor panel.
    ?>
    <div style="display: grid; grid-template-columns: 3fr 3fr">
        <a style="text-decoration: none; color: black; padding: 2%" href="../pages/index.php"><strong>Free</strong>lance</a>
        <div >
            <form action="sign-out-action.php" method="post" class="double-row">
                <button type="submit" name="submit" class="block-label-red"><?=$MSG['user_log_out']?></button>
                <a href="user.php" class="block-label-blue"><?=$MSG['user_profile']?></a>
            </form>
        </div>
    </div>
    <?php
}else{                      //  Client panel.
    ?>
    <div style="display: grid; grid-template-columns: 3fr repeat(3, 1fr) 3fr">
        <a style="text-decoration: none; color: black; padding: 2%" href="../pages/index.php"><strong>Free</strong>lance</a>
        <a style="text-decoration: none; color: black; padding: 2%" href=""><?=$MSG['my_projects']?></a>
        <a style="text-decoration: none; color: black; padding: 2%" href="../pages/projects.php"><?=$MSG['projects']?></a>
        <a style="text-decoration: none; color: black; padding: 2%" href=""><?=$MSG['contractors']?></a>
            <form action="sign-out-action.php" method="post">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr)" class="centered-text">
                <a class="block-label-blue" href="../pages/add-project.php"><?=$MSG['new_project']?></a>
                <button type="submit" name="submit" class="block-label-red"><?=$MSG['user_log_out']?></button>
                <a href="user.php" class="block-label-blue"><?=$MSG['user_profile']?></a>
                </div>
            </form>
    </div>
    <?php

}
?>
</div>

