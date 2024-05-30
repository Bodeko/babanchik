<?php
require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$id = 0 + @$_POST['id'];

if(!$login || !$id) {
    $extra = "index.php";
} else {
    $extra = "view-project.php?id=$id";

    $is_delete_op = array_key_exists("delete", $_POST);
    $is_revoke_op = array_key_exists("revoke", $_POST);
    $is_finish_op = array_key_exists("finish", $_POST);

    if($is_delete_op || $is_revoke_op || $is_finish_op) {
        if($is_delete_op) {
            $stmt = $mysqli->prepare("DELETE FROM Commentary WHERE project_id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
                //  Not supposed to break.

            $stmt = $mysqli->prepare("DELETE FROM Project WHERE id=? AND client_id=?");
        } else if($is_revoke_op){
            $stmt = $mysqli->prepare("UPDATE Project SET contractor_id=NULL WHERE id=? AND client_id=?");
        } else if($is_finish_op){
            $stmt = $mysqli->prepare("UPDATE Project SET completed = TRUE WHERE id=? AND client_id=?");
        }
        $stmt->bind_param("ii", $id, $login_id);
        $stmt->execute();
    
        if($mysqli->errno){
            $extra .= '&errno='.$errno;
        } else if($is_delete_op) {
            $extra = "index.php";
        }
    
        $stmt->close();
        $mysqli->close();
    }
}

header("Location: http://$host$uri/$extra");
