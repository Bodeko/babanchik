<h1 class="centered-text">Вибирайте перевірених спеціалістів</h1>
<div id="index-gallery-main-block">
    <div id="index-gallery-projtypes" class="block-label-white">
        <ul id="index-gallery-projtypes-list">
            <?php
                $cat = $_GET['cat'];    //  Chosen category of projects.

                $stmt = $mysqli->prepare("SELECT id, title FROM ProjectType;");
                $stmt->execute();
                $result = $stmt->get_result();


                while ($TYPE = $result->fetch_assoc()){

                    if(is_null($cat)) $cat = $TYPE['id'];    //  Needed only if project type is not chosen.

                    if($cat == $TYPE['id']){
                        ?> <strong> <?php
                    }
                    ?>
                    <li><a href="index.php?cat=<?=$TYPE['id']?>"><?=$TYPE['title']?></a></li>
                    <?php

                    if($cat == $TYPE['id']){
                    ?> </strong> <?php
                    }
                }
            ?>
        </ul>
    </div>
    <div id="index-gallery-freelancers-secondary-blocks">
        <div id="index-gallery-secondary-pictures" >
        <?php
            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM ParticipantsTypes WHERE projecttype_id = ?;");
            $stmt->bind_param("i", $cat);
            $stmt->execute();

            $real_amount = $stmt->get_result()->fetch_row()[0];

            $stmt = $mysqli->prepare("SELECT ParticipantsTypes.participant_id FROM ParticipantsTypes INNER JOIN Participant "
                ."WHERE ParticipantsTypes.projecttype_id = ? AND Participant.image_data = TRUE;");
            $stmt->bind_param("i", $cat);
            $stmt->execute();



            $participant_ids = array_reverse($stmt->get_result()->fetch_all());
            for($i = 0; $i < 4 && $i < count($participant_ids); ++$i) {
                ?>
                <div class="index-gallery-secondary-picture ">
                    <a href="../pages/user.php?id=<?=$participant_ids[$i][0]?>">
                    <img src="../uploads/image<?=$participant_ids[$i][0]?>" class="index-gallery-secondary-picture rounded-image">
                    </a>
                </div>
                <?php
            }
        ?>
            </div>
            <div id="index-gallery-secondary-linkbox " class="block-label-bordered-black centered-text" style="padding: 8%">

                <a><?=$MSG['freelancers_of_type']?>: <?=$real_amount?></a>
            </div>
        </div>


</div>
<div id="index-gallery-secondary-block">

</div>