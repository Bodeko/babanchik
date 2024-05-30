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
    if(!@$_POST["message"]){
        $faulty_fields[] = 'message';
    }
    if(!empty($faulty_fields)){
        $extra = $extra . "&missing=".join('+', $faulty_fields);
    }
    else {
        $stmt = $mysqli->prepare("INSERT INTO Commentary (`text_data`, `participant_id`, `project_id`, `sent_time`) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sii", $_POST['message'], $login_id, $id);
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
