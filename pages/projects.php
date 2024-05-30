<!DOCTYPE html>
<html lang="<?=$locale?>">
<head>
    <title>Projects page.</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/projects.css">
</head>
<body>
<?php
    require_once("../connect/session.php");
    require("../fragments/top-pane.php");


?>


<div id="projects-wrapper">
    <div id="projects-top-grid">
        <?php require("../fragments/projtypes.php");?>
        <div id="projects-main-block">
            <?php       //  Preparations.
                    $stmt = $mysqli -> prepare("SELECT COUNT(*) FROM Project WHERE projecttype_id = ?;");
                    $stmt->bind_param("i", $cat);
                    $stmt->execute();

                    $projects_of_type_amount = $stmt->get_result()->fetch_row()[0];
                    $projects_on_page = 10;
                    $pages = intval($projects_of_type_amount/$projects_on_page);
                    $page = is_null($_GET['page'])?0:$_GET['page'];
            ?>
            <div id="projects-page-panel" class="centered-text block-label-bordered">
                        <a href="../pages/projects.php?cat=<?=$cat?>&page=<?=0?>"><<</a>
                        <a href="../pages/projects.php?cat=<?=$cat?>&page=<?=($page>0?$page-1:0)?>"><</a>
                        <a href="../pages/projects.php?cat=<?=$cat?>&page=<?=$page?>"><?=$page+1?></a>
                        <a href="../pages/projects.php?cat=<?=$cat?>&page=<?=($pages>0?($page<$pages-1?$page+1:$pages-1):0)?>">></a>
                        <a href="../pages/projects.php?cat=<?=$cat?>&page=<?=($pages>0?$pages-1:0)?>">>></a>
            </div>
            <?php
                if($projects_of_type_amount > 0){
                    $projects_on_current_page =
                        ($page==0?
                            ($projects_of_type_amount%$projects_on_page==0?
                                $projects_of_type_amount:
                                $projects_of_type_amount%$projects_on_page):
                            $projects_on_page
                        );

                    $stmt = $mysqli->prepare("SELECT * FROM Project WHERE projecttype_id = ? AND completed = FALSE;");
                    $stmt->bind_param("i", $cat);
                    $stmt->execute();
                    $projects = array_reverse($stmt->get_result()->fetch_all());

                    for($i = 0; $i<$projects_on_current_page; ++$i){
                        ?>
                            <a class="block-label-bordered centered-text" style="padding: 1%" href="../pages/view-project.php?id=<?=$projects[$i][0]?>">
                                <strong><?=$projects[$i][1]?></strong>
                                <?php
                                    $stmt = $mysqli->prepare("SELECT first_name, last_name FROM Participant WHERE id = ?;");
                                    $stmt->bind_param("i", $projects[$i][3]);
                                    $stmt->execute();
                                    $participant = $stmt->get_result()->fetch_row();
                                ?>
                                <?=$MSG['published_by']?>: <strong><?=$participant[0]?> <?=$participant[1]?></strong>
                            </a>

                        <?php
                    }
                }
                else{
                    ?>
                        <div class="block-label-bordered centered-text" style="padding: 1%"><?=$MSG['no_projects']?></div>
                    <?php
                }
                ?>
        </div>
    </div>
</div>
</body>

