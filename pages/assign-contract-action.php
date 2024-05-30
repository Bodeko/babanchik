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
    if(!@$_POST["contractor_id"]){
        $faulty_fields[] = 'contractor_id';
    }
    if(!empty($faulty_fields)){
        $extra = $extra . "&missing=".join('+', $faulty_fields);
    }
    else {
        $stmt = $mysqli->prepare("UPDATE Project SET contractor_id=? WHERE client_id=? AND id=?");
        $stmt->bind_param("iii", $_POST['contractor_id'], $login_id, $id);
        $stmt->execute();
    
        if($mysqli->errno){
            $extra = $extra.'&errno='.$errno;
        }
    
        $stmt->close();
        $mysqli->close();
    }
}

header("Location: http://$host$uri/$extra");
