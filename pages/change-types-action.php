<?php
require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$id = 0 + @$_POST['id'];

$types = array_reverse(array_keys($_POST));
array_pop($types);

$type_ids = array();
for($i = 0; $i < count($types); ++$i){
    $title = str_replace("_", " ", $types[$i]);
    $stmt = $mysqli->prepare("SELECT id FROM ProjectType WHERE title = ?;");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $type_ids[] = $stmt->get_result()->fetch_row()[0];
}

$stmt = $mysqli->prepare("DELETE FROM ParticipantsTypes WHERE participant_id = ?;");
$stmt->bind_param("i", $id);
$stmt->execute();

for($i = 0; $i < count($type_ids); ++$i) {
    $stmt = $mysqli->prepare("INSERT INTO ParticipantsTypes (participant_id, projecttype_id) VALUES (?, ?);");
    $stmt->bind_param("ii", $id, $type_ids[$i]);
    $stmt->execute();
}

header("Location: http://$host$uri/user.php");