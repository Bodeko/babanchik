<!DOCTYPE html>
<html>
<head>
    <title>Profile page.</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php
        require_once("../connect/session.php");
        require_once("../fragments/vignettes.php");
        check_auth_or_redirect(true);

        require("../fragments/top-pane.php");




        $missing = @$_GET['missing'];
        $mfieldlist = explode(" ", $missing);
        $mfieldkeys = array_flip($mfieldlist);
    ?>
    <?php
    if(array_key_exists("id", $_GET)){
        $id = 0 + $_GET['id'];
    }
    else{
        $id = 0 + $login_id;
    }

    $stmt = $mysqli->prepare("SELECT login as userlogin, first_name, last_name, role, image_data, info FROM Participant WHERE id = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($result = $stmt->get_result()){
        extract($result->fetch_assoc());
        ?>
        <h2 class="centered-text"><?=$first_name?> <?=$last_name?></h2>

        <p class="centered-text"><?=$MSG['you_are']?> <strong><?=$MSG[$role]?></strong>.</p>
        <div class="double-row">
            <div class="centered-text block-label-bordered-black" style="padding: 2%"><?=$MSG['your_login']?></div>
            <div class="centered-text block-label-bordered-black" style="padding: 2%;"><?=$userlogin?></div>
        </div>
        <?php

            if($role=='contractor'){
                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project WHERE contractor_id = ?;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $undertaken_projects = $stmt->get_result()->fetch_row()[0];

                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project WHERE contractor_id = ? AND completed = TRUE;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $finished_projects = $stmt->get_result()->fetch_row()[0];

                ?>
                    <!-- Add a whole list of projects when projects will exist, damn it!-->
                    <div class="double-row">
                        <div class="block-label-bordered-black centered-text" style="padding: 2%"><?=$MSG['projects_open']?>: <?=$undertaken_projects?></div>
                        <div class="block-label-bordered-black centered-text" style="padding: 2%"><?=$MSG['projects_completed']?>: <?=$finished_projects?></div>
                    </div>
                <?php
            }

            else{
                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project WHERE client_id = ?;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $projects_posted = $stmt->get_result()->fetch_row()[0];

                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project WHERE client_id = ? AND completed = TRUE;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $had_projects_finished = $stmt->get_result()->fetch_row()[0];

                ?>

                    <div class="double-row">
                        <div class="block-label-bordered-black centered-text" style="padding: 2%"><?=$MSG['projects_open']?>: <?=$projects_posted?></div>
                        <div class="block-label-bordered-black centered-text" style="padding: 2%"><?=$MSG['projects_completed']?>: <?=$had_projects_finished?></div>
                    </div>
                <?php
            }
        ?>
            <div class="centered-text">
                <?php
                    $stmt = $mysqli->prepare("SELECT image_data FROM Participant WHERE id = ?;");
                    $stmt -> bind_param("i", $id);
                    $stmt->execute();
                    if($stmt->get_result()->fetch_row()[0]){
                ?>
                    <img style="max-width: 25%" src="../uploads/image<?=$id?>" alt="Profile image.">
                <?php
                    }
                    else{
                        ?> <p>No image.</p> <?php
                    }
                ?>
            </div>
        <?php

        if($login_id == $id){
            ?>
            <blockquote>
                <form action="change-image-action.php" method="POST" class="centered-text" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?=$id?>"/>
                    <div class="double-row">
                        <input class="centered-text" type="file" name="file" id="file">
                        <button type="submit" class="block-label-blue"><?=$MSG['change_i']?></button>
                    </div>
                </form>
            </blockquote>

            <h2 class="centered-text"><?=$MSG['this_is_you']?></h2>
            <?php
            if($role=='contractor'){
            ?>
                <blockquote>
                    <form action="change-types-action.php" method="POST" class="centered-text">
                        <input type="hidden" id="id" name="id" value="<?=$id?>">
                        <div class="double-row">
                            <label class="block-label-bordered-black" style="padding: 2%"><?=$MSG['types']?>:</label>
                            <div class="block-label-bordered-black"  style="padding: 2%">
                                <?php
                                    $stmt = $mysqli->prepare("SELECT * FROM ProjectType;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while($TYPE = $result->fetch_assoc()){
                                ?>
                                        <input type="checkbox" id="<?=$TYPE['title']?>" name="<?=$TYPE['title']?>"
                                        <?php
                                            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM ParticipantsTypes WHERE participant_id = ? AND projecttype_id = ?;");
                                            $stmt -> bind_param("ii", $id, $TYPE['id']);
                                            $stmt -> execute();

                                            if($stmt->get_result()->fetch_row()[0]){
                                                ?>
                                                    checked
                                                <?php
                                            }
                                        ?>

                                        >
                                        <label for="<?=$TYPE['title']?>"><?=$TYPE['title']?></label>
                                        <br/>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <button type="submit" class="block-label-blue"><?=$MSG['change_types']?></button>
                    </form>
                </blockquote>
            <?php
            }
            ?>
            <blockquote>
                    <form action="change-password-action.php" method="POST" class="centered-text">
                        <input type="hidden" name="user_id" value="<?=$id?>"/>
                        <?php
                            require("../fragments/password-entry.php");
                        ?>
                        <button type="submit" class="block-label-blue"><?=$MSG['change_p']?></button>
                    </form>
                </blockquote>

            <blockquote>
                <form action="change-info-action.php" method="POST" class="centered-text" style="display: grid; grid-template-rows: 4fr 1fr">
                    <input type="hidden" name="user_id" value="<?=$id?>"/>
                    <input type="text" name="info" value="<?=$info?>"/>
                    <button type="submit" class="block-label-blue"><?=$MSG['change_inf']?></button>
                </form>
            </blockquote>
            <?php
        }
        else{
            ?>
            <blockquote  class="centered-text block-label-bordered" style="display: grid; grid-template-rows: 5fr; padding: 2%">
                    <?=$info?>
            </blockquote>
            <?php
        }
    }
    ?>
</html>

