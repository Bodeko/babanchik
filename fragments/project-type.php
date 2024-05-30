<select name="type" id="type" class="block-label-blue">
<?php
$result = $mysqli->query("SELECT * FROM ProjectType ORDER BY Title ASC");
while($record = mysqli_fetch_assoc($result)) {
    ?>
    <option value="<?=$record['id']?>"<?=($record['id']===$type_id)?' selected':''?>><?=$record['title']?></option>
    <?php
    }
?>
</select>
