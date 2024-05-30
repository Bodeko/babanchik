<?php
require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

if(!$login) {
    $extra = "index.php";
} else {
    $id = 0 + @$_POST['id'];
    $op = $id ? "edit" : "add";
    $pg = $id ? "edit-project.php?id=$id&" : "add-project.php?";

    $faulty_fields = array();
    if(!@$_POST["title"]){
        $faulty_fields[] = 'title';
    }
    if(!@$_POST["description"]){
        $faulty_fields[] = 'description';
    }
    if(!@$_POST["type"]){
        $faulty_fields[] = 'type';
    }
    if(!@$_POST["price"] || number_format($_POST['price'], 2) <= 0){
        $faulty_fields[] = 'price';
    }
    if(!empty($faulty_fields)){
        $extra = $pg . "missing=".join('+', $faulty_fields);
    }
    else {
        if($id) {
            $stmt = $mysqli->prepare("UPDATE Project SET title=?, description=?, projecttype_id=?, price=? WHERE id=?");
            $stmt->bind_param("ssidi", $_POST['title'], $_POST['description'], $_POST['type'], $_POST['price'], $id);
        } else {
            $stmt = $mysqli->prepare("INSERT INTO Project (`title`, `description`, `projecttype_id`, `price`, `client_id`, `sent_time`) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssiid", $_POST['title'], $_POST['description'], $_POST['type'], $_POST['price'], $login_id);
        }
        $stmt->execute();
    
        if($mysqli->errno){
            $extra = $pg.'errno='.$errno;
        }
        else{
            $extra = 'view-project.php?id='.($id?$id:$mysqli->insert_id);
        }
    
        $stmt->close();
        $mysqli->close();
    }
}

header("Location: http://$host$uri/$extra");
