<?php

function display_projects($rows) {
    global $MSG;
    ?><ul><?php
    while($PRJ = $rows->fetch_assoc()) {
        ?><li><a href="view-project.php?id=<?=$PRJ['id']?>"><?=$PRJ['title']?></a><?php
            if($PRJ['contractor_id']) {
                ?> (<?=$MSG['contractor_assigned']?>:
                <a href="user.php?id=<?=$PRJ['contractor_id']?>"><?=$PRJ['contractor']?></a>)<?php
            }
        ?></li><?php
    }
    ?></ul><?php
}

function display_projects_or($rows) {
    global $MSG;
    if($rows->num_rows) {
        display_projects($rows);
    } else {
        ?> <?=$MSG["projects_none"]?> <?php
        $rows->close();
    }
}

if($is_contractor) {    //  Contractor.
    $mine = $mysqli->prepare(PROJECT_QUERY . " WHERE contractor_id=? AND completed=?");
    $comp = 0;
    ?><h1 class="centered-text"><?=$MSG['projects_your']?></h1><?php
    // my bids (assigned)
    ?>
        <div class="double-row">
            <div class="block-label-bordered-black centered-text">
                <h2><?=$MSG['projects_assigned']?></h2>
            </div>
            <div class="block-label-bordered-black centered-text" style="padding: 2%">
    <?php
                $mine->bind_param("ii", $login_id, $comp); // binding is by reference!
                $mine->execute();
                display_projects_or($mine->get_result());
    ?>
            </div>
        </div>

            <div class="double-row">
                <div class="block-label-bordered-black centered-text">
                    <h2><?=$MSG['projects_offered']?></h2>
                </div>
                <div class="block-label-bordered-black centered-text" style="padding: 2%">
                    <?php
    // my bids (open)
                    $open = $mysqli->prepare(
                        "SELECT Commentary.id AS comment_id, Commentary.text_data, Commentary.sent_time as comm_time, Project.*,
                            CONCAT(Participant.first_name, ' ', Participant.last_name) as `client`
                        FROM Commentary
                            INNER JOIN Project ON Project.id = project_id
                            INNER JOIN Participant ON Participant.id = client_id
                         WHERE Commentary.id IN (SELECT MAX(Commentary.id) FROM Commentary GROUP BY project_id) AND participant_id=?
                         ORDER BY project_id DESC");
                    $open->bind_param("i", $login_id);
                    $open->execute();
                    $rows = $open->get_result();
                    if($rows->num_rows) {
                        ?><dl><?php
                        while($row = $rows->fetch_assoc()) {
                            $row = array_map("htmlspecialchars", $row); // FIXME: must be applied to all dashboard data, or else.
                            ?><dt><a href="view-project.php?id=<?=$row['id']?>"><?=$row['title']?></a>
                                (<a href="user.php?id=<?=$row['client_id']?>"><?=$row['client']?></a>)</dt>
                            <dd><?=$row['text_data']?> (<?=$row['comm_time']?>)</dd><?php
                        }
                        ?></dl><?php
                    } else {
                        ?><?=$MSG["projects_none"]?><?php
                        $open->close();
                    }
    ?>
                </div>
            </div>

            <div class="double-row">
                <div class="block-label-bordered-black centered-text">
                    <h2><?=$MSG['projects_completed']?></h2>
                </div>
                <div class="block-label-bordered-black centered-text" style="padding: 2%">
    <?php

    // my bids (completed)

                    $comp = 1;
                    // not needed -- binding is by reference: $mine->bind_param("ii", $login_id, $comp);
                    $mine->execute();
                    display_projects_or($mine->get_result());

                    // open projects by category
                    $result = $mysqli->query("SELECT ProjectType.*, COUNT(Project.id) AS cnt FROM ProjectType
                        LEFT JOIN Project ON Project.projecttype_id = ProjectType.id GROUP BY ProjectType.id ORDER BY Title ASC");
                    $types = Array();
                    $cnts = Array();
                    while($row = $result->fetch_assoc()) {
                        if($row['cnt']) {
                            $types[$row['id']] = $row['title'];
                            $cnts[$row['id']] = $row['cnt'];
                        }
                    }
                    $cat = 0 + $_GET['cat'];


    ?>
                </div>
            </div>
    <?php
                    ?>
            <h1 class="centered-text"><a name="types"><?=$MSG['projects_all']?></a></h1>
            <div  class="centered-text">
    <?php
          if($cat) {
    ?>
                <div class="double-row">
                    <div class="block-label-bordered-black centered-text">
                        <h2><?=$types[$cat]?></h2>
                    </div>
                    <div class="block-label-bordered-black centered-text">
    <?php
                            $stmt = $mysqli->prepare(PROJECT_QUERY . " WHERE projecttype_id=? AND completed=0");
                            $stmt->bind_param("i", $cat);
                            $stmt->execute();
                            display_projects($stmt->get_result());

    ?>
                    </div>
                </div>
                <a href="index.php#types" ><?=$MSG['project_types_all']?></a><?php
                    } else {
                        ?><ul><?php
                        foreach($types as $tid => $title) {
                            ?><li><a href="index.php?cat=<?=$tid?>#types"><?=$title?> (<?=$cnts[$tid]?>)</a></li><?php
                        }
                        ?></ul><?php
                    }
    ?>
            </div>
    <?php

}
else {  //  Client.
    // my projects (open, completed)
    $stmt = $mysqli->prepare(PROJECT_QUERY . " WHERE client_id=? AND completed=?");
    $stati = Array(0 => 'projects_open', 1 => 'projects_completed');
    foreach($stati as $flag => $loc_key) {
        $stmt->bind_param("ii", $login_id, $flag);
        $stmt->execute();
        $rows = $stmt->get_result();
        ?>
            <div class="double-row">
                <div class="block-label-bordered-black centered-text">
                <h1><?=$MSG[$loc_key]?></h1>
                </div>
                <div class="block-label-bordered-black centered-text" style="padding: 2%">
                <?php
                display_projects_or($rows);
                ?>
                </div>
            </div>
        <?php
    }
}
?>
