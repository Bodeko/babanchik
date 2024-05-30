<div id="index-projects-projtypes" class=" block-label-white">
    <ul id="index-projects-projtypes-list">
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
            <li><a href="projects.php?cat=<?=$TYPE['id']?>"><?=$TYPE['title']?></a></li>
            <?php
            if($cat == $TYPE['id']){
            ?> </strong> <?php
            }
        }
        ?>
    </ul>
</div>