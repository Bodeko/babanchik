<?php
require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$id = 0 + @$_POST['id'];

if(!$login || !$id) {
    $extra = "index.php";
} else {
    $extra = "view-project.php?id=$id";
    $faulty_fields = array();
    if(!@$_POST["comment_id"]){
        $faulty_fields[] = 'comment_id';
    }
    if(!empty($faulty_fields)){
        $extra = $extra . "&missing=".join('+', $faulty_fields);
    }
    else {
        $stmt = $mysqli->prepare("DELETE FROM Commentary WHERE participant_id=? AND id=?");
        $stmt->bind_param("ii", $login_id, $_POST['comment_id']);
        $stmt->execute();
    
        if($mysqli->errno){
            $extra = $extra.'&errno='.$errno;
        } else {
            $extra = $extra.'#end';
        }
    
        $stmt->close();
        $mysqli->close();
    }
}

header("Location: http://$host$uri/$extra");
