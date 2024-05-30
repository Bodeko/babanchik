<?php
require_once("../connect/session.php");
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


$stmt = $mysqli->prepare("UPDATE Participant SET info = ? WHERE id = ?;");
$stmt->bind_param("si", $_POST['info'], $_POST['user_id']);
$stmt->execute();


header("Location: http://$host$uri/user.php");